<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <h1 class="text-3xl font-bold text-gray-800">เพิ่มตารางเรียน</h1>
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

                <form action="{{ route('schedules.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="class_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                ชั้นเรียน <span class="text-red-600">*</span>
                            </label>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('class_id') border-red-500 @enderror" 
                                    id="class_id" name="class_id" required>
                                <option value="">-- เลือกชั้นเรียน --</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->class_name }}</option>
                                @endforeach
                            </select>
                            @error('class_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="subject_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                วิชา <span class="text-red-600">*</span>
                            </label>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('subject_id') border-red-500 @enderror" 
                                    id="subject_id" name="subject_id" required>
                                <option value="">-- เลือกวิชา --</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                                @endforeach
                            </select>
                            @error('subject_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="teacher_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                อาจารย์ <span class="text-red-600">*</span>
                            </label>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('teacher_id') border-red-500 @enderror" 
                                    id="teacher_id" name="teacher_id" required>
                                <option value="">-- เลือกอาจารย์ --</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                            @error('teacher_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="day_of_week" class="block text-sm font-semibold text-gray-700 mb-2">
                                วัน <span class="text-red-600">*</span>
                            </label>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('day_of_week') border-red-500 @enderror" 
                                    id="day_of_week" name="day_of_week" required>
                                <option value="">-- เลือกวัน --</option>
                                <option value="M" {{ old('day_of_week') == 'M' ? 'selected' : '' }}>จันทร์</option>
                                <option value="T" {{ old('day_of_week') == 'T' ? 'selected' : '' }}>อังคาร</option>
                                <option value="W" {{ old('day_of_week') == 'W' ? 'selected' : '' }}>พุธ</option>
                                <option value="TH" {{ old('day_of_week') == 'TH' ? 'selected' : '' }}>พฤหัสบดี</option>
                                <option value="F" {{ old('day_of_week') == 'F' ? 'selected' : '' }}>ศุกร์</option>
                                <option value="SA" {{ old('day_of_week') == 'SA' ? 'selected' : '' }}>เสาร์</option>
                                <option value="SU" {{ old('day_of_week') == 'SU' ? 'selected' : '' }}>อาทิตย์</option>
                            </select>
                            @error('day_of_week')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="start_time" class="block text-sm font-semibold text-gray-700 mb-2">
                                เวลาเริ่ม <span class="text-red-600">*</span>
                            </label>
                            <input type="time" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('start_time') border-red-500 @enderror" 
                                   id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                            @error('start_time')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_time" class="block text-sm font-semibold text-gray-700 mb-2">
                                เวลาสิ้นสุด <span class="text-red-600">*</span>
                            </label>
                            <input type="time" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('end_time') border-red-500 @enderror" 
                                   id="end_time" name="end_time" value="{{ old('end_time') }}" required>
                            @error('end_time')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="room" class="block text-sm font-semibold text-gray-700 mb-2">
                            ห้องเรียน
                        </label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('room') border-red-500 @enderror" 
                               id="room" name="room" value="{{ old('room') }}" placeholder="เช่น 305">
                        @error('room')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                            สร้างตารางเรียน
                        </button>
                        <a href="{{ route('schedules.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-semibold transition">
                            ยกเลิก
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
