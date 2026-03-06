<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">ประวัติการเข้าเรียน</h1>
                <p class="text-gray-600">บันทึกการเข้าเรียนของ {{ Auth::user()->name }}</p>
            </div>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                @if($attendances->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">วันที่</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">วิชา</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">เวลาเข้า</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">เวลาออก</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">สถานะ</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($attendances as $record)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $record->attendance_date->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $record->subject->name ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $record->check_in_time ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $record->check_out_time ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @php
                                                $statusClass = match($record->status) {
                                                    'present' => 'bg-green-100 text-green-800',
                                                    'absent' => 'bg-red-100 text-red-800',
                                                    'late' => 'bg-yellow-100 text-yellow-800',
                                                    'excused' => 'bg-blue-100 text-blue-800',
                                                    default => 'bg-gray-100 text-gray-800'
                                                };
                                                $statusText = match($record->status) {
                                                    'present' => 'มาเรียน',
                                                    'absent' => 'ขาดเรียน',
                                                    'late' => 'มาสาย',
                                                    'excused' => 'ลากิจ/ป่วย',
                                                    default => 'ไม่ระบุ'
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                                {{ $statusText }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-4">
                        {{ $attendances->links() }}
                    </div>
                @else
                    <div class="p-8 text-center">
                        <div class="text-gray-400 mb-4">
                            <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 text-lg">ยังไม่มีบันทึกการเข้าเรียน</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
