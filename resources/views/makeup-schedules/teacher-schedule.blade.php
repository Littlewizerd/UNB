<x-app-layout>
    <div class="py-6">
        <div class="max-w-[1400px] mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-emerald-700 mb-4">📅 ตารางสอนชดเชยของอาจารย์</h1>

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

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('makeup-schedules.index') }}" class="bg-white border border-emerald-200 text-emerald-700 hover:bg-emerald-50 px-4 py-2 rounded-lg font-semibold transition">
                            ดูทั้งหมด
                        </a>
                        <a href="{{ route('makeup-schedules.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                            + เพิ่มตารางชดเชย
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-x-auto">
                @php
                    $timeSlots = [];
                    for ($h = 8; $h < 20; $h++) {
                        $endH = str_pad($h + 1, 2, '0', STR_PAD_LEFT);
                        $startH = str_pad($h, 2, '0', STR_PAD_LEFT);
                        $timeSlots[] = [
                            'label' => "{$startH}:00-{$endH}:00",
                            'start' => "{$startH}:00",
                            'end' => "{$endH}:00",
                            'hour' => $h
                        ];
                    }

                    $subjectColors = [
                        'bg-amber-100 border-amber-400 text-amber-900',
                        'bg-emerald-100 border-emerald-400 text-emerald-900',
                        'bg-blue-100 border-blue-400 text-blue-900',
                        'bg-violet-100 border-violet-400 text-violet-900',
                        'bg-rose-100 border-rose-400 text-rose-900',
                        'bg-cyan-100 border-cyan-400 text-cyan-900',
                        'bg-orange-100 border-orange-400 text-orange-900',
                        'bg-teal-100 border-teal-400 text-teal-900',
                    ];

                    $pendingSchedules = $makeupSchedules->where('status', 'pending');

                    $subjectIds = $pendingSchedules->pluck('subject_id')->unique()->values();
                    $colorMap = [];
                    foreach ($subjectIds as $i => $subjectId) {
                        $colorMap[$subjectId] = $subjectColors[$i % count($subjectColors)];
                    }

                    $dateGroups = $pendingSchedules
                        ->sortBy(fn ($schedule) => optional($schedule->makeup_date)->format('Y-m-d') . ' ' . $schedule->start_time)
                        ->groupBy(fn ($schedule) => optional($schedule->makeup_date)->format('Y-m-d'));
                @endphp

                <table class="w-full border-collapse text-xs">
                    <thead>
                        <tr style="background: linear-gradient(to right, #059669, #0f766e); color: #fff;">
                            <th class="border border-emerald-500 px-2 py-3 text-center font-bold whitespace-nowrap min-w-[110px] text-sm" style="color: #fff;">วัน/เวลา</th>
                            @foreach($timeSlots as $slot)
                                <th class="border border-emerald-500 px-1 py-3 text-center font-bold whitespace-nowrap min-w-[72px] text-[11px]" style="color: #fff;">{{ $slot['label'] }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dateGroups as $date => $dateSchedules)
                            @php $skipSlots = []; @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="border border-gray-300 px-2 py-3 font-bold bg-emerald-50 text-emerald-800 text-center whitespace-nowrap align-top">
                                    <div>{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</div>
                                    <div class="text-[11px] font-medium text-emerald-600 mt-1">{{ \Carbon\Carbon::parse($date)->locale('th')->translatedFormat('l') }}</div>
                                </td>

                                @foreach($timeSlots as $slotIndex => $slot)
                                    @if(in_array($slotIndex, $skipSlots, true))
                                        @continue
                                    @endif

                                    @php
                                        // ค้นหาช่วงเวลาที่ตรงกับชั่วโมงปัจจุบัน
                                        $matchSchedule = null;
                                        foreach ($dateSchedules as $schedule) {
                                            $startHour = (int) substr((string) $schedule->start_time, 0, 2);
                                            $endHour = (int) substr((string) $schedule->end_time, 0, 2);
                                            $endMin = (int) substr((string) $schedule->end_time, 3, 2);
                                            if ($endMin > 0) {
                                                $endHour += 1;
                                            }

                                            if ($slot['hour'] >= $startHour && $slot['hour'] < $endHour) {
                                                $matchSchedule = $schedule;
                                                break;
                                            }
                                        }

                                        $colspan = 1;
                                        if ($matchSchedule && $slot['hour'] == (int) substr((string) $matchSchedule->start_time, 0, 2)) {
                                            $sStart = (int) substr((string) $matchSchedule->start_time, 0, 2);
                                            $sEnd = (int) substr((string) $matchSchedule->end_time, 0, 2);
                                            $sEndMin = (int) substr((string) $matchSchedule->end_time, 3, 2);
                                            if ($sEndMin > 0) {
                                                $sEnd += 1;
                                            }
                                            $colspan = max(1, $sEnd - $sStart);
                                            for ($i = 1; $i < $colspan; $i++) {
                                                $skipSlots[] = $slotIndex + $i;
                                            }
                                        }
                                    @endphp

                                    @if($matchSchedule && $slot['hour'] == (int) substr((string) $matchSchedule->start_time, 0, 2))
                                        <td colspan="{{ $colspan }}" class="border border-gray-300 px-1 py-1 text-center align-top">
                                            <div class="rounded p-2 h-full border-l-4 {{ $colorMap[$matchSchedule->subject_id] ?? 'bg-gray-100 border-gray-400 text-gray-900' }}">
                                                <div class="font-bold text-sm leading-tight truncate">
                                                    {{ $matchSchedule->subject->subject_code ?? '-' }}
                                                </div>
                                                <div class="mt-1 leading-tight text-[11px] truncate">
                                                    {{ $matchSchedule->studentClass->class_name ?? '-' }}
                                                </div>
                                                <div class="mt-1 leading-tight text-[11px]">
                                                    🏫 {{ $matchSchedule->room ?? '-' }}
                                                </div>
                                                <div class="mt-0.5 text-[10px] opacity-75">
                                                    {{ substr((string) $matchSchedule->start_time, 0, 5) }}-{{ substr((string) $matchSchedule->end_time, 0, 5) }}
                                                </div>
                                            </div>
                                        </td>
                                    @elseif(!$matchSchedule)
                                        <td class="border border-gray-200 px-1 py-1 bg-gray-50"></td>
                                    @endif
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="13" class="px-6 py-8 text-center text-gray-500">ยังไม่มีตารางชดเชยในภาคเรียนนี้</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="px-4 py-2 text-[11px] text-gray-500 border-t border-gray-200">
                    ข้อมูลที่ปรากฏอยู่ในตารางสอนชดเชยประกอบด้วย รหัสวิชา ชั้นเรียน ห้องเรียน และช่วงเวลา ตามลำดับ
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">📚 รายละเอียดรายวิชาชดเชย</h2>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-sm">
                        <thead>
                            <tr class="bg-emerald-600 text-white">
                                <th class="border border-emerald-500 px-3 py-2 text-center font-bold">#</th>
                                <th class="border border-emerald-500 px-3 py-2 text-center font-bold">วันที่</th>
                                <th class="border border-emerald-500 px-3 py-2 text-left font-bold">รหัสวิชา</th>
                                <th class="border border-emerald-500 px-3 py-2 text-left font-bold">ชื่อวิชา</th>
                                <th class="border border-emerald-500 px-3 py-2 text-left font-bold">ชั้นเรียน</th>
                                <th class="border border-emerald-500 px-3 py-2 text-center font-bold">เวลา</th>
                                <th class="border border-emerald-500 px-3 py-2 text-center font-bold">ห้องเรียน</th>
                                <th class="border border-emerald-500 px-3 py-2 text-left font-bold">หมายเหตุ</th>
                                <th class="border border-emerald-500 px-3 py-2 text-center font-bold">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($makeupSchedules as $schedule)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                                    <td class="border border-gray-200 px-3 py-2 text-center text-gray-600">{{ $loop->iteration }}</td>
                                    <td class="border border-gray-200 px-3 py-2 text-center text-gray-700">
                                        <div class="font-semibold">{{ $schedule->makeup_date?->format('d/m/Y') ?? '-' }}</div>
                                        <div class="text-xs text-gray-500">{{ $schedule->makeup_date?->locale('th')->translatedFormat('l') }}</div>
                                    </td>
                                    <td class="border border-gray-200 px-3 py-2 font-semibold text-emerald-700">{{ $schedule->subject->subject_code ?? '-' }}</td>
                                    <td class="border border-gray-200 px-3 py-2 text-gray-800">{{ $schedule->subject->name ?? '-' }}</td>
                                    <td class="border border-gray-200 px-3 py-2 text-gray-700">{{ $schedule->studentClass->class_name ?? '-' }}</td>
                                    <td class="border border-gray-200 px-3 py-2 text-center text-gray-600">{{ substr((string) $schedule->start_time, 0, 5) }}-{{ substr((string) $schedule->end_time, 0, 5) }}</td>
                                    <td class="border border-gray-200 px-3 py-2 text-center text-gray-600">{{ $schedule->room ?? '-' }}</td>
                                    <td class="border border-gray-200 px-3 py-2 text-gray-600">{{ $schedule->notes ?: '-' }}</td>
                                    <td class="border border-gray-200 px-3 py-2 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            @if($schedule->status === 'pending')
                                            <form action="{{ route('makeup-schedules.complete', $schedule) }}" method="POST" onsubmit="return confirm('ยืนยันว่าสอนชดเชยเสร็จสิ้นแล้ว?\nเมื่อยืนยันจะหายไปจากตารางด้านบน')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="inline-flex items-center bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded transition" title="ยืนยันสอนเสร็จ">
                                                    ✅
                                                </button>
                                            </form>
                                            @else
                                                <span class="inline-flex items-center bg-gray-100 text-gray-500 border border-gray-300 px-2 py-1 rounded text-xs" title="สอนเสร็จสิ้นแล้ว">
                                                    ✔️ เสร็จสิ้น
                                                </span>
                                            @endif
                                            <a href="{{ route('makeup-schedules.edit', $schedule) }}" class="inline-flex items-center bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded transition" title="แก้ไข">
                                                ✏️
                                            </a>
                                            <form action="{{ route('makeup-schedules.destroy', $schedule) }}" method="POST" onsubmit="return confirm('ยืนยันการลบตารางชดเชยนี้?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded transition" title="ลบ">
                                                    🗑️
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-8 text-center text-gray-500">ไม่พบรายวิชาชดเชย</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
