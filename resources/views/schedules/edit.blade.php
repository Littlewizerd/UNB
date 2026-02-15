<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">แก้ไขตารางเรียน</h1>
                    <p class="text-gray-600 mt-2">แก้ไขรายละเอียดตารางเรียน</p>
                </div>
                <a href="{{ route('schedules.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    ← ย้อนกลับ
                </a>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                        <strong>❌ เกิดข้อผิดพลาด:</strong>
                        <ul class="list-disc list-inside mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('schedules.update', $schedule->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Class -->
                    <div class="mb-6">
                        <label for="class_id" class="block text-gray-700 font-bold mb-2">ชั้นเรียน</label>
                        <select id="class_id" name="class_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('class_id') border-red-500 @enderror" required>
                            <option value="">-- เลือกชั้นเรียน --</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id', $schedule->class_id) == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('class_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Subject -->
                    <div class="mb-6">
                        <label for="subject_id" class="block text-gray-700 font-bold mb-2">วิชา</label>
                        <select id="subject_id" name="subject_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('subject_id') border-red-500 @enderror" required>
                            <option value="">-- เลือกวิชา --</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ old('subject_id', $schedule->subject_id) == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('subject_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Teacher -->
                    <div class="mb-6">
                        <label for="teacher_id" class="block text-gray-700 font-bold mb-2">ครูผู้สอน</label>
                        <select id="teacher_id" name="teacher_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('teacher_id') border-red-500 @enderror" required>
                            <option value="">-- เลือกครูผู้สอน --</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('teacher_id', $schedule->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('teacher_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Day of Week -->
                    <div class="mb-6">
                        <label for="day_of_week" class="block text-gray-700 font-bold mb-2">วัน</label>
                        <select id="day_of_week" name="day_of_week" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('day_of_week') border-red-500 @enderror" required>
                            <option value="">-- เลือกวัน --</option>
                            <option value="M" {{ old('day_of_week', $schedule->day_of_week) == 'M' ? 'selected' : '' }}>จันทร์</option>
                            <option value="T" {{ old('day_of_week', $schedule->day_of_week) == 'T' ? 'selected' : '' }}>อังคาร</option>
                            <option value="W" {{ old('day_of_week', $schedule->day_of_week) == 'W' ? 'selected' : '' }}>พุธ</option>
                            <option value="TH" {{ old('day_of_week', $schedule->day_of_week) == 'TH' ? 'selected' : '' }}>พฤหัสบดี</option>
                            <option value="F" {{ old('day_of_week', $schedule->day_of_week) == 'F' ? 'selected' : '' }}>ศุกร์</option>
                            <option value="SA" {{ old('day_of_week', $schedule->day_of_week) == 'SA' ? 'selected' : '' }}>เสาร์</option>
                        </select>
                        @error('day_of_week') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Time -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="start_time" class="block text-gray-700 font-bold mb-2">เวลาเริ่ม</label>
                            <input type="time" id="start_time" name="start_time" value="{{ old('start_time', $schedule->start_time) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('start_time') border-red-500 @enderror" required>
                            @error('start_time') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="end_time" class="block text-gray-700 font-bold mb-2">เวลาสิ้นสุด</label>
                            <input type="time" id="end_time" name="end_time" value="{{ old('end_time', $schedule->end_time) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('end_time') border-red-500 @enderror" required>
                            @error('end_time') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Room -->
                    <div class="mb-8">
                        <label for="room" class="block text-gray-700 font-bold mb-2">ห้องเรียน</label>
                        <input type="text" id="room" name="room" value="{{ old('room', $schedule->room) }}" placeholder="เช่น 101" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('room') border-red-500 @enderror">
                        @error('room') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                            💾 บันทึกการแก้ไข
                        </button>
                        <a href="{{ route('schedules.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                            ยกเลิก
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
