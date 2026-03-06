<x-app-layout>
    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h1 class="text-2xl font-bold text-emerald-700">📋 บันทึกการเข้าเรียน (อาจารย์)</h1>
                <p class="text-gray-500 mt-1">
                    วันที่ <span class="font-semibold text-gray-700">{{ \Carbon\Carbon::today()->locale('th')->translatedFormat('l j F Y') }}</span>
                    — อาจารย์ <span class="font-semibold text-emerald-700">{{ $teacher->name ?? '-' }}</span>
                </p>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-800 px-4 py-3 rounded mb-4">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-800 px-4 py-3 rounded mb-4">
                    <ul class="list-disc pl-4">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Schedule Cards --}}
            @if($schedules->count() > 0)
                <div class="space-y-6">
                    @foreach($schedules as $schedule)
                        @php
                            $students = $schedule->studentClass->students ?? collect();
                            $existingRecords = $todayAttendances[$schedule->id] ?? collect();
                            $recorded = $existingRecords->pluck('status', 'student_id');
                            $isAlreadyRecorded = $recorded->isNotEmpty();
                        @endphp

                        <div x-data="{ open: {{ $isAlreadyRecorded ? 'true' : 'false' }}, markAll: '' }" class="bg-white rounded-lg shadow-md overflow-hidden border {{ $isAlreadyRecorded ? 'border-green-300' : 'border-gray-200' }}">

                            {{-- Schedule Header --}}
                            <div class="p-5 flex flex-col md:flex-row md:items-center md:justify-between cursor-pointer hover:bg-gray-50 transition" @click="open = !open">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-emerald-100 text-emerald-700 font-bold text-sm px-3 py-1 rounded">
                                            {{ $schedule->subject->subject_code ?? '-' }}
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-800">{{ $schedule->subject->name ?? '-' }}</h3>
                                        @if($isAlreadyRecorded)
                                            <span class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded-full font-semibold">✅ บันทึกแล้ว</span>
                                        @endif
                                    </div>
                                    <div class="flex flex-wrap gap-4 mt-2 text-sm text-gray-600">
                                        <span>🏫 ชั้น {{ $schedule->studentClass->class_name ?? '-' }}</span>
                                        <span>🕐 {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</span>
                                        <span>📍 ห้อง {{ $schedule->room ?? '-' }}</span>
                                        <span>👥 {{ $students->count() }} คน</span>
                                    </div>
                                </div>
                                <div class="mt-2 md:mt-0">
                                    <svg :class="{ 'rotate-180': open }" class="w-6 h-6 text-gray-400 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>

                            {{-- Student Attendance Form --}}
                            <div x-show="open" x-transition class="border-t border-gray-200">
                                <form action="{{ route('teacher.record-attendance') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

                                    {{-- Quick Actions --}}
                                    <div class="px-5 py-3 bg-gray-50 border-b border-gray-200 flex flex-wrap items-center gap-3">
                                        <span class="text-sm font-semibold text-gray-600">⚡ เลือกทั้งหมด:</span>
                                        <button type="button" @click="document.querySelectorAll('[data-schedule=\'{{ $schedule->id }}\'] select').forEach(s => s.value = 'present')"
                                                class="bg-green-100 text-green-700 hover:bg-green-200 px-3 py-1 rounded text-xs font-bold transition">
                                            ✅ มาเรียนทุกคน
                                        </button>
                                        <button type="button" @click="document.querySelectorAll('[data-schedule=\'{{ $schedule->id }}\'] select').forEach(s => s.value = 'absent')"
                                                class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1 rounded text-xs font-bold transition">
                                            ❌ ขาดทุกคน
                                        </button>
                                    </div>

                                    {{-- Students Table --}}
                                    <div class="overflow-x-auto" data-schedule="{{ $schedule->id }}">
                                        <table class="w-full text-sm">
                                            <thead>
                                                <tr class="bg-emerald-600 text-white">
                                                    <th class="px-4 py-2.5 text-center font-bold w-12">#</th>
                                                    <th class="px-4 py-2.5 text-left font-bold">รหัสนักศึกษา</th>
                                                    <th class="px-4 py-2.5 text-left font-bold">ชื่อ-สกุล</th>
                                                    <th class="px-4 py-2.5 text-center font-bold w-44">สถานะ</th>
                                                    <th class="px-4 py-2.5 text-left font-bold w-48">หมายเหตุ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($students as $idx => $student)
                                                    @php
                                                        $currentStatus = $recorded[$student->id] ?? '';
                                                        $rowColor = match($currentStatus) {
                                                            'present' => 'bg-green-50',
                                                            'late' => 'bg-yellow-50',
                                                            'absent' => 'bg-red-50',
                                                            'excused' => 'bg-blue-50',
                                                            default => ($idx % 2 == 0 ? 'bg-white' : 'bg-gray-50'),
                                                        };
                                                    @endphp
                                                    <tr class="{{ $rowColor }} hover:bg-gray-100 transition border-b border-gray-200">
                                                        <td class="px-4 py-2.5 text-center text-gray-500 font-medium">{{ $idx + 1 }}</td>
                                                        <td class="px-4 py-2.5 text-gray-700 font-mono text-xs">{{ $student->student_id ?? '-' }}</td>
                                                        <td class="px-4 py-2.5 font-semibold text-gray-800">{{ $student->name }}</td>
                                                        <td class="px-4 py-2.5 text-center">
                                                            <input type="hidden" name="attendances[{{ $idx }}][student_id]" value="{{ $student->id }}">
                                                            <select name="attendances[{{ $idx }}][status]" required
                                                                    class="w-full border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500 py-1.5 {{ $currentStatus ? '' : 'text-gray-400' }}">
                                                                <option value="" {{ !$currentStatus ? 'selected' : '' }}>-- เลือก --</option>
                                                                <option value="present" {{ $currentStatus == 'present' ? 'selected' : '' }}>✅ มาเรียน</option>
                                                                <option value="late" {{ $currentStatus == 'late' ? 'selected' : '' }}>⚠️ มาสาย</option>
                                                                <option value="absent" {{ $currentStatus == 'absent' ? 'selected' : '' }}>❌ ขาดเรียน</option>
                                                                <option value="excused" {{ $currentStatus == 'excused' ? 'selected' : '' }}>📝 ลากิจ/ป่วย</option>
                                                            </select>
                                                        </td>
                                                        <td class="px-4 py-2.5">
                                                            <input type="text" name="attendances[{{ $idx }}][notes]"
                                                                   placeholder="หมายเหตุ..."
                                                                   value="{{ $existingRecords->where('student_id', $student->id)->first()?->notes ?? '' }}"
                                                                   class="w-full border-gray-300 rounded-lg text-xs focus:ring-emerald-500 focus:border-emerald-500 py-1.5">
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="px-6 py-6 text-center text-gray-400">ไม่พบนักศึกษาในชั้นเรียนนี้</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    {{-- Submit Button --}}
                                    @if($students->count() > 0)
                                        <div class="px-5 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                                            <p class="text-xs text-gray-500">
                                                นักศึกษาทั้งหมด {{ $students->count() }} คน
                                                @if($isAlreadyRecorded)
                                                    — <span class="text-green-600 font-semibold">บันทึกแล้ว {{ $recorded->count() }}/{{ $students->count() }} คน</span>
                                                @endif
                                            </p>
                                            <button type="submit"
                                                    class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-2.5 rounded-lg shadow transition flex items-center gap-2">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                {{ $isAlreadyRecorded ? '💾 อัปเดตการบันทึก' : '💾 บันทึกการเข้าเรียน' }}
                                            </button>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <div class="text-gray-300 mb-4">
                        <svg class="mx-auto h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <p class="text-gray-500 text-lg font-semibold">ไม่มีตารางสอนในวันนี้</p>
                    <p class="text-gray-400 text-sm mt-1">ตรวจสอบตารางสอนของคุณที่หน้าตารางสอน</p>
                </div>
            @endif

            {{-- Legend / How it works --}}
            <div class="bg-white rounded-lg shadow-md p-5 mt-6">
                <h3 class="text-sm font-bold text-gray-700 mb-3">📌 วิธีการบันทึกการเข้าเรียน</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-gray-600">
                    <div>
                        <p class="font-semibold text-gray-700 mb-1">สถานะที่เลือกได้:</p>
                        <ul class="space-y-1">
                            <li class="flex items-center gap-2"><span class="w-3 h-3 rounded bg-green-500 inline-block"></span> <strong>มาเรียน</strong> — นักศึกษามาเรียนปกติ</li>
                            <li class="flex items-center gap-2"><span class="w-3 h-3 rounded bg-yellow-500 inline-block"></span> <strong>มาสาย</strong> — มาหลังเวลาเริ่มเรียน</li>
                            <li class="flex items-center gap-2"><span class="w-3 h-3 rounded bg-red-500 inline-block"></span> <strong>ขาดเรียน</strong> — ไม่มาเรียน</li>
                            <li class="flex items-center gap-2"><span class="w-3 h-3 rounded bg-blue-500 inline-block"></span> <strong>ลากิจ/ป่วย</strong> — แจ้งลาล่วงหน้า</li>
                        </ul>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-700 mb-1">หมายเหตุ:</p>
                        <ul class="space-y-1 list-disc pl-4">
                            <li>กด "เลือกทั้งหมด" เพื่อตั้งสถานะให้ทุกคนพร้อมกัน แล้วแก้เฉพาะคน</li>
                            <li>สามารถบันทึกซ้ำได้ (ระบบจะอัปเดตสถานะล่าสุด)</li>
                            <li>ช่องหมายเหตุใช้ระบุรายละเอียดเพิ่มเติม เช่น "ป่วย" "ลากิจ"</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
