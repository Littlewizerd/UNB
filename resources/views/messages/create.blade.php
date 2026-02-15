<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <h1 class="text-3xl font-bold text-gray-800">ส่งข้อความใหม่</h1>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('messages.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label for="recipient_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            ส่งถึง <span class="text-red-600">*</span>
                        </label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('recipient_id') border-red-500 @enderror" 
                                id="recipient_id" name="recipient_id" required>
                            <option value="">-- เลือกผู้รับข้อความ --</option>
                            @foreach($recipients as $recipient)
                                <option value="{{ $recipient->id }}" {{ old('recipient_id') == $recipient->id ? 'selected' : '' }}>
                                    {{ $recipient->name }} ({{ $recipient->role === 'admin' ? 'ผู้ดูแลระบบ' : ($recipient->role === 'teacher' ? 'ครู' : 'นักเรียน') }})
                                </option>
                            @endforeach
                        </select>
                        @error('recipient_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">
                            หัวข้อ
                        </label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('subject') border-red-500 @enderror" 
                               id="subject" name="subject" value="{{ old('subject') }}" placeholder="หัวข้อข้อความ (ไม่บังคับ)">
                        @error('subject')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
                            ข้อความ <span class="text-red-600">*</span>
                        </label>
                        <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('message') border-red-500 @enderror" 
                                  id="message" name="message" rows="8" placeholder="พิมพ์ข้อความของคุณที่นี่..." required>{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                            ส่งข้อความ
                        </button>
                        <a href="{{ route('messages.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-semibold transition">
                            ยกเลิก
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
