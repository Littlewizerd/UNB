<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <h1 class="text-3xl font-bold text-gray-800">{{ $semester->name }}</h1>
            </div>

            <!-- Info Card -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="border-b md:border-b-0 pb-4 md:pb-0">
                        <p class="text-gray-600 text-sm">ปีการศึกษา</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $semester->year }}</p>
                    </div>

                    <div class="border-b md:border-b-0 pb-4 md:pb-0">
                        <p class="text-gray-600 text-sm">สถานะ</p>
                        @if($semester->is_active)
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">ใช้งาน</span>
                        @else
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-800">ปิดใช้งาน</span>
                        @endif
                    </div>

                    <div class="border-b md:border-b-0 pb-4 md:pb-0">
                        <p class="text-gray-600 text-sm">วันเริ่มต้น</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $semester->start_date->format('d/m/Y') }}</p>
                    </div>

                    <div class="border-b pb-4 md:border-b-0 md:pb-0">
                        <p class="text-gray-600 text-sm">วันสิ้นสุด</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $semester->end_date->format('d/m/Y') }}</p>
                    </div>

                    <div class="border-b md:border-b-0 pb-4 md:pb-0">
                        <p class="text-gray-600 text-sm">สร้างเมื่อ</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $semester->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="border-b pb-4 md:border-b-0 md:pb-0">
                        <p class="text-gray-600 text-sm">แก้ไขล่าสุด</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $semester->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 pt-6 border-t">
                    <a href="{{ route('semesters.edit', $semester) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg font-semibold transition">
                        แก้ไข
                    </a>
                    <a href="{{ route('semesters.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-semibold transition">
                        กลับ
                    </a>
                    <form action="{{ route('semesters.destroy', $semester) }}" method="POST" style="display:inline;" 
                          onsubmit="return confirm('ยืนยันการลบภาคเรียน {{ addslashes($semester->name) }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                            ลบ
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
