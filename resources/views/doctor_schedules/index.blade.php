
<x-app-layout>
    <div class="container mx-auto py-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-4 text-blue-700">จัดตารางการทำงานของหมอ</h2>
            <p class="mb-6 text-gray-600">หน้านี้สำหรับจัดการและดูตารางการทำงานของแพทย์ในคลินิก</p>
            <div class="mb-4">
                <a href="{{ route('doctor_schedules.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">+ เพิ่มตารางใหม่</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">ชื่อแพทย์</th>
                            <th class="py-2 px-4 border-b">อีเมล</th>
                            <th class="py-2 px-4 border-b">วัน</th>
                            <th class="py-2 px-4 border-b">เวลาเริ่ม</th>
                            <th class="py-2 px-4 border-b">เวลาสิ้นสุด</th>
                            <th class="py-2 px-4 border-b">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($doctors as $doctor)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $doctor->name }}</td>
                            <td class="py-2 px-4 border-b">{{ $doctor->email }}</td>
                            <td class="py-2 px-4 border-b">จันทร์-ศุกร์</td>
                            <td class="py-2 px-4 border-b">09:00</td>
                            <td class="py-2 px-4 border-b">16:00</td>
                            <td class="py-2 px-4 border-b">
                                <a href="{{ route('doctor_schedules.edit', $doctor->id) }}" class="text-blue-600 hover:underline mr-2">แก้ไข</a>
                                <form action="{{ route('doctor_schedules.destroy', $doctor->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline delete-btn" onclick="return confirm('ยืนยันการลบตารางนี้?');">ลบ</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-4 px-4 text-center text-gray-500">ไม่มีข้อมูลแพทย์</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
