
<x-app-layout>
    <div class="container mx-auto py-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-4 text-blue-700">จัดตารางการทำงานของหมอ</h2>
            <p class="mb-6 text-gray-600">หน้านี้สำหรับจัดการและดูตารางการทำงานของแพทย์ในคลินิก</p>
            <div class="mb-4">
                <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">+ เพิ่มตารางใหม่</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">ชื่อแพทย์</th>
                            <th class="py-2 px-4 border-b">วัน</th>
                            <th class="py-2 px-4 border-b">เวลาเริ่ม</th>
                            <th class="py-2 px-4 border-b">เวลาสิ้นสุด</th>
                            <th class="py-2 px-4 border-b">การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- ตัวอย่างข้อมูล สามารถแทนที่ด้วยข้อมูลจริงได้ -->
                        <tr>
                            <td class="py-2 px-4 border-b">นพ. สมชาย ใจดี</td>
                            <td class="py-2 px-4 border-b">จันทร์</td>
                            <td class="py-2 px-4 border-b">09:00</td>
                            <td class="py-2 px-4 border-b">16:00</td>
                            <td class="py-2 px-4 border-b">
                                <a href="#" class="text-blue-600 hover:underline mr-2">แก้ไข</a>
                                <a href="#" class="text-red-600 hover:underline">ลบ</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">พญ. สมหญิง ดีใจ</td>
                            <td class="py-2 px-4 border-b">อังคาร</td>
                            <td class="py-2 px-4 border-b">10:00</td>
                            <td class="py-2 px-4 border-b">15:00</td>
                            <td class="py-2 px-4 border-b">
                                <a href="#" class="text-blue-600 hover:underline mr-2">แก้ไข</a>
                                <a href="#" class="text-red-600 hover:underline">ลบ</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
