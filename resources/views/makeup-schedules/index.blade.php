<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">จัดการตารางชดเชย</h1>
                        <p class="text-gray-600">รวมทั้งสิ้น <span class="font-bold text-blue-600">{{ $makeupSchedules->total() }}</span> ตารางชดเชย</p>
                    </div>
                    <a href="{{ route('makeup-schedules.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        + เพิ่มตารางชดเชย
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search Bar -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <form action="{{ route('makeup-schedules.index') }}" method="GET" class="flex flex-col lg:flex-row gap-3">
                    <input type="text" name="search" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="ค้นหาวิชา ชั้นเรียน ห้อง หรืออาจารย์..."
                           value="{{ old('search', $search ?? '') }}">
                    <select name="semester_id" class="lg:w-72 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">ทุกภาคเรียน</option>
                        @foreach($semesters as $semester)
                            <option value="{{ $semester->id }}" {{ (string) $semesterId === (string) $semester->id ? 'selected' : '' }}>
                                {{ $semester->name }} (พ.ศ. {{ $semester->year }})
                            </option>
                        @endforeach
                    </select>
                    <div class="flex gap-3">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                            ค้นหา
                        </button>
                        @if($search || $semesterId)
                            <a href="{{ route('makeup-schedules.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-semibold transition text-center">
                                ล้าง
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Schedules Table -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">วันที่</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">ชั้นเรียน</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">วิชา</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">อาจารย์</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">เวลา</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">ห้อง</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($makeupSchedules as $schedule)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        <div class="font-semibold text-gray-800">{{ $schedule->makeup_date?->format('d/m/Y') ?? '-' }}</div>
                                        <div class="text-xs text-gray-500">{{ $schedule->makeup_date?->locale('th')->translatedFormat('l') }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $schedule->studentClass->class_name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-800">
                                        {{ $schedule->subject->name ?? '-' }}
                                        @if($schedule->status === 'completed')
                                            <span class="ml-2 inline-flex items-center bg-gray-100 text-gray-500 border border-gray-300 px-2 py-0.5 rounded text-xs font-normal" title="สอนเสร็จสิ้นแล้ว">
                                                ✔️ เสร็จสิ้น
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $schedule->teacher->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ substr((string) $schedule->start_time, 0, 5) }} - {{ substr((string) $schedule->end_time, 0, 5) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $schedule->room ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex gap-2">
                                            @if($schedule->status === 'pending')
                                            <form action="{{ route('makeup-schedules.complete', $schedule) }}" method="POST" style="display:inline;" onsubmit="return confirm('ยืนยันว่าสอนชดเชยเสร็จสิ้นแล้ว?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded transition" title="ยืนยันสอนเสร็จ">
                                                    ✅
                                                </button>
                                            </form>
                                            @endif
                                            <a href="{{ route('makeup-schedules.edit', $schedule) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded transition" title="แก้ไข">
                                                ✏️
                                            </a>
                                            <form action="{{ route('makeup-schedules.destroy', $schedule) }}" method="POST" style="display:inline;" onsubmit="return confirm('ยืนยันการลบ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded transition" title="ลบ">
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
                                            <p class="text-lg">ไม่พบตารางชดเชย</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="bg-gray-50 px-6 py-4 border-t">
                    {{ $makeupSchedules->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
