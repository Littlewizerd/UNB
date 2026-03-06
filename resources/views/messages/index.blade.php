<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">{{ $box === 'sent' ? 'ข้อความที่ส่งแล้ว' : 'ข้อความเข้า' }}</h1>
                        @if($box === 'inbox' && $unreadCount > 0)
                            <p class="text-gray-600">มี <span class="font-bold text-red-600">{{ $unreadCount }}</span> ข้อความที่ยังไม่ได้อ่าน</p>
                        @endif
                    </div>
                    <a href="{{ route('messages.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        + ส่งข้อความ
                    </a>
                </div>

                <div class="mt-6 flex gap-2">
                    <a href="{{ route('messages.index', ['box' => 'inbox']) }}"
                       class="px-4 py-2 rounded-lg font-semibold transition {{ $box === 'inbox' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        กล่องข้อความ
                    </a>
                    <a href="{{ route('messages.index', ['box' => 'sent']) }}"
                       class="px-4 py-2 rounded-lg font-semibold transition {{ $box === 'sent' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        ส่งแล้ว
                    </a>

                    @if($box === 'inbox' && $unreadCount > 0)
                        <form action="{{ route('messages.read-all') }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="px-4 py-2 rounded-lg font-semibold transition bg-emerald-600 text-white hover:bg-emerald-700">
                                อ่านทั้งหมด
                            </button>
                        </form>
                    @endif
                </div>

                <form method="GET" action="{{ route('messages.index') }}" class="mt-4 flex flex-col gap-3 md:flex-row md:items-center">
                    <input type="hidden" name="box" value="{{ $box }}">
                    <div class="flex-1">
                        <input type="text" name="q" value="{{ $search ?? '' }}"
                               placeholder="ค้นหาจากชื่อผู้ส่ง/ผู้รับ หัวข้อ หรือเนื้อหา"
                               class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                    </div>
                    @if($box === 'inbox')
                        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                            <input type="checkbox" name="unread" value="1" {{ ($unreadOnly ?? false) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            เฉพาะยังไม่อ่าน
                        </label>
                    @endif
                    <div class="flex gap-2">
                        <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">ค้นหา</button>
                        <a href="{{ route('messages.index', ['box' => $box]) }}" class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-200">ล้าง</a>
                    </div>
                </form>
            </div>

            @if(session('success'))
                <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @php
                $undoPayload = session('messages_undo');
                $undoAvailable = is_array($undoPayload)
                    && (int) ($undoPayload['user_id'] ?? 0) === (int) auth()->id()
                    && isset($undoPayload['expires_at'])
                    && now()->lessThanOrEqualTo(\Carbon\Carbon::parse($undoPayload['expires_at']));
            @endphp

            @if($undoAvailable)
                <div class="mb-4 flex flex-wrap items-center justify-between gap-3 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-blue-800">
                    <p class="text-sm font-medium">ลบข้อความล่าสุดแล้ว ต้องการยกเลิกหรือไม่ (ภายใน 5 วินาที)</p>
                    <form action="{{ route('messages.undo-delete') }}" method="POST">
                        @csrf
                        <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                            เลิกทำการลบ
                        </button>
                    </form>
                </div>
            @endif

            @if(session('warning'))
                <div class="mb-4 rounded-lg border border-yellow-200 bg-yellow-50 px-4 py-3 text-yellow-700">
                    {{ session('warning') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <form id="bulkDeleteForm" action="{{ route('messages.bulk-destroy') }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="mb-3 flex flex-wrap items-center justify-between gap-3 rounded-lg bg-white p-4 shadow">
                    <label class="inline-flex items-center gap-2 text-sm font-medium text-gray-700">
                        <input id="selectAllMessages" type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        เลือกทั้งหมดในหน้านี้
                    </label>

                    <button id="bulkDeleteButton" type="submit" disabled
                            onclick="return confirm('ยืนยันการลบข้อความที่เลือกทั้งหมด?')"
                            class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:bg-red-300">
                        ลบที่เลือก
                    </button>
                </div>

                <!-- Messages List -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    @forelse($messages as $message)
                    <div class="border-b hover:bg-gray-50 transition p-6 flex items-start gap-4">
                        <div class="pt-1">
                            <input type="checkbox" name="message_ids[]" value="{{ $message->id }}"
                                   class="message-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        </div>
                        <div class="flex-1">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="font-semibold text-lg {{ ($box === 'inbox' && !$message->is_read) ? 'text-blue-600' : 'text-gray-800' }}">
                                        {{ $box === 'sent' ? ($message->recipient->name ?? '-') : ($message->sender->name ?? '-') }}
                                    </h3>
                                    <p class="text-gray-600 text-sm">
                                        {{ $box === 'sent' ? 'ถึง: ' : 'จาก: ' }}
                                        {{
                                            ($box === 'sent'
                                                ? (($message->recipient->role ?? '') === 'admin' ? 'ผู้ดูแลระบบ' : (($message->recipient->role ?? '') === 'teacher' ? 'ครู' : 'นักเรียน'))
                                                : (($message->sender->role ?? '') === 'admin' ? 'ผู้ดูแลระบบ' : (($message->sender->role ?? '') === 'teacher' ? 'ครู' : 'นักเรียน')))
                                        }}
                                    </p>
                                </div>
                                <span class="text-gray-500 text-sm">{{ $message->created_at->diffForHumans() }}</span>
                            </div>

                            <p class="text-gray-800 mt-2 font-semibold">{{ $message->subject ?? 'ไม่มีหัวข้อ' }}</p>
                            <p class="text-gray-600 mt-1 truncate">{{ $message->message }}</p>

                            <div class="flex gap-2 mt-4">
                                <a href="{{ route('messages.show', $message) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded text-sm transition">
                                    ดู
                                </a>
                                @if($box === 'inbox' && !$message->is_read)
                                    <form action="{{ route('messages.mark-read', $message) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded text-sm transition">
                                            ทำเครื่องหมายว่าอ่านแล้ว
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('messages.destroy', $message) }}" method="POST" style="display:inline;" 
                                      onsubmit="return confirm('ยืนยันการลบข้อความ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-1 rounded text-sm transition">
                                        ลบ
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-gray-500">
                        <p class="text-lg">ไม่มีข้อความ</p>
                    </div>
                    @endforelse
                </div>
            </form>

            <!-- Pagination -->
            @if($messages->hasPages())
                <div class="mt-6">
                    {{ $messages->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAll = document.getElementById('selectAllMessages');
            const checkboxes = Array.from(document.querySelectorAll('.message-checkbox'));
            const bulkDeleteButton = document.getElementById('bulkDeleteButton');

            const updateBulkButtonState = () => {
                const checkedCount = checkboxes.filter((checkbox) => checkbox.checked).length;
                bulkDeleteButton.disabled = checkedCount === 0;
            };

            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    checkboxes.forEach((checkbox) => {
                        checkbox.checked = this.checked;
                    });
                    updateBulkButtonState();
                });
            }

            checkboxes.forEach((checkbox) => {
                checkbox.addEventListener('change', function () {
                    const allChecked = checkboxes.length > 0 && checkboxes.every((item) => item.checked);
                    if (selectAll) {
                        selectAll.checked = allChecked;
                    }
                    updateBulkButtonState();
                });
            });

            updateBulkButtonState();
        });
    </script>
</x-app-layout>
