
<x-app-layout>
    <div class="container mx-auto py-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-4 text-blue-700">แก้ไขตารางการทำงาน</h2>
            
            <form action="{{ route('doctor_schedules.update', $id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="doctor_id" class="block text-gray-700 font-semibold mb-2">ชื่อแพทย์</label>
                    <select id="doctor_id" name="doctor_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                        <option value="">-- เลือกแพทย์ --</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->name }} ({{ $doctor->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="day" class="block text-gray-700 font-semibold mb-2">วัน</label>
                    <select id="day" name="day" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                        <option value="">-- เลือกวัน --</option>
                        <option value="จันทร์">จันทร์</option>
                        <option value="อังคาร">อังคาร</option>
                        <option value="พุธ">พุธ</option>
                        <option value="พฤหัส">พฤหัส</option>
                        <option value="ศุกร์">ศุกร์</option>
                        <option value="เสาร์">เสาร์</option>
                        <option value="อาทิตย์">อาทิตย์</option>
                    </select>
                </div>

                <div>
                    <label for="start_time" class="block text-gray-700 font-semibold mb-2">เวลาเริ่ม</label>
                    <input type="time" id="start_time" name="start_time" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                </div>

                <div>
                    <label for="end_time" class="block text-gray-700 font-semibold mb-2">เวลาสิ้นสุด</label>
                    <input type="time" id="end_time" name="end_time" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">บันทึก</button>
                    <a href="{{ route('doctor.schedule') }}" class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded">ยกเลิก</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
