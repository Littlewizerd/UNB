<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Back --}}
            <div class="mb-4">
                <a href="{{ route('reports.dailySummary') }}"
                   class="inline-flex items-center gap-1.5 text-sm text-indigo-600 hover:text-indigo-800 font-semibold transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                    </svg>
                    กลับไปภาพรวมรายวิชา
                </a>
            </div>

            {{-- Header --}}
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $subject->name }}</h1>
                        <p class="text-gray-500 text-sm mt-1">
                            รหัสวิชา: {{ $subject->subject_code }}
                            @if($subject->teacher)
                                &nbsp;·&nbsp; อาจารย์: {{ $subject->teacher->name }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            @if($dates->count() > 0)

                {{-- ตารางสรุปการมาเรียน (matrix) --}}
                <div class="bg-white rounded-xl shadow mb-6 overflow-hidden">
                    <div class="px-6 py-4 border-b bg-sky-50">
                        <h2 class="font-bold text-sky-800 text-base">
                            ::ประวัติการเช็คชื่อ:: <span class="font-normal text-sky-600 text-sm">วิชา {{ $subject->name }}</span>
                        </h2>
                        @if($subject->teacher)
                            <p class="text-xs text-sky-500 mt-0.5">สวัสดีอาจารย์ {{ $subject->teacher->name }}</p>
                        @endif
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="bg-pink-50 text-xs">
                                    <th class="px-4 py-2 text-left font-semibold text-gray-600 whitespace-nowrap border-b">ชื่อ สกุล</th>
                                    @foreach($dates as $d)
                                        <th class="px-2 py-2 text-center font-semibold text-gray-600 whitespace-nowrap border-b">
                                            {{ \Carbon\Carbon::parse($d)->format('d/m/Y') }}
                                        </th>
                                    @endforeach
                                    <th class="px-3 py-2 text-center font-bold text-green-700 border-b whitespace-nowrap">รวม(มา)</th>
                                    <th class="px-3 py-2 text-center font-bold text-red-600 border-b whitespace-nowrap">รวม(ขาด)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($studentStats as $row)
                                    <tr class="border-b hover:bg-gray-50 transition">
                                        <td class="px-4 py-2 text-gray-700 whitespace-nowrap">
                                            <span class="text-gray-400 text-xs mr-1">{{ $row['student']->student_id }}</span>
                                            {{ $row['student']->name }}
                                        </td>
                                        @foreach($dates as $d)
                                            @php $status = $attendanceMatrix[$row['student']->id][$d] ?? null; @endphp
                                            <td class="px-2 py-2 text-center">
                                                @if($status === 'present')
                                                    <span class="text-green-600 font-semibold">มา</span>
                                                @elseif($status === 'late')
                                                    <span class="text-amber-500 font-semibold">สาย</span>
                                                @elseif($status === 'absent')
                                                    <span class="text-red-500 font-semibold">ขาด</span>
                                                @elseif($status === 'excused')
                                                    <span class="text-blue-500 font-semibold">ลา</span>
                                                @else
                                                    <span class="text-gray-300">-</span>
                                                @endif
                                            </td>
                                        @endforeach
                                        <td class="px-3 py-2 text-center font-bold text-green-700">{{ $row['present'] + $row['late'] }}</td>
                                        <td class="px-3 py-2 text-center font-bold text-red-600">{{ $row['absent'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- วันเดือนปีที่มีการเช็คชื่อ --}}
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <div class="px-6 py-4 border-b bg-pink-50">
                        <h2 class="font-bold text-gray-800 text-base">วันเดือนปีที่มีการเช็คชื่อ</h2>
                    </div>
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                            <tr>
                                <th class="px-6 py-3 text-left">ว/ด/ป</th>
                                <th class="px-6 py-3 text-center">ดูข้อมูล</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dates as $d)
                                @php $rowId = 'detail-' . str_replace('-', '', $d); @endphp
                                <tr class="border-t">
                                    <td class="px-6 py-3 text-gray-700">
                                        {{ \Carbon\Carbon::parse($d)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-3 text-center">
                                        <button onclick="toggleRow('{{ $rowId }}')"
                                                style="background:#38bdf8;color:#fff;font-size:0.75rem;font-weight:600;padding:4px 14px;border-radius:4px;border:none;cursor:pointer;">
                                            ดูข้อมูล
                                        </button>
                                    </td>
                                </tr>
                                <tr id="{{ $rowId }}" style="display:none;" class="bg-slate-50">
                                    <td colspan="2" class="px-8 py-4">
                                        <table class="min-w-full text-sm">
                                            <thead>
                                                <tr class="text-xs text-gray-500 border-b">
                                                    <th class="text-left py-1 pr-6">รหัสนักศึกษา</th>
                                                    <th class="text-left py-1 pr-6">ชื่อ-นามสกุล</th>
                                                    <th class="text-center py-1">สถานะ</th>
                                                    <th class="text-center py-1">รายงาน</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($dateAttendances[$d] ?? [] as $att)
                                                    <tr class="border-t">
                                                        <td class="py-1.5 pr-6 text-gray-400 text-xs">{{ $att->student->student_id }}</td>
                                                        <td class="py-1.5 pr-6 text-gray-700">{{ $att->student->name }}</td>
                                                        <td class="py-1.5 text-center">
                                                            @if($att->status === 'present')
                                                                <span class="text-green-600 font-semibold">มาเรียน</span>
                                                            @elseif($att->status === 'absent')
                                                                <span class="text-red-500 font-semibold">ขาด</span>
                                                            @elseif($att->status === 'late')
                                                                <span class="text-amber-500 font-semibold">มาสาย</span>
                                                            @elseif($att->status === 'excused')
                                                                <span class="text-blue-500 font-semibold">ลา</span>
                                                            @endif
                                                        </td>
                                                        <td class="py-1.5 text-center">
                                                            <a href="{{ route('reports.individualReport', $att->student) }}"
                                                               style="background:#38bdf8;color:#fff;font-size:0.75rem;font-weight:600;padding:4px 12px;border-radius:4px;display:inline-block;text-decoration:none;">
                                                                ดูรายงาน
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <script>
                function toggleRow(id) {
                    var row = document.getElementById(id);
                    if (row) {
                        row.style.display = row.style.display === 'none' ? '' : 'none';
                    }
                }
                </script>

            @else
                <div class="bg-white rounded-xl shadow px-6 py-12 text-center text-blue-700 font-medium">
                    ยังไม่มีบันทึกการเข้าเรียนสำหรับวิชานี้
                </div>
            @endif

        </div>
    </div>
</x-app-layout>