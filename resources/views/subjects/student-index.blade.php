<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="{ selectedSubject: null }">

            {{-- Header --}}
            <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">ภาพรวมรายวิชา</h1>
                        <p class="text-gray-500 text-sm mt-1">สรุปสถิติการเข้าเรียนแต่ละวิชาที่ลงทะเบียน</p>
                    </div>
                    <div class="inline-flex items-center rounded-full bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 self-start">
                        {{ $subjectStats->count() }} วิชา
                    </div>
                </div>
            </div>

            {{-- ===== Subject Overview Table ===== --}}
            <div x-show="selectedSubject === null" x-transition>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
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
                                                <p class="font-semibold text-gray-800">{{ $data['subject']->name }}</p>
                                                <p class="text-xs text-gray-400 mt-0.5">{{ $data['subject']->subject_code }}</p>
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

            {{-- ===== Subject Detail (attendance records) ===== --}}
            @foreach($subjectStats as $index => $data)
                <div x-show="selectedSubject === {{ $index }}" x-transition>
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-6 py-5 border-b border-gray-100">
                            <div>
                                <h2 class="text-xl font-bold text-gray-800">ประวัติการเข้าเรียน</h2>
                                <p class="text-sm text-blue-700 font-semibold mt-0.5">{{ $data['subject']->name }}</p>
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
                            @php $pctD = $data['percentage']; @endphp
                            <span class="inline-flex items-center gap-2 bg-white border {{ $pctD >= 80 ? 'border-green-200 text-green-700' : ($pctD >= 60 ? 'border-amber-200 text-amber-600' : 'border-red-200 text-red-600') }} rounded-full px-4 py-1.5 text-sm font-semibold ml-auto">
                                อัตราเข้าเรียน <span class="ml-1 text-base font-bold">{{ $pctD }}%</span>
                            </span>
                        </div>

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
                                                $statusMap = [
                                                    'present'  => ['label' => 'มาเรียน',  'class' => 'bg-green-100 text-green-700'],
                                                    'absent'   => ['label' => 'ขาดเรียน', 'class' => 'bg-red-100 text-red-700'],
                                                    'late'     => ['label' => 'มาสาย',    'class' => 'bg-amber-100 text-amber-700'],
                                                    'excused'  => ['label' => 'ลา',        'class' => 'bg-sky-100 text-sky-700'],
                                                ];
                                                $st = $statusMap[$record->status] ?? ['label' => $record->status, 'class' => 'bg-gray-100 text-gray-600'];
                                            @endphp
                                            <tr class="hover:bg-gray-50 transition">
                                                <td class="px-6 py-3 text-sm text-gray-700">{{ \Carbon\Carbon::parse($record->attendance_date)->format('d/m/Y') }}</td>
                                                <td class="px-4 py-3 text-center text-sm text-gray-600">{{ in_array($record->status, ['present','late']) && $record->check_in_time ? \Carbon\Carbon::parse($record->check_in_time)->format('H:i') : '-' }}</td>
                                                <td class="px-4 py-3 text-center text-sm text-gray-600">{{ $record->check_out_time ? \Carbon\Carbon::parse($record->check_out_time)->format('H:i') : (in_array($record->status, ['present','late']) && $record->schedule && $record->schedule->end_time ? \Carbon\Carbon::parse($record->schedule->end_time)->format('H:i') : '-') }}</td>
                                                <td class="px-4 py-3 text-center">
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $st['class'] }}">{{ $st['label'] }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="px-6 py-10 text-center text-blue-700 font-medium bg-blue-50">
                                ยังไม่มีบันทึกการเข้าเรียนในวิชานี้
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</x-app-layout>
