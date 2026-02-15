<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">จัดการภาคเรียน</h1>
                        <p class="text-gray-600">รวมทั้งสิ้น <span class="font-bold text-blue-600">{{ $semesters->total() }}</span> ภาคเรียน</p>
                    </div>
                    <a href="{{ route('semesters.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        + เพิ่มภาคเรียน
                    </a>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search Bar -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <form action="{{ route('semesters.index') }}" method="GET" class="flex gap-3">
                    <input type="text" name="search" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           placeholder="ค้นหาชื่อหรือปีการศึกษา..." 
                           value="{{ old('search', $search ?? '') }}">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                        ค้นหา
                    </button>
                    @if($search)
                        <a href="{{ route('semesters.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-semibold transition">
                            ล้าง
                        </a>
                    @endif
                </form>
            </div>

            <!-- Semesters Table -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">ชื่อภาคเรียน</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">ปีการศึกษา</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">วันเริ่มต้น</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">วันสิ้นสุด</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">สถานะ</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($semesters as $semester)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ $semester->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $semester->year }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $semester->start_date->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $semester->end_date->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        @if($semester->is_active)
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">ใช้งาน</span>
                                        @else
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">ปิดใช้งาน</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex gap-2">
                                            <a href="{{ route('semesters.show', $semester) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded transition" title="ดู">
                                                👁️
                                            </a>
                                            <a href="{{ route('semesters.edit', $semester) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded transition" title="แก้ไข">
                                                ✏️
                                            </a>
                                            <form action="{{ route('semesters.destroy', $semester) }}" method="POST" style="display:inline;" 
                                                  onsubmit="return confirm('ยืนยันการลบ {{ addslashes($semester->name) }}?')">
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
                                    <td colspan="6" class="px-6 py-8 text-center">
                                        <div class="text-gray-500">
                                            <p class="text-lg">ไม่พบภาคเรียน</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-gray-50 px-6 py-4 border-t">
                    {{ $semesters->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
