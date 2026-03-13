<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">ภาพรวมการเข้าเรียน</h1>
                        <p class="text-gray-500 text-sm mt-1">สรุปประวัติการเข้าเรียนตลอดภาคเรียน · เรียงตามอัตราเข้าเรียนสูงสุด</p>
                    </div>
                    <div class="inline-flex items-center rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700 self-start">
                        อัปเดตล่าสุด {{ now()->format('d/m/Y H:i') }} น.
                    </div>
                </div>
            </div>

            {{-- ===== ตารางภาพรวมรายวิชา ===== --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-800">ภาพรวมรายวิชา</h2>
                    <p class="text-sm text-gray-500">รวมทุกนักศึกษาตลอดภาคเรียน · คลิก "ดูรายละเอียด" เพื่อดูภาพรวมรายนักศึกษาของแต่ละวิชา</p>
                </div>

                @if($subjectStats->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">วิชา</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">บันทึกทั้งหมด</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-green-600 uppercase tracking-wide">มาเรียน</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-red-500 uppercase tracking-wide">ขาด</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-amber-500 uppercase tracking-wide">สาย</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-sky-500 uppercase tracking-wide">ลา</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">อัตราเข้าเรียน</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">รายละเอียด</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($subjectStats as $i => $row)
                                    @php
                                        $pct = $row['percentage'];
                                        $barColor = $pct >= 80 ? 'bg-green-500' : ($pct >= 60 ? 'bg-amber-400' : 'bg-red-500');
                                        $pctColor = $pct >= 80 ? 'text-green-700' : ($pct >= 60 ? 'text-amber-600' : 'text-red-600');
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-3 text-sm text-gray-400 font-medium">{{ $i + 1 }}</td>
                                        <td class="px-4 py-3">
                                            <p class="font-semibold text-gray-800 text-sm">{{ $row['subject']->name }}</p>
                                            <p class="text-xs text-gray-400">{{ $row['subject']->subject_code }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm text-gray-600 font-medium">{{ $row['total'] }}</td>
                                        <td class="px-4 py-3 text-center font-bold text-green-600">{{ $row['present'] }}</td>
                                        <td class="px-4 py-3 text-center font-bold text-red-500">{{ $row['absent'] }}</td>
                                        <td class="px-4 py-3 text-center font-bold text-amber-500">{{ $row['late'] }}</td>
                                        <td class="px-4 py-3 text-center font-bold text-sky-500">{{ $row['excused'] }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex flex-col items-center gap-1">
                                                <span class="text-sm font-bold {{ $pctColor }}">{{ $pct }}%</span>
                                                <div class="w-24 bg-gray-200 rounded-full h-2">
                                                    <div class="h-2 rounded-full {{ $barColor }}" style="width: {{ $pct }}%"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <a href="{{ route('reports.subjectReport', $row['subject']) }}"
                                                class="inline-flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-7.5 9.75-7.5 9.75 7.5 9.75 7.5-3.75 7.5-9.75 7.5S2.25 12 2.25 12z"/>
                                                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" fill="none"/>
                                                </svg>
                                                ดูรายละเอียด
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="px-6 py-10 text-center text-indigo-700 font-medium bg-indigo-50">
                        ยังไม่มีข้อมูลรายวิชา
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
