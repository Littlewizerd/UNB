<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">รายงานนักเรียนเสี่ยง</h1>
                        <p class="text-gray-600 mt-1">นักเรียนที่มีอัตราการขาดเรียนมากกว่า 20%</p>
                    </div>
                    <span class="bg-red-100 text-red-700 font-bold px-4 py-2 rounded-full text-sm">เสี่ยง {{ count($riskStudents) }} คน</span>
                </div>
            </div>

            {{-- Warning Note --}}
            <div class="bg-amber-50 border-l-4 border-amber-400 text-amber-800 px-5 py-4 rounded mb-6">
                <strong>หมายเหตุ:</strong> นักเรียนที่มีอัตราการขาดเรียนมากกว่า 20% จะถูกแสดงในรายงานนี้
            </div>

            {{-- Table --}}
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
                @if(count($riskStudents) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">#</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">รหัสนักเรียน</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">ชื่อ-นามสกุล</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">ชั้นเรียน</th>
                                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">เข้าเรียน</th>
                                    <th class="px-5 py-3 text-center text-xs font-semibold text-red-500 uppercase tracking-wide">ขาด</th>
                                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">% ขาด</th>
                                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">ระดับเสี่ยง</th>
                                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">ดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($riskStudents as $index => $data)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-5 py-3 text-sm text-gray-400">{{ $index + 1 }}</td>
                                        <td class="px-5 py-3 text-sm text-gray-600">{{ $data['student']->student_id }}</td>
                                        <td class="px-5 py-3 text-sm font-semibold text-gray-800">{{ $data['student']->name }}</td>
                                        <td class="px-5 py-3 text-sm text-gray-600">{{ $data['student']->studentClass->class_name ?? '-' }}</td>
                                        <td class="px-5 py-3 text-center text-sm font-medium text-gray-700">{{ $data['total'] }}</td>
                                        <td class="px-5 py-3 text-center text-sm font-bold text-red-600">{{ $data['absent'] }}</td>
                                        <td class="px-5 py-3 text-center text-sm font-bold text-red-500">{{ $data['percentage'] }}%</td>
                                        <td class="px-5 py-3 text-center">
                                            @if($data['risk_level'] === 'สูง')
                                                <span class="inline-block px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">เสี่ยงสูง</span>
                                            @else
                                                <span class="inline-block px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">เสี่ยงปานกลาง</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3 text-center">
                                            <a href="{{ route('reports.individualReport', $data['student']) }}"
                                               class="bg-sky-600 hover:bg-sky-700 text-white px-3 py-1 rounded text-xs font-semibold transition">ดูรายละเอียด</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-8 text-center">
                        <span class="text-green-600 font-semibold">✅ ไม่พบนักเรียนที่มีความเสี่ยง</span>
                    </div>
                @endif
            </div>

            {{-- Risk Level Legend --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-5">
                    <h3 class="font-bold text-amber-700 mb-1">ระดับเสี่ยงปานกลาง (20–30%)</h3>
                    <p class="text-sm text-amber-600">นักเรียนที่ขาดเรียน 20–30% ควรได้รับการติดตามและเตือน</p>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-lg p-5">
                    <h3 class="font-bold text-red-700 mb-1">ระดับเสี่ยงสูง (>30%)</h3>
                    <p class="text-sm text-red-600">นักเรียนที่ขาดเรียนมากกว่า 30% ต้องได้รัปการดูแลเป็นพิเศษ</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
