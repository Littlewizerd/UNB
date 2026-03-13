<x-app-layout>
    <div class="py-6">
        <div class="max-w-[1400px] mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h1 class="text-2xl font-bold text-sky-700 mb-4">📅 ตารางสอนชดเชยของนักศึกษา</h1>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-1 text-sm text-gray-700">
                    <div class="flex">
                        <span class="font-semibold w-28 text-gray-600">ชื่อ</span>
                        <span class="font-bold text-sky-800">{{ $student->name ?? '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="font-semibold w-28 text-gray-600">รหัสนักศึกษา</span>
                        <span>{{ $student->student_id ?? '-' }}</span>
                    </div>
                    <div class="flex">
                        <span class="font-semibold w-28 text-gray-600">ชั้นเรียน</span>
                        <span>{{ $studentClass->class_name ?? '-' }} ({{ $studentClass->class_code ?? '-' }})</span>
                    </div>
                    <div class="flex">
                        <span class="font-semibold w-28 text-gray-600">อีเมล</span>
                        <span>{{ $student->email ?? '-' }}</span>
                    </div>
                </div>

                @if($activeSemester)
                <div class="mt-3 pt-3 border-t border-gray-200 text-sm text-gray-700">
                    <span class="font-semibold text-gray-600">ปีการศึกษา</span>
                    <span class="font-bold text-sky-700">{{ $activeSemester->year }}</span>
                    <span class="mx-1">▸</span>
                    <span class="font-semibold">{{ $activeSemester->name }}</span>
                    <span class="mx-1">▸</span>
                    <span class="text-gray-500">ระหว่าง {{ $activeSemester->start_date?->format('d/m/Y') }} - {{ $activeSemester->end_date?->format('d/m/Y') }}</span>
                </div>
                @endif
            </div>

            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                @php
                    $scheduleDates = $makeupSchedules
                        ->sortBy(fn ($schedule) => optional($schedule->makeup_date)->format('Y-m-d') . ' ' . $schedule->start_time)
                        ->groupBy(fn ($schedule) => optional($schedule->makeup_date)->format('Y-m-d'));
                @endphp

                @forelse($scheduleDates as $date => $dateSchedules)
                    <div class="mb-8 pb-8 border-b last:border-b-0 last:pb-0 last:mb-0">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }} <span class="text-sm text-gray-500 font-normal">({{ \Carbon\Carbon::parse($date)->locale('th')->translatedFormat('l') }})</span></h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            @foreach($dateSchedules as $schedule)
                                <div class="border-l-4 border-blue-600 bg-blue-50 p-4 rounded">
                                    <p class="font-semibold text-lg text-gray-800">{{ $schedule->subject->name ?? '-' }} ({{ $schedule->subject->subject_code ?? '-' }})</p>
                                    <p class="text-gray-600 mt-1">👨‍🏫 {{ $schedule->teacher->name ?? '-' }}</p>
                                    <p class="text-gray-600">🕐 {{ substr((string) $schedule->start_time, 0, 5) }} - {{ substr((string) $schedule->end_time, 0, 5) }}</p>
                                    <p class="text-gray-600">🏫 {{ $schedule->room ?? '-' }}</p>
                                    @if($schedule->notes)
                                        <p class="text-gray-600 mt-1 text-sm text-amber-700">📝 {{ $schedule->notes }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">ไม่มีตารางชดเชย</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
