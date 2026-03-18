@php
    $selectedSubjectIndex = $selectedSubject
        ? $subjectStats->search(fn ($data) => (int) ($data['subject']->id ?? 0) === (int) $selectedSubject->id)
        : false;
    $initialSubjectIndex = $selectedSubjectIndex !== false ? $selectedSubjectIndex : null;
    $defaultPdfUrl = route('reports.individualReportPdf', array_filter([
        'student' => $student,
        'subject' => $selectedSubject?->id,
    ]));
    $subjectPdfUrls = $subjectStats->mapWithKeys(fn ($data, $index) => [
        $index => route('reports.individualReportPdf', [
            'student' => $student,
            'subject' => $data['subject']->id,
        ]),
    ])->all();
@endphp
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div x-data="{
                selectedSubject: @js($initialSubjectIndex),
                defaultPdfUrl: @js($defaultPdfUrl),
                subjectPdfUrls: @js($subjectPdfUrls)
            }">

                {{-- Header --}}
                <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">รายงานรายบุคคล</h1>
                            <p class="text-gray-600">
                                สรุปประวัติการเข้าเรียนของ
                                <span class="font-semibold text-gray-800">{{ $student->name }}</span>
                            </p>
                            @if($selectedSubject)
                                <p class="text-sm text-blue-700 font-semibold mt-2">
                                    กำลังแสดงเฉพาะวิชา {{ $selectedSubject->name }}
                                </p>
                            @endif
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <a x-bind:href="selectedSubject !== null && subjectPdfUrls[selectedSubject] ? subjectPdfUrls[selectedSubject] : defaultPdfUrl" target="_blank"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg font-semibold transition">
                                <span x-text="selectedSubject !== null ? 'ดาวน์โหลด PDF รายวิชา' : 'ดาวน์โหลด PDF'"></span>
                            </a>
                            @if(strtolower(auth()->user()->role ?? '') !== 'student')
                                <a href="{{ route('students.index') }}"
                                    class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-3 rounded-lg font-semibold transition">
                                    กลับ
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Overall Stats --}}
                {{-- REMOVED --}}

                {{-- Student Info Card --}}
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">ข้อมูลนักศึกษา</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm text-gray-700">
                        <div>
                            <span class="block text-gray-500 font-semibold">รหัสนักศึกษา</span>
                            <span class="font-medium text-gray-800">{{ $student->student_id }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500 font-semibold">ชื่อ-นามสกุล</span>
                            <span class="font-medium text-gray-800">{{ $student->name }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500 font-semibold">ชั้นเรียน</span>
                            <span class="font-medium text-gray-800">{{ $student->studentClass->class_name ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500 font-semibold">อีเมล</span>
                            <span class="font-medium text-gray-800">{{ $student->email }}</span>
                        </div>
                    </div>
                </div>

                {{-- ===== ภาพรวมรายวิชา ===== --}}
                <div x-show="selectedSubject === null" x-transition>
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="flex items-center justify-between gap-4 px-6 py-5 border-b border-gray-100">
                            <div>
                                <h2 class="text-xl font-bold text-gray-800">ภาพรวมรายวิชา</h2>
                                <p class="text-sm text-gray-500">สรุปสถิติการเข้าเรียนแต่ละวิชาที่ลงทะเบียน</p>
                            </div>
                            <div class="rounded-full bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700">
                                {{ $subjectStats->count() }} วิชา
                            </div>
                        </div>

                        @if($subjectStats->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">วิชา</th>
                                            <th class="px-4 py-3 text-center text-xs font-semibold text-green-600 uppercase tracking-wide">มาเรียน</th>
                                            <th class="px-4 py-3 text-center text-xs font-semibold text-red-500 uppercase tracking-wide">ขาด</th>
                                            <th class="px-4 py-3 text-center text-xs font-semibold text-amber-500 uppercase tracking-wide">สาย</th>
                                            <th class="px-4 py-3 text-center text-xs font-semibold text-sky-500 uppercase tracking-wide">ลา</th>
                                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">อัตราเข้าเรียน</th>
                                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">รายละเอียด</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($subjectStats as $index => $data)
                                            @php
                                                $pct = $data['percentage'];
                                                $barColor = $pct >= 80 ? 'bg-green-500' : ($pct >= 60 ? 'bg-amber-400' : 'bg-red-500');
                                                $pctColor = $pct >= 80 ? 'text-green-700' : ($pct >= 60 ? 'text-amber-600' : 'text-red-600');
                                            @endphp
                                            <tr class="hover:bg-gray-50 transition">
                                                <td class="px-6 py-4">
                                                    <p class="font-semibold text-gray-800">{{ $data['subject']->name ?? '-' }}</p>
                                                    @if($data['subject']->subject_code ?? null)
                                                        <p class="text-xs text-gray-400 mt-0.5">{{ $data['subject']->subject_code }}</p>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-4 text-center">
                                                    <span class="text-lg font-bold text-green-600">{{ $data['present'] }}</span>
                                                </td>
                                                <td class="px-4 py-4 text-center">
                                                    <span class="text-lg font-bold text-red-500">{{ $data['absent'] }}</span>
                                                </td>
                                                <td class="px-4 py-4 text-center">
                                                    <span class="text-lg font-bold text-amber-500">{{ $data['late'] }}</span>
                                                </td>
                                                <td class="px-4 py-4 text-center">
                                                    <span class="text-lg font-bold text-sky-500">{{ $data['excused'] }}</span>
                                                </td>
                                                <td class="px-4 py-4">
                                                    <div class="flex flex-col items-center gap-1">
                                                        <span class="text-lg font-bold {{ $pctColor }}">{{ $pct }}%</span>
                                                        <div class="w-24 bg-gray-200 rounded-full h-2">
                                                            <div class="h-2 rounded-full {{ $barColor }}" style="width: {{ $pct }}%"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4 text-center">
                                                    <button @click="selectedSubject = {{ $index }}"
                                                        class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-7.5 9.75-7.5 9.75 7.5 9.75 7.5-3.75 7.5-9.75 7.5S2.25 12 2.25 12z"/>
                                                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" fill="none"/>
                                                        </svg>
                                                        ดูรายละเอียด
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="px-6 py-10 text-center text-blue-700 font-medium bg-blue-50">
                                ยังไม่มีข้อมูลวิชาที่ลงทะเบียน
                            </div>
                        @endif
                    </div>
                </div>

                {{-- ===== ประวัติการเข้าเรียนรายวิชา ===== --}}
                @foreach($subjectStats as $index => $data)
                    <div x-show="selectedSubject === {{ $index }}" x-transition>
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                            {{-- Header --}}
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-6 py-5 border-b border-gray-100">
                                <div>
                                    <h2 class="text-xl font-bold text-gray-800">ประวัติการเข้าเรียน</h2>
                                    <p class="text-sm text-blue-700 font-semibold mt-0.5">{{ $data['subject']->name ?? '-' }}</p>
                                    <p class="text-xs text-gray-400">{{ $data['records']->count() }} รายการ</p>
                                </div>
                                <button @click="selectedSubject = null"
                                    class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold px-4 py-2 rounded-lg transition self-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                                    </svg>
                                    กลับภาพรวมรายวิชา
                                </button>
                            </div>

                            {{-- Mini stats --}}
                            <div class="flex flex-wrap items-center gap-3 px-6 py-4 border-b border-gray-100 bg-gray-50">
                                <span class="inline-flex items-center gap-2 bg-white border border-green-200 rounded-full px-4 py-1.5 text-sm font-semibold text-green-700">
                                    <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                                    มาเรียน <span class="ml-1 text-base font-bold">{{ $data['present'] }}</span>
                                </span>
                                <span class="inline-flex items-center gap-2 bg-white border border-red-200 rounded-full px-4 py-1.5 text-sm font-semibold text-red-600">
                                    <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                                    ขาด <span class="ml-1 text-base font-bold">{{ $data['absent'] }}</span>
                                </span>
                                <span class="inline-flex items-center gap-2 bg-white border border-amber-200 rounded-full px-4 py-1.5 text-sm font-semibold text-amber-600">
                                    <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                                    สาย <span class="ml-1 text-base font-bold">{{ $data['late'] }}</span>
                                </span>
                                <span class="inline-flex items-center gap-2 bg-white border border-sky-200 rounded-full px-4 py-1.5 text-sm font-semibold text-sky-600">
                                    <span class="w-2.5 h-2.5 rounded-full bg-sky-400"></span>
                                    ลา <span class="ml-1 text-base font-bold">{{ $data['excused'] }}</span>
                                </span>
                                @php $pctDetail = $data['percentage']; @endphp
                                <span class="inline-flex items-center gap-2 bg-white border {{ $pctDetail >= 80 ? 'border-green-200 text-green-700' : ($pctDetail >= 60 ? 'border-amber-200 text-amber-600' : 'border-red-200 text-red-600') }} rounded-full px-4 py-1.5 text-sm font-semibold ml-auto">
                                    อัตราเข้าเรียน <span class="ml-1 text-base font-bold">{{ $pctDetail }}%</span>
                                </span>
                            </div>

                            {{-- Attendance table --}}
                            @if($data['records']->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-100">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">วันที่</th>
                                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">เวลาเข้า</th>
                                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">เวลาออก</th>
                                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">สถานะ</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            @foreach($data['records'] as $record)
                                                @php
                                                    $sc = match($record->status) {
                                                        'present' => 'bg-green-100 text-green-700',
                                                        'absent'  => 'bg-red-100 text-red-700',
                                                        'late'    => 'bg-amber-100 text-amber-700',
                                                        'excused' => 'bg-sky-100 text-sky-700',
                                                        default   => 'bg-gray-100 text-gray-700',
                                                    };
                                                    $st = match($record->status) {
                                                        'present' => 'มาเรียน',
                                                        'absent'  => 'ขาดเรียน',
                                                        'late'    => 'มาสาย',
                                                        'excused' => 'ลากิจ/ป่วย',
                                                        default   => 'ไม่ระบุ',
                                                    };
                                                @endphp
                                                <tr class="hover:bg-gray-50 transition">
                                                    <td class="px-6 py-3 text-sm text-gray-700">
                                                        {{ \Carbon\Carbon::parse($record->attendance_date)->format('d/m/Y') }}
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-gray-600 text-center">
                                                        {{ in_array($record->status, ['present','late']) && $record->check_in_time ? \Carbon\Carbon::parse($record->check_in_time)->format('H:i') : '-' }}
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-gray-600 text-center">
                                                        {{ $record->check_out_time ? \Carbon\Carbon::parse($record->check_out_time)->format('H:i') : (in_array($record->status, ['present','late']) && $record->schedule && $record->schedule->end_time ? \Carbon\Carbon::parse($record->schedule->end_time)->format('H:i') : '-') }}
                                                    </td>
                                                    <td class="px-4 py-3 text-center">
                                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $sc }}">{{ $st }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="px-6 py-10 text-center text-blue-700 font-medium bg-blue-50">
                                    ยังไม่มีบันทึกการเข้าเรียนสำหรับวิชานี้
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

            </div>{{-- end alpine wrapper --}}

        </div>
    </div>
</x-app-layout>
