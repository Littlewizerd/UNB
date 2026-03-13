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
                                    {{ $class->class_name }}
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
                            <select id="start_time" name="start_time" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('start_time') border-red-500 @enderror" required>
                                <option value="">-- เลือกเวลา --</option>
                                @for ($h = 7; $h <= 20; $h++)
                                    @foreach (['00', '30'] as $m)
                                        @php $t = str_pad($h, 2, '0', STR_PAD_LEFT) . ':' . $m; @endphp
                                        <option value="{{ $t }}" {{ old('start_time', \Carbon\Carbon::parse($schedule->start_time)->format('H:i')) == $t ? 'selected' : '' }}>{{ $t }} น.</option>
                                    @endforeach
                                @endfor
                            </select>
                            @error('start_time') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="end_time" class="block text-gray-700 font-bold mb-2">เวลาสิ้นสุด</label>
                            <select id="end_time" name="end_time" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('end_time') border-red-500 @enderror" required>
                                <option value="">-- เลือกเวลา --</option>
                                @for ($h = 7; $h <= 20; $h++)
                                    @foreach (['00', '30'] as $m)
                                        @php $t = str_pad($h, 2, '0', STR_PAD_LEFT) . ':' . $m; @endphp
                                        <option value="{{ $t }}" {{ old('end_time', \Carbon\Carbon::parse($schedule->end_time)->format('H:i')) == $t ? 'selected' : '' }}>{{ $t }} น.</option>
                                    @endforeach
                                @endfor
                            </select>
                            @error('end_time') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Room -->
                    <div class="mb-8">
                        <label for="room" class="block text-gray-700 font-bold mb-2">ห้องเรียน <span class="text-red-600">*</span></label>
                        <select id="room" name="room" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('room') border-red-500 @enderror" required>
                            <option value="">-- เลือกห้องเรียน --</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room }}" {{ old('room', $schedule->room) === $room ? 'selected' : '' }}>{{ $room }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-2">ห้องที่ถูกใช้งานในช่วงเวลานี้จะเป็นสีเทาและไม่สามารถเลือกได้</p>
                        @error('room') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-8">
                        <label for="semester_id" class="block text-gray-700 font-bold mb-2">ภาคเรียน / ปีการศึกษา <span class="text-red-600">*</span></label>
                        <select id="semester_id" name="semester_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('semester_id') border-red-500 @enderror" required>
                            <option value="">-- เลือกภาคเรียน --</option>
                            @foreach($semesters as $sem)
                                <option value="{{ $sem->id }}" {{ old('semester_id', $schedule->semester_id) == $sem->id ? 'selected' : '' }}>
                                    {{ $sem->name }} (พ.ศ. {{ $sem->year }})
                                </option>
                            @endforeach
                        </select>
                        @error('semester_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dayField = document.getElementById('day_of_week');
            const startField = document.getElementById('start_time');
            const endField = document.getElementById('end_time');
            const semesterField = document.getElementById('semester_id');
            const roomField = document.getElementById('room');
            const baseOptions = Array.from(roomField.options).map(option => ({ value: option.value, label: option.textContent }));
            const currentScheduleId = '{{ $schedule->id }}';

            const refreshRooms = async () => {
                const params = new URLSearchParams({
                    day_of_week: dayField.value,
                    start_time: startField.value,
                    end_time: endField.value,
                    semester_id: semesterField.value,
                    exclude_schedule_id: currentScheduleId,
                });

                const response = await fetch(`{{ route('schedules.available-rooms') }}?${params.toString()}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                if (!response.ok) {
                    return;
                }

                const data = await response.json();
                const availabilityMap = new Map((data.rooms || []).map(room => [room.name, room.available]));
                const selectedValue = roomField.value;

                roomField.innerHTML = '';

                baseOptions.forEach(optionData => {
                    const option = document.createElement('option');
                    option.value = optionData.value;

                    if (!optionData.value) {
                        option.textContent = optionData.label;
                        roomField.appendChild(option);
                        return;
                    }

                    const available = availabilityMap.has(optionData.value) ? availabilityMap.get(optionData.value) : true;
                    option.textContent = available ? optionData.label : `${optionData.label} (ไม่ว่าง)`;
                    option.disabled = !available;
                    option.selected = optionData.value === selectedValue && available;
                    roomField.appendChild(option);
                });

                if (selectedValue && roomField.value !== selectedValue) {
                    roomField.value = '';
                }
            };

            [dayField, startField, endField, semesterField].forEach(field => {
                field.addEventListener('change', refreshRooms);
            });

            refreshRooms();
        });
    </script>
</x-app-layout>
