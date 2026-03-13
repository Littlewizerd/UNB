<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class MessageController extends Controller
{
    /**
     * Display a listing of messages (inbox)
     */
    public function index(Request $request)
    {
        $box = $request->query('box', 'inbox');
        if (!in_array($box, ['inbox', 'sent'], true)) {
            $box = 'inbox';
        }

        $search = trim((string) $request->query('q', ''));
        $unreadOnly = $request->boolean('unread');

        $query = Message::with(['sender:id,name,role', 'recipient:id,name,role'])
            ->orderBy('created_at', 'desc');

        if ($box === 'sent') {
            $query->where('sender_id', Auth::id())
                ->whereNull('sender_deleted_at');
        } else {
            $query->where('recipient_id', Auth::id())
                ->whereNull('recipient_deleted_at');
            if ($unreadOnly) {
                $query->where('is_read', false);
            }
        }

        if ($search !== '') {
            $query->where(function ($builder) use ($search, $box) {
                if ($box === 'sent') {
                    $builder->whereHas('recipient', function ($recipientQuery) use ($search) {
                        $recipientQuery->where('name', 'like', "%{$search}%");
                    });
                } else {
                    $builder->whereHas('sender', function ($senderQuery) use ($search) {
                        $senderQuery->where('name', 'like', "%{$search}%");
                    });
                }

                $builder->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $messages = $query->paginate(15)->withQueryString();

        $unreadCount = Message::where('recipient_id', Auth::id())
            ->whereNull('recipient_deleted_at')
            ->where('is_read', false)
            ->count();

        return view('messages.index', compact('messages', 'unreadCount', 'box', 'search', 'unreadOnly'));
    }

    /**
     * Show the form for creating a new message (compose)
     */
    public function create(Request $request)
    {
        // Get users that can receive messages (teachers for students, students for teachers)
        $role = Auth::user()->role;
        
        if ($role === 'student') {
            $recipients = User::where('role', '!=', 'student')
                ->where('id', '!=', Auth::id())
                ->select(['id', 'name', 'role'])
                ->get();
        } elseif ($role === 'teacher') {
            $recipients = User::where('role', '!=', 'teacher')
                ->where('id', '!=', Auth::id())
                ->select(['id', 'name', 'role'])
                ->get();
        } else {
            // Admin can message anyone
            $recipients = User::where('id', '!=', Auth::id())
                ->select(['id', 'name', 'role'])
                ->get();
        }

        $prefillRecipientId = $request->query('recipient_id');
        $prefillSubject = $request->query('subject');

        if ($prefillRecipientId && !$recipients->contains('id', (int) $prefillRecipientId)) {
            $prefillRecipientId = null;
        }

        // สำหรับอาจารย์: ดึงชั้นเรียนที่สอน
        $teacherClasses = collect();
        if ($role === 'teacher') {
            $classIds = Schedule::where('teacher_id', Auth::id())
                ->distinct()
                ->pluck('class_id');
            $teacherClasses = StudentClass::whereIn('id', $classIds)
                ->orderBy('class_name')
                ->get(['id', 'class_name', 'class_code']);
        }

        return view('messages.create', compact('recipients', 'prefillRecipientId', 'prefillSubject', 'teacherClasses'));
    }

    /**
     * Store a newly created message
     */
    public function store(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:1',
        ]);

        $recipient = User::findOrFail($request->recipient_id);

        if ((int) $recipient->id === (int) Auth::id()) {
            return back()->withErrors([
                'recipient_id' => 'ไม่สามารถส่งข้อความถึงตัวเองได้',
            ])->withInput();
        }

        if (!$this->canSendToRecipient(Auth::user(), $recipient)) {
            return back()->withErrors([
                'recipient_id' => 'ไม่มีสิทธิ์ส่งข้อความถึงผู้รับรายนี้',
            ])->withInput();
        }

        Message::create([
            'sender_id' => Auth::id(),
            'recipient_id' => $recipient->id,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return redirect()->route('messages.index')->with('success', 'ส่งข้อความสำเร็จ');
    }

    /**
     * ส่งข้อความถึงนักศึกษาทั้งชั้นเรียน (สำหรับอาจารย์)
     */
    public function storeClassMessage(Request $request)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['teacher', 'admin'])) {
            abort(403, 'เฉพาะอาจารย์เท่านั้นที่สามารถส่งข้อความถึงทั้งชั้นเรียนได้');
        }

        $request->validate([
            'class_id' => 'required|exists:student_classes,id',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:1',
        ]);

        // ตรวจสอบว่าอาจารย์สอนชั้นเรียนนี้จริง
        if ($user->role === 'teacher') {
            $teachesClass = Schedule::where('teacher_id', $user->id)
                ->where('class_id', $request->class_id)
                ->exists();

            if (!$teachesClass) {
                return back()->withErrors([
                    'class_id' => 'คุณไม่ได้สอนชั้นเรียนนี้',
                ])->withInput();
            }
        }

        // ดึงนักศึกษาทั้งหมดในชั้นเรียน
        $students = Student::where('class_id', $request->class_id)->get();

        if ($students->isEmpty()) {
            return back()->withErrors([
                'class_id' => 'ไม่พบนักศึกษาในชั้นเรียนนี้',
            ])->withInput();
        }

        $count = 0;
        foreach ($students as $student) {
            Message::create([
                'sender_id' => Auth::id(),
                'recipient_id' => $student->id,
                'subject' => $request->subject,
                'message' => $request->message,
            ]);
            $count++;
        }

        return redirect()->route('messages.index')->with('success', "ส่งข้อความถึงนักศึกษาทั้งชั้นเรียนสำเร็จ ({$count} คน)");
    }

    /**
     * Display the specified message
     */
    public function show(Message $message)
    {
        $user = Auth::user();

        $canView = (int) $message->recipient_id === (int) $user->id
            || (int) $message->sender_id === (int) $user->id
            || $user->role === 'admin';

        if ($canView && $user->role !== 'admin') {
            if ((int) $message->recipient_id === (int) $user->id && $message->recipient_deleted_at !== null) {
                $canView = false;
            }

            if ((int) $message->sender_id === (int) $user->id && $message->sender_deleted_at !== null) {
                $canView = false;
            }
        }

        if (!$canView) {
            abort(403, 'ไม่มีสิทธิ์เข้าถึงข้อความนี้');
        }

        // Mark as read if the current user is the recipient
        if ($message->recipient_id === Auth::id() && !$message->is_read) {
            $message->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }

        $message->loadMissing(['sender:id,name,role', 'recipient:id,name,role']);

        return view('messages.show', compact('message'));
    }

    /**
     * Mark message as read
     */
    public function markAsRead(Message $message)
    {
        if ((int) $message->recipient_id === (int) Auth::id() && $message->recipient_deleted_at === null) {
            $message->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }

        return back()->with('success', 'ทำเครื่องหมายว่าอ่านแล้ว');
    }

    public function markAllAsRead()
    {
        $affected = Message::where('recipient_id', Auth::id())
            ->whereNull('recipient_deleted_at')
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        if ($affected === 0) {
            return back()->with('warning', 'ไม่มีข้อความใหม่ให้ทำเครื่องหมาย');
        }

        return back()->with('success', "ทำเครื่องหมายอ่านแล้ว {$affected} ข้อความ");
    }

    /**
     * Delete the specified message
     */
    public function destroy(Message $message)
    {
        $user = Auth::user();

        if ($this->canDeleteMessage($user, $message)) {
            $undoPayload = $this->buildUndoPayload($user, $message);

            $this->deleteForUser($user, $message);

            if ($undoPayload !== null) {
                session(['messages_undo' => $undoPayload]);
            } else {
                session()->forget('messages_undo');
            }

            return back()->with('success', 'ลบข้อความสำเร็จ');
        }

        return back()->with('error', 'ไม่มีสิทธิ์ลบข้อความนี้');
    }

    public function bulkDestroy(Request $request)
    {
        $validated = $request->validate([
            'message_ids' => 'required|array|min:1',
            'message_ids.*' => 'required|integer|exists:messages,id',
        ]);

        $user = Auth::user();
        $messages = Message::whereIn('id', $validated['message_ids'])->get();

        $deletableIds = $messages
            ->filter(fn (Message $message) => $this->canDeleteMessage($user, $message))
            ->pluck('id')
            ->all();

        if (count($deletableIds) === 0) {
            return back()->with('error', 'ไม่พบข้อความที่คุณมีสิทธิ์ลบ');
        }

        foreach ($messages as $message) {
            if (in_array((int) $message->id, $deletableIds, true)) {
                $this->deleteForUser($user, $message);
            }
        }

        $deletedCount = count($deletableIds);
        $skippedCount = count($validated['message_ids']) - $deletedCount;

        if ($skippedCount > 0) {
            return back()
                ->with('success', "ลบข้อความสำเร็จ {$deletedCount} รายการ")
                ->with('warning', "มี {$skippedCount} รายการที่ไม่มีสิทธิ์ลบ");
        }

        return back()->with('success', "ลบข้อความสำเร็จ {$deletedCount} รายการ");
    }

    public function undoDelete(Request $request)
    {
        $undo = $request->session()->get('messages_undo');

        if (!is_array($undo) || (int) ($undo['user_id'] ?? 0) !== (int) Auth::id()) {
            return back()->with('warning', 'ไม่พบรายการลบล่าสุดที่สามารถยกเลิกได้');
        }

        $expiresAt = isset($undo['expires_at']) ? Carbon::parse($undo['expires_at']) : null;
        if ($expiresAt === null || now()->greaterThan($expiresAt)) {
            $request->session()->forget('messages_undo');
            return back()->with('warning', 'หมดเวลายกเลิกการลบแล้ว');
        }

        $message = Message::find($undo['message_id'] ?? 0);
        if (!$message) {
            $request->session()->forget('messages_undo');
            return back()->with('warning', 'ไม่สามารถกู้คืนข้อความนี้ได้');
        }

        $side = $undo['side'] ?? null;
        if ($side === 'sender' && (int) $message->sender_id === (int) Auth::id()) {
            $message->sender_deleted_at = null;
        } elseif ($side === 'recipient' && (int) $message->recipient_id === (int) Auth::id()) {
            $message->recipient_deleted_at = null;
        } else {
            $request->session()->forget('messages_undo');
            return back()->with('warning', 'ไม่สามารถยกเลิกการลบรายการนี้ได้');
        }

        $message->save();
        $request->session()->forget('messages_undo');

        return back()->with('success', 'ยกเลิกการลบข้อความสำเร็จ');
    }

    /**
     * Get unread message count (for use in views)
     */
    public static function getUnreadCount()
    {
        return Message::where('recipient_id', Auth::id())
            ->whereNull('recipient_deleted_at')
            ->where('is_read', false)
            ->count();
    }

    /**
     * Return unread message count as JSON (for real-time polling)
     */
    public function notificationsCount()
    {
        $count = Message::where('recipient_id', Auth::id())
            ->whereNull('recipient_deleted_at')
            ->where('is_read', false)
            ->count();

        return response()->json(['unread_messages' => $count]);
    }

    private function canSendToRecipient(User $sender, User $recipient): bool
    {
        if ($sender->role === 'admin') {
            return true;
        }

        if ($sender->role === 'student') {
            return $recipient->role !== 'student';
        }

        if ($sender->role === 'teacher') {
            return $recipient->role !== 'teacher';
        }

        return false;
    }

    private function canDeleteMessage(User $user, Message $message): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ((int) $message->recipient_id === (int) $user->id) {
            return $message->recipient_deleted_at === null;
        }

        if ((int) $message->sender_id === (int) $user->id) {
            return $message->sender_deleted_at === null;
        }

        return false;
    }

    private function deleteForUser(User $user, Message $message): void
    {
        if ($user->role === 'admin') {
            $message->sender_deleted_at = now();
            $message->recipient_deleted_at = now();
            $message->save();

            $message->delete();
            return;
        }

        if ((int) $message->sender_id === (int) $user->id && $message->sender_deleted_at === null) {
            $message->sender_deleted_at = now();
        }

        if ((int) $message->recipient_id === (int) $user->id && $message->recipient_deleted_at === null) {
            $message->recipient_deleted_at = now();
        }

        $message->save();

        if ($message->sender_deleted_at !== null && $message->recipient_deleted_at !== null) {
            $message->delete();
        }
    }

    private function buildUndoPayload(User $user, Message $message): ?array
    {
        if ($user->role === 'admin') {
            return null;
        }

        if ((int) $message->sender_id === (int) $user->id) {
            if ($message->sender_deleted_at !== null || $message->recipient_deleted_at !== null) {
                return null;
            }

            return [
                'user_id' => $user->id,
                'message_id' => $message->id,
                'side' => 'sender',
                'expires_at' => now()->addSeconds(5)->toDateTimeString(),
            ];
        }

        if ((int) $message->recipient_id === (int) $user->id) {
            if ($message->recipient_deleted_at !== null || $message->sender_deleted_at !== null) {
                return null;
            }

            return [
                'user_id' => $user->id,
                'message_id' => $message->id,
                'side' => 'recipient',
                'expires_at' => now()->addSeconds(5)->toDateTimeString(),
            ];
        }

        return null;
    }
}
