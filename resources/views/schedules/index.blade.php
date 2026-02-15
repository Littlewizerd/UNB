<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">จัดการตารางเรียน</h1>
                        <p class="text-gray-600">รวมทั้งสิ้น <span class="font-bold text-blue-600">{{ $schedules->total() }}</span> ตารางเรียน</p>
                    </div>
                    <a href="{{ route('schedules.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        + เพิ่มตารางเรียน
                    </a>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <form action="{{ route('schedules.index') }}" method="GET" class="flex gap-3">
                    <input type="text" name="search" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           placeholder="ค้นหาวิชาหรือชั้นเรียน..." 
                           value="{{ old('search', $search ?? '') }}">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                        ค้นหา
                    </button>
                    @if($search)
                        <a href="{{ route('schedules.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-semibold transition">
                            ล้าง
                        </a>
                    @endif
                </form>
            </div>

            <!-- Schedules Table -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">ชั้นเรียน</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">วิชา</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">อาจารย์</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">วัน</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">เวลา</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">ห้อง</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schedules as $schedule)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $schedule->studentClass->class_name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ $schedule->subject->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $schedule->teacher->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ \App\Models\Schedule::DAYS[$schedule->day_of_week] ?? $schedule->day_of_week }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $schedule->room ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex gap-2">
                                            <a href="{{ route('schedules.edit', $schedule) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded transition">
                                                ✏️
                                            </a>
                                            <form action="{{ route('schedules.destroy', $schedule) }}" method="POST" style="display:inline;" 
                                                  onsubmit="return confirm('ยืนยันการลบ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded transition">
                                                    🗑️
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center">
                                        <div class="text-gray-500">
                                            <p class="text-lg">ไม่พบตารางเรียน</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-gray-50 px-6 py-4 border-t">
                    {{ $schedules->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
