<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">ข้อความ</h1>
                        @if($unreadCount > 0)
                            <p class="text-gray-600">มี <span class="font-bold text-red-600">{{ $unreadCount }}</span> ข้อความที่ยังไม่ได้อ่าน</p>
                        @endif
                    </div>
                    <a href="{{ route('messages.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        + ส่งข้อความ
                    </a>
                </div>
            </div>

            <!-- Messages List -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                @forelse($messages as $message)
                    <div class="border-b hover:bg-gray-50 transition p-6 flex items-start gap-4">
                        <div class="flex-1">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="font-semibold text-lg {{ !$message->is_read ? 'text-blue-600' : 'text-gray-800' }}">
                                        {{ $message->sender->name }}
                                    </h3>
                                    <p class="text-gray-600 text-sm">{{ $message->sender->role === 'admin' ? 'ผู้ดูแลระบบ' : ($message->sender->role === 'teacher' ? 'ครู' : 'นักเรียน') }}</p>
                                </div>
                                <span class="text-gray-500 text-sm">{{ $message->created_at->diffForHumans() }}</span>
                            </div>

                            <p class="text-gray-800 mt-2 font-semibold">{{ $message->subject ?? 'ไม่มีหัวข้อ' }}</p>
                            <p class="text-gray-600 mt-1 truncate">{{ $message->message }}</p>

                            <div class="flex gap-2 mt-4">
                                <a href="{{ route('messages.show', $message) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded text-sm transition">
                                    ดู
                                </a>
                                @if(!$message->is_read)
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

            <!-- Pagination -->
            @if($messages->hasPages())
                <div class="mt-6">
                    {{ $messages->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
