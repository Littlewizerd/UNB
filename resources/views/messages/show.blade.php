<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">{{ $message->subject ?? 'ไม่มีหัวข้อ' }}</h1>
                        <p class="text-gray-600 mt-2">จาก: <span class="font-semibold">{{ $message->sender->name }}</span></p>
                        <p class="text-gray-500 text-sm mt-1">{{ $message->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @if(!$message->is_read)
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">ใหม่</span>
                    @endif
                </div>
            </div>

            <!-- Message Content -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <div class="prose prose-sm max-w-none">
                    <p class="whitespace-pre-wrap text-gray-800 leading-relaxed">{{ $message->message }}</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('messages.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-semibold transition">
                        กลับไปยังข้อความ
                    </a>
                    <form action="{{ route('messages.destroy', $message) }}" method="POST" style="display:inline;" 
                          onsubmit="return confirm('ยืนยันการลบข้อความ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                            ลบข้อความ
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
