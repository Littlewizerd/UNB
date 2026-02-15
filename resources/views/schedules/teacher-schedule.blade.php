<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <h1 class="text-3xl font-bold text-gray-800">ตารางสอนของฉัน</h1>
                <p class="text-gray-600 mt-2">ตารางเรียนทั้งหมดของคุณแต่ละวัน</p>
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
                            <div class="space-y-3">
                                @foreach($scheduleDays[$code] as $schedule)
                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                                        <div class="flex-1">
                                            <p class="font-semibold text-lg text-gray-800">{{ $schedule->subject->name ?? '-' }}</p>
                                            <p class="text-gray-600 text-sm">
                                                📚 {{ $schedule->studentClass->name ?? '-' }} | 
                                                🏫 {{ $schedule->room ?? '-' }}
                                            </p>
                                        </div>
                                        <div class="mt-2 md:mt-0 flex items-center gap-2">
                                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                                🕐 {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                            </span>
                                            <a href="{{ route('schedules.show', $schedule->id) }}" 
                                               class="text-blue-600 hover:text-blue-800 font-semibold">
                                                👁️ ดู
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">ไม่มีตารางสอน</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
