<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <h1 class="text-3xl font-bold text-gray-800">เพิ่มตารางชดเชย</h1>
                <p class="text-gray-600 mt-2">สำหรับอาจารย์และนักศึกษาในรายวิชาที่เกี่ยวข้อง</p>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

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

                <form action="{{ route('makeup-schedules.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="class_id" class="block text-sm font-semibold text-gray-700 mb-2">ชั้นเรียน <span class="text-red-600">*</span></label>
                            <select id="class_id" name="class_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('class_id') border-red-500 @enderror" required>
                                <option value="">-- เลือกชั้นเรียน --</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->class_name }} ({{ $class->class_code }})</option>
                                @endforeach
                            </select>
                            @error('class_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="subject_id" class="block text-sm font-semibold text-gray-700 mb-2">วิชา <span class="text-red-600">*</span></label>
                            <select id="subject_id" name="subject_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('subject_id') border-red-500 @enderror" required>
                                <option value="">-- เลือกวิชา --</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->subject_code }} - {{ $subject->name }}</option>
                                @endforeach
                            </select>
                            @error('subject_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="makeup_date" class="block text-sm font-semibold text-gray-700 mb-2">วันที่ชดเชย <span class="text-red-600">*</span></label>
                            <input type="date" id="makeup_date" name="makeup_date" value="{{ old('makeup_date') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('makeup_date') border-red-500 @enderror" required>
                            @error('makeup_date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="semester_id" class="block text-sm font-semibold text-gray-700 mb-2">ภาคเรียน / ปีการศึกษา <span class="text-red-600">*</span></label>
                            <select id="semester_id" name="semester_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('semester_id') border-red-500 @enderror" required>
                                <option value="">-- เลือกภาคเรียน --</option>
                                @foreach($semesters as $semester)
                                    <option value="{{ $semester->id }}" {{ old('semester_id') == $semester->id ? 'selected' : '' }}>{{ $semester->name }} (พ.ศ. {{ $semester->year }})</option>
                                @endforeach
                            </select>
                            @error('semester_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="start_time" class="block text-sm font-semibold text-gray-700 mb-2">เวลาเริ่ม <span class="text-red-600">*</span></label>
                            <select id="start_time" name="start_time" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('start_time') border-red-500 @enderror" required>
                                <option value="">-- เลือกเวลา --</option>
                                @for ($h = 7; $h <= 22; $h++)
                                    @foreach (['00', '30'] as $m)
                                        @php $t = str_pad($h, 2, '0', STR_PAD_LEFT) . ':' . $m; @endphp
                                        <option value="{{ $t }}" {{ old('start_time') == $t ? 'selected' : '' }}>{{ $t }} น.</option>
                                    @endforeach
                                @endfor
                            </select>
                            @error('start_time') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="end_time" class="block text-sm font-semibold text-gray-700 mb-2">เวลาสิ้นสุด <span class="text-red-600">*</span></label>
                            <select id="end_time" name="end_time" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('end_time') border-red-500 @enderror" required>
                                <option value="">-- เลือกเวลา --</option>
                                @for ($h = 7; $h <= 22; $h++)
                                    @foreach (['00', '30'] as $m)
                                        @php $t = str_pad($h, 2, '0', STR_PAD_LEFT) . ':' . $m; @endphp
                                        <option value="{{ $t }}" {{ old('end_time') == $t ? 'selected' : '' }}>{{ $t }} น.</option>
                                    @endforeach
                                @endfor
                            </select>
                            @error('end_time') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="room" class="block text-sm font-semibold text-gray-700 mb-2">ห้องเรียน <span class="text-red-600">*</span></label>
                            <select id="room" name="room" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('room') border-red-500 @enderror" required>
                                <option value="">-- เลือกห้องเรียน --</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room }}" {{ old('room') === $room ? 'selected' : '' }}>{{ $room }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-2">ห้องที่ไม่ว่างในช่วงเวลานี้จะเป็นสีเทาและไม่สามารถเลือกได้</p>
                            @error('room') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="teacher_id" class="block text-sm font-semibold text-gray-700 mb-2">อาจารย์ผู้สอน <span class="text-red-600">*</span></label>
                            @if($selectedTeacherId)
                                <input type="hidden" name="teacher_id" value="{{ $selectedTeacherId }}">
                                <div class="w-full px-4 py-2 border border-gray-200 bg-gray-50 rounded-lg text-gray-700">
                                    {{ $teachers->first()->name ?? auth()->user()->name }}
                                </div>
                            @else
                                <select id="teacher_id" name="teacher_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('teacher_id') border-red-500 @enderror" required>
                                    <option value="">-- เลือกอาจารย์ --</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                            @error('teacher_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">หมายเหตุ</label>
                        <textarea id="notes" name="notes" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg @error('notes') border-red-500 @enderror" placeholder="เช่น ชดเชยวันหยุดราชการ / ห้องสอบย่อย">{{ old('notes') }}</textarea>
                        @error('notes') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-semibold transition">บันทึกตารางชดเชย</button>
                        <a href="{{ route(auth()->user()->role === 'teacher' ? 'makeup-schedules.teacher-schedule' : 'makeup-schedules.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-semibold transition">ยกเลิก</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const dateField = document.getElementById('makeup_date');
            const startField = document.getElementById('start_time');
            const endField = document.getElementById('end_time');
            const semesterField = document.getElementById('semester_id');
            const roomField = document.getElementById('room');
            const baseOptions = Array.from(roomField.options).map(option => ({ value: option.value, label: option.textContent }));

            const refreshRooms = async () => {
                const params = new URLSearchParams({
                    makeup_date: dateField.value,
                    start_time: startField.value,
                    end_time: endField.value,
                    semester_id: semesterField.value,
                });

                const response = await fetch(`{{ route('makeup-schedules.available-rooms') }}?${params.toString()}`, {
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

            [dateField, startField, endField, semesterField].forEach(field => {
                field.addEventListener('change', refreshRooms);
            });

            refreshRooms();
        });
    </script>
</x-app-layout>
