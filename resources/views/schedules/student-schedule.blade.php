<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <h1 class="text-3xl font-bold text-gray-800">ตารางเรียนของฉัน</h1>
                <p class="text-gray-600 mt-2">ตารางเรียนสำหรับนักเรียนในชั้นของคุณ</p>
            </div>

            <!-- Schedule Display -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                @php
                    $days = ['M' => 'จันทร์', 'T' => 'อังคาร', 'W' => 'พุธ', 'TH' => 'พฤหัสบดี', 'F' => 'ศุกร์', 'SA' => 'เสาร์', 'SU' => 'อาทิตย์'];
                    $scheduleDays = $schedules->groupBy('day_of_week');
                @endphp

                @forelse($days as $code => $dayName)
                    <div class="mb-8 pb-8 border-b last:border-b-0 last:pb-0 last:mb-0">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">{{ $dayName }}</h3>
                        
                        @if(isset($scheduleDays[$code]) && count($scheduleDays[$code]) > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($scheduleDays[$code] as $schedule)
                                    <div class="border-l-4 border-blue-600 bg-blue-50 p-4 rounded">
                                        <p class="font-semibold text-lg text-gray-800">{{ $schedule->subject->name ?? '-' }}</p>
                                        <p class="text-gray-600 mt-1">👨‍🏫 {{ $schedule->teacher->name ?? '-' }}</p>
                                        <p class="text-gray-600">🕐 {{ $schedule->start_time }} - {{ $schedule->end_time }}</p>
                                        <p class="text-gray-600">🏫 {{ $schedule->room ?? '-' }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">ไม่มีตารางเรียน</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
