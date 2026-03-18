<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <h1 class="text-3xl font-bold text-gray-800">สถิติการเข้าเรียน</h1>
                <p class="text-gray-600 mt-1">{{ $student->name }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

                {{-- Student Info --}}
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">ข้อมูลนักเรียน</h2>
                    <dl class="space-y-2 text-sm">
                        <div class="flex gap-2"><dt class="font-semibold text-gray-500 w-28">รหัสนักเรียน</dt><dd class="text-gray-800">{{ $student->student_id }}</dd></div>
                        <div class="flex gap-2"><dt class="font-semibold text-gray-500 w-28">ชื่อ-นามสกุล</dt><dd class="text-gray-800">{{ $student->name }}</dd></div>
                        <div class="flex gap-2"><dt class="font-semibold text-gray-500 w-28">ชั้นเรียน</dt><dd class="text-gray-800">{{ $student->studentClass->class_name ?? '-' }}</dd></div>
                        <div class="flex gap-2"><dt class="font-semibold text-gray-500 w-28">อีเมล</dt><dd class="text-gray-800">{{ $student->email }}</dd></div>
                    </dl>
                </div>

                {{-- Stats --}}
                <div class="lg:col-span-2 bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">สรุปสถิติการเข้าเรียน</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                            <div class="text-3xl font-bold text-green-600">{{ $stats['present'] }}</div>
                            <div class="text-sm text-gray-500 mt-1">มาเรียน</div>
                        </div>
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                            <div class="text-3xl font-bold text-red-600">{{ $stats['absent'] }}</div>
                            <div class="text-sm text-gray-500 mt-1">ขาดเรียน</div>
                        </div>
                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 text-center">
                            <div class="text-3xl font-bold text-amber-600">{{ $stats['late'] }}</div>
                            <div class="text-sm text-gray-500 mt-1">มาสาย</div>
                        </div>
                        <div class="bg-sky-50 border border-sky-200 rounded-lg p-4 text-center">
                            <div class="text-3xl font-bold text-sky-600">{{ $stats['excused'] }}</div>
                            <div class="text-sm text-gray-500 mt-1">ลากิจ/ป่วย</div>
                        </div>
                    </div>

                    <div class="border-t pt-4 flex flex-col sm:flex-row gap-6 items-start sm:items-center">
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-600 mb-2">อัตราการเข้าเรียน (จาก {{ $stats['total'] }} ครั้ง)</p>
                            <div class="w-full bg-gray-200 rounded-full h-6 overflow-hidden">
                                @php $pct = $stats['percentage']; $barColor = $pct >= 80 ? 'bg-green-500' : ($pct >= 60 ? 'bg-amber-400' : 'bg-red-500'); @endphp
                                <div class="{{ $barColor }} h-6 rounded-full flex items-center justify-center text-white text-xs font-bold transition-all"
                                     style="width: {{ $pct }}%">{{ $pct }}%</div>
                            </div>
                        </div>
                        <div class="text-center">
                            @if($pct >= 80)
                                <span class="inline-block px-4 py-2 rounded-full bg-green-100 text-green-700 font-bold">ดีมาก</span>
                                <p class="text-xs text-gray-400 mt-1">เข้าเรียนสม่ำเสมอ</p>
                            @elseif($pct >= 60)
                                <span class="inline-block px-4 py-2 rounded-full bg-amber-100 text-amber-700 font-bold">ควรปรับปรุง</span>
                                <p class="text-xs text-gray-400 mt-1">ควรเพิ่มการเข้าเรียน</p>
                            @else
                                <span class="inline-block px-4 py-2 rounded-full bg-red-100 text-red-700 font-bold">เสี่ยง</span>
                                <p class="text-xs text-gray-400 mt-1">ต้องได้รับการติดตาม</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('students.show', $student) }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold transition">ดูข้อมูลนักเรียน</a>
                <a href="{{ route('reports.individualReport', $student) }}"
                   class="bg-sky-600 hover:bg-sky-700 text-white px-5 py-2 rounded-lg font-semibold transition">ดูรายงานรายบุคคล</a>
                <a href="{{ url()->previous() }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg font-semibold transition">กลับ</a>
            </div>

        </div>
    </div>
</x-app-layout>
