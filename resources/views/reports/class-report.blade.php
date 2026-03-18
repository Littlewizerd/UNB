<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">รายงานการเข้าเรียนรายชั้นเรียน</h1>
                        <p class="text-gray-600 mt-1">{{ $class->class_name }} ({{ $class->class_code }})</p>
                    </div>
                    <a href="{{ route('reports.classReportPdf', $class) }}"
                       class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-lg font-semibold transition">
                        ดาวน์โหลด PDF
                    </a>
                </div>
            </div>

            {{-- Table --}}
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                @if($reportData)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">รหัสนักเรียน</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">ชื่อ-นามสกุล</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-green-600 uppercase tracking-wide">มาเรียน</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-red-500 uppercase tracking-wide">ขาดเรียน</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-amber-500 uppercase tracking-wide">มาสาย</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-sky-500 uppercase tracking-wide">ลากิจ/ป่วย</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">รวม</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">ร้อยละ</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($reportData as $data)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-3 text-sm text-gray-600">{{ $data['student']->student_id }}</td>
                                        <td class="px-6 py-3 text-sm font-semibold text-gray-800">{{ $data['student']->name }}</td>
                                        <td class="px-6 py-3 text-center">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-700 font-bold text-sm">{{ $data['present'] }}</span>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-700 font-bold text-sm">{{ $data['absent'] }}</span>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-100 text-amber-700 font-bold text-sm">{{ $data['late'] }}</span>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-sky-100 text-sky-700 font-bold text-sm">{{ $data['excused'] }}</span>
                                        </td>
                                        <td class="px-6 py-3 text-center text-sm font-medium text-gray-700">{{ $data['total'] }}</td>
                                        <td class="px-6 py-3 text-center">
                                            @php $pct = $data['percentage']; @endphp
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold
                                                {{ $pct >= 80 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $pct }}%
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-8 text-center text-gray-500">ยังไม่มีข้อมูล</div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
