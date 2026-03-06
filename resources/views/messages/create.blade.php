<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <h1 class="text-3xl font-bold text-gray-800">ส่งข้อความใหม่</h1>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-lg shadow-lg p-8" x-data="{ sendMode: 'individual' }">
                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- ตัวเลือกโหมดส่ง (เฉพาะอาจารย์) --}}
                @if(isset($teacherClasses) && $teacherClasses->count() > 0)
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">รูปแบบการส่ง</label>
                        <div class="flex gap-4">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" x-model="sendMode" value="individual" class="form-radio text-blue-600">
                                <span class="ml-2 text-gray-700">ส่งถึงบุคคล</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" x-model="sendMode" value="class" class="form-radio text-blue-600">
                                <span class="ml-2 text-gray-700">ส่งถึงนักศึกษาทั้งชั้นเรียน</span>
                            </label>
                        </div>
                    </div>
                @endif

                {{-- ฟอร์มส่งถึงบุคคล --}}
                <form x-show="sendMode === 'individual'" action="{{ route('messages.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label for="recipient_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            ส่งถึง <span class="text-red-600">*</span>
                        </label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('recipient_id') border-red-500 @enderror" 
                                id="recipient_id" name="recipient_id">
                            <option value="">-- เลือกผู้รับข้อความ --</option>
                            @foreach($recipients as $recipient)
                                <option value="{{ $recipient->id }}" {{ (old('recipient_id', $prefillRecipientId ?? null) == $recipient->id) ? 'selected' : '' }}>
                                    {{ $recipient->name }} ({{ $recipient->role === 'admin' ? 'ผู้ดูแลระบบ' : ($recipient->role === 'teacher' ? 'อาจารย์' : 'นักศึกษา') }})
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
                               id="subject" name="subject" value="{{ old('subject', $prefillSubject ?? '') }}" placeholder="หัวข้อข้อความ (ไม่บังคับ)">
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

                {{-- ฟอร์มส่งถึงทั้งชั้นเรียน (เฉพาะอาจารย์) --}}
                @if(isset($teacherClasses) && $teacherClasses->count() > 0)
                    <form x-show="sendMode === 'class'" action="{{ route('messages.store-class') }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <label for="class_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                เลือกชั้นเรียน <span class="text-red-600">*</span>
                            </label>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('class_id') border-red-500 @enderror" 
                                    id="class_id" name="class_id">
                                <option value="">-- เลือกชั้นเรียน --</option>
                                @foreach($teacherClasses as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->class_name }} ({{ $class->class_code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('class_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="class_subject" class="block text-sm font-semibold text-gray-700 mb-2">
                                หัวข้อ
                            </label>
                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                   id="class_subject" name="subject" value="{{ old('subject') }}" placeholder="หัวข้อข้อความ (ไม่บังคับ)">
                        </div>

                        <div class="mb-6">
                            <label for="class_message" class="block text-sm font-semibold text-gray-700 mb-2">
                                ข้อความ <span class="text-red-600">*</span>
                            </label>
                            <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('message') border-red-500 @enderror" 
                                      id="class_message" name="message" rows="8" placeholder="พิมพ์ข้อความที่ต้องการส่งถึงนักศึกษาทั้งชั้นเรียน..." required>{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                                ส่งถึงทั้งชั้นเรียน
                            </button>
                            <a href="{{ route('messages.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-semibold transition">
                                ยกเลิก
                            </a>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
