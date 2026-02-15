<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">รายละเอียดตารางเรียน</h1>
                    <p class="text-gray-600 mt-2">ข้อมูลตารางเรียน</p>
                </div>
                <a href="{{ route('schedules.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    ← ย้อนกลับ
                </a>
            </div>

            <!-- Details -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div>
                        <div class="mb-6 pb-6 border-b">
                            <label class="text-gray-500 text-sm font-semibold uppercase tracking-wide">ชั้นเรียน</label>
                            <p class="text-2xl font-bold text-gray-800 mt-2">{{ $schedule->studentClass->name ?? 'ไม่ระบุ' }}</p>
                        </div>

                        <div class="mb-6 pb-6 border-b">
                            <label class="text-gray-500 text-sm font-semibold uppercase tracking-wide">วิชา</label>
                            <p class="text-2xl font-bold text-gray-800 mt-2">{{ $schedule->subject->name ?? 'ไม่ระบุ' }}</p>
                        </div>

                        <div class="mb-6">
                            <label class="text-gray-500 text-sm font-semibold uppercase tracking-wide">ครูผู้สอน</label>
                            <p class="text-xl font-bold text-gray-800 mt-2">👨‍🏫 {{ $schedule->teacher->name ?? 'ไม่ระบุ' }}</p>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div>
                        <div class="mb-6 pb-6 border-b">
                            <label class="text-gray-500 text-sm font-semibold uppercase tracking-wide">วัน</label>
                            <p class="text-xl font-bold text-gray-800 mt-2">
                                @php
                                    $dayMap = ['M' => 'จันทร์', 'T' => 'อังคาร', 'W' => 'พุธ', 'TH' => 'พฤหัสบดี', 'F' => 'ศุกร์', 'SA' => 'เสาร์', 'SU' => 'อาทิตย์'];
                                @endphp
                                {{ $dayMap[$schedule->day_of_week] ?? $schedule->day_of_week }}
                            </p>
                        </div>

                        <div class="mb-6 pb-6 border-b">
                            <label class="text-gray-500 text-sm font-semibold uppercase tracking-wide">เวลา</label>
                            <p class="text-xl font-bold text-gray-800 mt-2">🕐 {{ $schedule->start_time }} - {{ $schedule->end_time }}</p>
                        </div>

                        <div class="mb-6">
                            <label class="text-gray-500 text-sm font-semibold uppercase tracking-wide">ห้องเรียน</label>
                            <p class="text-xl font-bold text-gray-800 mt-2">🏫 {{ $schedule->room ?? 'ไม่ระบุ' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Semester Info -->
            @if($schedule->semesterData)
            <div class="bg-blue-50 rounded-lg shadow-lg p-8 mb-8 border border-blue-200">
                <h2 class="text-xl font-bold text-gray-800 mb-4">ภาคเรียน</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="text-gray-600 text-sm">ชื่อ</label>
                        <p class="font-semibold text-gray-800">{{ $schedule->semesterData->name }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600 text-sm">ปีการศึกษา</label>
                        <p class="font-semibold text-gray-800">{{ $schedule->semesterData->year }}</p>
                    </div>
                    <div>
                        <label class="text-gray-600 text-sm">สถานะ</label>
                        <p class="font-semibold">
                            @if($schedule->semesterData->is_active)
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">✓ ใช้งาน</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">ปิดใช้งาน</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Actions -->
            <div class="flex gap-4 mb-8">
                <a href="{{ route('schedules.edit', $schedule->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded">
                    ✏️ แก้ไข
                </a>
                <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded" onclick="return confirm('คุณแน่ใจหรือว่าต้องการลบ?')">
                        🗑️ ลบ
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
