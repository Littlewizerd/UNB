
<x-app-layout>
    <div class="container mx-auto py-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-2 text-blue-700">จองคิวคลินิก</h2>
            <p class="mb-2 text-gray-700">เบอดวิวคิว</p>
            <p class="mb-6 text-gray-600">คุณกำลังจองคิว หมอ.....</p>
            <p class="mb-6 text-sm text-gray-600">งานบริการ :: จองคิวคลินิกแสนดี</p>

            <form method="GET" action="{{ route('queue.booking-table') }}" class="mb-6">
                <div class="flex gap-6 items-center">
                    <div class="flex-1">
                        <label for="doctor" class="block text-gray-700 font-semibold mb-2">หมอ A <span class="ml-2">⬇</span></label>
                        <select id="doctor" name="doctor" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor['id'] }}">{{ $doctor['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1">
                        <label for="day" class="block text-gray-700 font-semibold mb-2">วันที่ <span class="ml-2">⬇</span></label>
                        <select id="day" name="day" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <option value="">-- เลือกวัน --</option>
                            <option value="Mon">จันทร์ (Mon)</option>
                            <option value="Tue">อังคาร (Tue)</option>
                            <option value="Wed">พุธ (Wed)</option>
                            <option value="Thu">พฤหัสบดี (Thu)</option>
                            <option value="Fri">ศุกร์ (Fri)</option>
                            <option value="Sat">เสาร์ (Sat)</option>
                            <option value="Sun">อาทิตย์ (Sun)</option>
                        </select>
                    </div>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full bg-white border border-gray-300 text-center text-sm">
                    <thead>
                        <tr class="bg-teal-500 text-white font-bold">
                            <th class="py-3 px-2 border border-gray-300">Mon</th>
                            <th class="py-3 px-2 border border-gray-300">Tue</th>
                            <th class="py-3 px-2 border border-gray-300">Wed</th>
                            <th class="py-3 px-2 border border-gray-300">Thu</th>
                            <th class="py-3 px-2 border border-gray-300">Fri</th>
                            <th class="py-3 px-2 border border-gray-300">Sat</th>
                            <th class="py-3 px-2 border border-gray-300">Sun</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($timeSlots as $time)
                            <tr>
                                @foreach($days as $day)
                                    <td class="py-3 px-2 border border-gray-300">
                                        <button class="w-full py-2 px-1 border-2 border-gray-300 rounded bg-gray-100 hover:bg-blue-200 font-semibold text-gray-700 transition">
                                            {{ $time }}
                                        </button>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
