
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
                            @forelse($doctors as $doctor)
                                <option value="{{ $doctor->id ?? $doctor['id'] }}">{{ $doctor->name ?? $doctor['name'] }}</option>
                            @empty
                                <option value="">ไม่มีข้อมูลแพทย์</option>
                            @endforelse
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
                                        <button onclick="openBookingModal('{{ $time }}', '{{ $day }}')" class="w-full py-2 px-1 border-2 border-gray-300 rounded bg-gray-100 hover:bg-blue-200 font-semibold text-gray-700 transition">
                                            {{ str_replace(':', '.', $time) }}
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

    <!-- Modal จองคิว -->
    <div id="bookingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full mx-4">
            <h3 class="text-xl font-bold mb-4 text-blue-700">ยืนยันการจองคิว</h3>
            
            <form id="bookingForm" method="POST" action="{{ route('queue.book') }}" class="space-y-4">
                @csrf
                
                <div>
                    <label for="doctor" class="block text-gray-700 font-semibold mb-2">แพทย์</label>
                    <input type="text" id="doctor_display" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" readonly>
                    <input type="hidden" id="doctor_id" name="doctor_id">
                </div>

                <div>
                    <label for="day" class="block text-gray-700 font-semibold mb-2">วัน</label>
                    <input type="text" id="day" name="day" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" readonly required>
                </div>

                <div>
                    <label for="time" class="block text-gray-700 font-semibold mb-2">เวลา</label>
                    <input type="text" id="time" name="time" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" readonly required>
                </div>

                <div>
                    <label for="name" class="block text-gray-700 font-semibold mb-2">ชื่อ-นามสกุล</label>
                    <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                </div>

                <div>
                    <label for="phone" class="block text-gray-700 font-semibold mb-2">เบอร์โทร</label>
                    <input type="tel" id="phone" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">ยืนยันจองคิว</button>
                    <button type="button" onclick="closeBookingModal()" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded transition">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openBookingModal(time, day) {
            const doctorSelect = document.getElementById('doctor');
            const doctorName = doctorSelect.options[doctorSelect.selectedIndex].text;
            
            document.getElementById('doctor_display').value = doctorName;
            document.getElementById('doctor_id').value = doctorSelect.value;
            document.getElementById('time').value = time;
            document.getElementById('day').value = day;
            document.getElementById('bookingModal').classList.remove('hidden');
        }

        function closeBookingModal() {
            document.getElementById('bookingModal').classList.add('hidden');
        }

        // ปิด Modal เมื่อคลิกนอกพื้นที่
        document.getElementById('bookingModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeBookingModal();
            }
        });
    </script>
</x-app-layout>
