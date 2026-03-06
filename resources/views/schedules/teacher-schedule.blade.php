<x-app-layout>
    <div class="py-6">
        <div class="max-w-[1400px] mx-auto sm:px-6 lg:px-8">

            {{-- ===== Header: Teacher Info ===== --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h1 class="text-2xl font-bold text-emerald-700 mb-4">📅 ตารางสอนของอาจารย์</h1>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-1 text-sm text-gray-700">
                    <div class="flex">
                        <span class="font-semibold w-28 text-gray-600">ชื่อ</span>
                        <span class="font-bold text-emerald-800">{{ $teacher->name ?? '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="font-semibold w-28 text-gray-600">รหัสอาจารย์</span>
                        <span>{{ $teacher->teacher_id ?? '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="font-semibold w-28 text-gray-600">อีเมล</span>
                        <span>{{ $teacher->email ?? '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="font-semibold w-28 text-gray-600">แผนก</span>
                        <span>{{ $teacher->department ?? '-' }}</span>
                    </div>
                </div>

                @if($activeSemester)
                <div class="mt-3 pt-3 border-t border-gray-200 text-sm text-gray-700">
                    <span class="font-semibold text-gray-600">ปีการศึกษา</span>
                    <span class="font-bold text-emerald-700">{{ $activeSemester->year }}</span>
                    <span class="mx-1">▸</span>
                    <span class="font-semibold">{{ $activeSemester->name }}</span>
                    <span class="mx-1">▸</span>
                    <span class="text-gray-500">ระหว่าง {{ $activeSemester->start_date?->format('d/m/Y') }} - {{ $activeSemester->end_date?->format('d/m/Y') }}</span>
                </div>
                @endif
            </div>

            {{-- ===== Schedule Grid Table ===== --}}
            <div class="bg-white rounded-lg shadow-md overflow-x-auto">
                @php
                    $days = ['M' => 'จันทร์', 'T' => 'อังคาร', 'W' => 'พุธ', 'TH' => 'พฤหัสบดี', 'F' => 'ศุกร์', 'SA' => 'เสาร์', 'SU' => 'อาทิตย์'];

                    $timeSlots = [];
                    for ($h = 8; $h < 20; $h++) {
                        $start = str_pad($h, 2, '0', STR_PAD_LEFT) . ':00';
                        $end = str_pad($h + 1, 2, '0', STR_PAD_LEFT) . ':00';
                        $timeSlots[] = ['label' => "{$start}-{$end}", 'start' => $start, 'end' => $end, 'hour' => $h];
                    }

                    // Color palette for different subjects
                    $subjectColors = [
                        'bg-emerald-100 border-emerald-400 text-emerald-900',
                        'bg-blue-100 border-blue-400 text-blue-900',
                        'bg-amber-100 border-amber-400 text-amber-900',
                        'bg-violet-100 border-violet-400 text-violet-900',
                        'bg-rose-100 border-rose-400 text-rose-900',
                        'bg-cyan-100 border-cyan-400 text-cyan-900',
                        'bg-orange-100 border-orange-400 text-orange-900',
                        'bg-teal-100 border-teal-400 text-teal-900',
                    ];
                    $subjectIds = $schedules->pluck('subject_id')->unique()->values();
                    $colorMap = [];
                    foreach ($subjectIds as $i => $sid) {
                        $colorMap[$sid] = $subjectColors[$i % count($subjectColors)];
                    }

                    function parseHourTeacher($timeStr) {
                        return (int) substr($timeStr, 0, 2);
                    }
                @endphp

                <table class="w-full border-collapse text-xs">
                    <thead>
                        <tr style="background: linear-gradient(to right, #059669, #0f766e); color: #fff;">
                            <th class="border border-emerald-500 px-2 py-3 text-center font-bold whitespace-nowrap min-w-[70px] text-sm" style="color: #fff;">วัน/เวลา</th>
                            @foreach($timeSlots as $slot)
                                <th class="border border-emerald-500 px-1 py-3 text-center font-bold whitespace-nowrap min-w-[90px] text-sm" style="color: #fff;">{{ $slot['label'] }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($days as $dayCode => $dayName)
                            @php
                                $daySchedules = $schedules->where('day_of_week', $dayCode)->sortBy('start_time');
                                $skipHours = [];
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="border border-gray-300 px-2 py-3 font-bold bg-emerald-50 text-emerald-800 text-center whitespace-nowrap">
                                    {{ $dayName }}
                                </td>

                                @foreach($timeSlots as $slot)
                                    @if(in_array($slot['hour'], $skipHours))
                                        @continue
                                    @endif

                                    @php
                                        $matchSchedule = null;
                                        foreach ($daySchedules as $s) {
                                            $sStart = parseHourTeacher($s->start_time);
                                            $sEnd = parseHourTeacher($s->end_time);
                                            if ($slot['hour'] >= $sStart && $slot['hour'] < $sEnd) {
                                                $matchSchedule = $s;
                                                break;
                                            }
                                        }

                                        $colspan = 1;
                                        if ($matchSchedule && $slot['hour'] == parseHourTeacher($matchSchedule->start_time)) {
                                            $sStart = parseHourTeacher($matchSchedule->start_time);
                                            $sEnd = parseHourTeacher($matchSchedule->end_time);
                                            $colspan = $sEnd - $sStart;
                                            for ($skip = $sStart + 1; $skip < $sEnd; $skip++) {
                                                $skipHours[] = $skip;
                                            }
                                        }
                                    @endphp

                                    @if($matchSchedule && $slot['hour'] == parseHourTeacher($matchSchedule->start_time))
                                        <td colspan="{{ $colspan }}" class="border border-gray-300 px-1 py-1 text-center align-top">
                                            <div class="rounded p-2 h-full min-h-[60px] border-l-4 {{ $colorMap[$matchSchedule->subject_id] ?? 'bg-gray-100 border-gray-400 text-gray-900' }}">
                                                <div class="font-bold text-sm leading-tight">
                                                    {{ $matchSchedule->subject->subject_code ?? '-' }}
                                                </div>
                                                <div class="mt-1 leading-tight">
                                                    ({{ $matchSchedule->subject->credits ?? '-' }})
                                                    {{ $matchSchedule->studentClass->class_name ?? '' }}
                                                </div>
                                                <div class="mt-1 leading-tight">
                                                    🏫 {{ $matchSchedule->room ?? '-' }}
                                                </div>
                                                <div class="mt-0.5 text-[10px] opacity-75">
                                                    {{ \Carbon\Carbon::parse($matchSchedule->start_time)->format('H:i') }}-{{ \Carbon\Carbon::parse($matchSchedule->end_time)->format('H:i') }}
                                                </div>
                                            </div>
                                        </td>
                                    @elseif(!$matchSchedule)
                                        <td class="border border-gray-200 px-1 py-1 bg-gray-50"></td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="px-4 py-2 text-[11px] text-gray-500 border-t border-gray-200">
                    ข้อมูลที่ปรากฏอยู่ในตารางสอนประกอบด้วย รหัสวิชา (จำนวนหน่วยกิต) ชั้นเรียน ห้องเรียน ตามลำดับ
                </div>
            </div>

            {{-- ===== Teaching Details Table ===== --}}
            <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">📚 รายละเอียดรายวิชาที่สอน</h2>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-sm">
                        <thead>
                            <tr class="bg-emerald-600 text-white">
                                <th class="border border-emerald-500 px-3 py-2 text-center font-bold">#</th>
                                <th class="border border-emerald-500 px-3 py-2 text-left font-bold">รหัสวิชา</th>
                                <th class="border border-emerald-500 px-3 py-2 text-left font-bold">ชื่อวิชา</th>
                                <th class="border border-emerald-500 px-3 py-2 text-center font-bold">หน่วยกิต</th>
                                <th class="border border-emerald-500 px-3 py-2 text-left font-bold">ชั้นเรียน</th>
                                <th class="border border-emerald-500 px-3 py-2 text-center font-bold">วัน-เวลา</th>
                                <th class="border border-emerald-500 px-3 py-2 text-center font-bold">ห้องเรียน</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @forelse($schedules->groupBy('subject_id') as $subjectSchedules)
                                @php $first = $subjectSchedules->first(); @endphp
                                <tr class="border-b border-gray-200 hover:bg-gray-50 {{ $no % 2 == 0 ? 'bg-gray-50' : 'bg-white' }}">
                                    <td class="border border-gray-200 px-3 py-2 text-center text-gray-600">{{ $no++ }}</td>
                                    <td class="border border-gray-200 px-3 py-2 font-semibold text-emerald-700">{{ $first->subject->subject_code ?? '-' }}</td>
                                    <td class="border border-gray-200 px-3 py-2 text-gray-800">{{ $first->subject->name ?? '-' }}</td>
                                    <td class="border border-gray-200 px-3 py-2 text-center font-bold">{{ $first->subject->credits ?? '-' }}</td>
                                    <td class="border border-gray-200 px-3 py-2 text-gray-700">
                                        @foreach($subjectSchedules->unique('class_id') as $ss)
                                            <div>{{ $ss->studentClass->class_name ?? '-' }}</div>
                                        @endforeach
                                    </td>
                                    <td class="border border-gray-200 px-3 py-2 text-center text-gray-600 text-xs">
                                        @foreach($subjectSchedules as $ss)
                                            <div>{{ $days[$ss->day_of_week] ?? $ss->day_of_week }} {{ \Carbon\Carbon::parse($ss->start_time)->format('H:i') }}-{{ \Carbon\Carbon::parse($ss->end_time)->format('H:i') }} ({{ $ss->studentClass->class_name ?? '-' }})</div>
                                        @endforeach
                                    </td>
                                    <td class="border border-gray-200 px-3 py-2 text-center text-gray-600">
                                        @foreach($subjectSchedules as $ss)
                                            <div>{{ $ss->room ?? '-' }}</div>
                                        @endforeach
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">ไม่พบรายวิชาที่สอน</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($schedules->count() > 0)
                        <tfoot>
                            <tr class="bg-emerald-50 font-bold">
                                <td colspan="3" class="border border-gray-200 px-3 py-2 text-right text-gray-700">รวม</td>
                                <td class="border border-gray-200 px-3 py-2 text-center text-emerald-700 text-lg">
                                    {{ $schedules->groupBy('subject_id')->sum(fn($g) => $g->first()->subject->credits ?? 0) }}
                                </td>
                                <td colspan="3" class="border border-gray-200 px-3 py-2 text-gray-500 text-xs">
                                    จำนวนวิชา: {{ $schedules->groupBy('subject_id')->count() }} วิชา |
                                    จำนวนคาบ: {{ $schedules->count() }} คาบ/สัปดาห์
                                </td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
