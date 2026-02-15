<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of messages (inbox)
     */
    public function index(Request $request)
    {
        $messages = Message::where('recipient_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $unreadCount = Message::where('recipient_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return view('messages.index', compact('messages', 'unreadCount'));
    }

    /**
     * Show the form for creating a new message (compose)
     */
    public function create()
    {
        // Get users that can receive messages (teachers for students, students for teachers)
        $role = Auth::user()->role;
        
        if ($role === 'student') {
            $recipients = User::where('role', '!=', 'student')->get();
        } elseif ($role === 'teacher') {
            $recipients = User::where('role', '!=', 'teacher')->get();
        } else {
            // Admin can message anyone
            $recipients = User::where('id', '!=', Auth::id())->get();
        }

        return view('messages.create', compact('recipients'));
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

        Message::create([
            'sender_id' => Auth::id(),
            'recipient_id' => $request->recipient_id,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return redirect()->route('messages.index')->with('success', 'ส่งข้อความสำเร็จ');
    }

    /**
     * Display the specified message
     */
    public function show(Message $message)
    {
        // Mark as read if the current user is the recipient
        if ($message->recipient_id === Auth::id() && !$message->is_read) {
            $message->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }

        return view('messages.show', compact('message'));
    }

    /**
     * Mark message as read
     */
    public function markAsRead(Message $message)
    {
        if ($message->recipient_id === Auth::id()) {
            $message->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }

        return back()->with('success', 'ทำเครื่องหมายว่าอ่านแล้ว');
    }

    /**
     * Delete the specified message
     */
    public function destroy(Message $message)
    {
        // Only allow recipient or admin to delete
        if ($message->recipient_id === Auth::id() || Auth::user()->role === 'admin') {
            $message->delete();
            return back()->with('success', 'ลบข้อความสำเร็จ');
        }

        return back()->with('error', 'ไม่มีสิทธิ์ลบข้อความนี้');
    }

    /**
     * Get unread message count (for use in views)
     */
    public static function getUnreadCount()
    {
        return Message::where('recipient_id', Auth::id())
            ->where('is_read', false)
            ->count();
    }
}
