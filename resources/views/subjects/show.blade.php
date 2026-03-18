<x-app-layout>
<div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    @php
        $canManageSubject = strtolower(auth()->user()->role ?? '') === 'admin';
    @endphp

    {{-- Header --}}
    <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $subject->name }}</h1>
                <p class="text-gray-500 text-sm mt-1">รหัสวิชา: {{ $subject->subject_code }}</p>
            </div>
            @if($canManageSubject)
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('subjects.edit', $subject) }}"
                   class="bg-amber-500 hover:bg-amber-600 text-white px-5 py-2 rounded-lg font-semibold transition">แก้ไข</a>
                <form action="{{ route('subjects.destroy', $subject) }}" method="POST" onsubmit="return confirm('ยืนยันการลบวิชา {{ $subject->name }}?')">
                    @csrf @method('DELETE')
                    <button class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg font-semibold transition">ลบ</button>
                </form>
            </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

        {{-- Subject Detail --}}
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">รายละเอียดวิชา</h2>
            <dl class="space-y-3 text-sm">
                <div class="flex gap-2"><dt class="font-semibold text-gray-500 w-28">รหัสวิชา</dt><dd class="text-gray-800">{{ $subject->subject_code }}</dd></div>
                <div class="flex gap-2"><dt class="font-semibold text-gray-500 w-28">ชื่อวิชา</dt><dd class="text-gray-800">{{ $subject->name }}</dd></div>
                <div class="flex gap-2"><dt class="font-semibold text-gray-500 w-28">หน่วยกิต</dt><dd class="text-gray-800">{{ $subject->credits ?? '-' }}</dd></div>
                <div class="flex gap-2"><dt class="font-semibold text-gray-500 w-28">ผู้สอน</dt><dd class="text-gray-800">{{ $subject->teacher->name ?? '-' }}</dd></div>
                <div class="flex gap-2"><dt class="font-semibold text-gray-500 w-28">รายละเอียด</dt><dd class="text-gray-800">{{ $subject->description ?? '-' }}</dd></div>
                <div class="flex gap-2"><dt class="font-semibold text-gray-500 w-28">สร้างเมื่อ</dt><dd class="text-gray-800">{{ $subject->created_at->format('d/m/Y H:i') }}</dd></div>
            </dl>
        </div>

        {{-- Schedule (Realtime) --}}
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">ตารางเรียนวันนี้</h2>
                    <p class="text-xs text-gray-400 mt-0.5">{{ \Carbon\Carbon::today()->locale('th')->translatedFormat('l j F Y') }}</p>
                </div>
                <span id="schedule-status" class="text-xs text-gray-400">กำลังโหลด...</span>
            </div>
            <div id="schedule-list">
                {{-- โหลดจาก JS --}}
                <div class="text-center text-gray-400 py-6 text-sm">กำลังโหลดข้อมูล...</div>
            </div>
        </div>
    </div>

    @if($attendanceRecords !== null)
        {{-- รายชื่อนักศึกษาในรายวิชา --}}
        @if(isset($enrolledStudents) && $enrolledStudents->count() > 0)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h2 class="font-bold text-gray-800 text-base">นักศึกษาในรายวิชานี้ ({{ $enrolledStudents->count() }} คน)</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-xs">
                        <tr>
                            <th class="px-5 py-3 text-left font-semibold text-gray-600">รหัส / ชื่อ-นามสกุล</th>
                            <th class="px-3 py-3 text-center font-semibold text-green-600">มาเรียน</th>
                            <th class="px-3 py-3 text-center font-semibold text-red-500">ขาด</th>
                            <th class="px-3 py-3 text-center font-semibold text-amber-500">สาย</th>
                            <th class="px-3 py-3 text-center font-semibold text-blue-500">ลา</th>
                            <th class="px-3 py-3 text-center font-semibold text-gray-600">อัตราเข้าเรียน</th>
                            <th class="px-3 py-3 text-center font-semibold text-gray-600">รายงาน</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($enrolledStudents as $student)
                            @php
                                $s = $studentStats[$student->id] ?? ['present'=>0,'absent'=>0,'late'=>0,'excused'=>0,'percentage'=>0];
                                $pctColor = $s['percentage'] >= 80 ? 'text-green-600' : ($s['percentage'] >= 60 ? 'text-amber-500' : 'text-red-600');
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-5 py-2.5 whitespace-nowrap">
                                    <span class="text-gray-400 text-xs mr-1">{{ $student->student_id }}</span>{{ $student->name }}
                                </td>
                                <td class="px-3 py-2.5 text-center font-bold text-green-600">{{ $s['present'] }}</td>
                                <td class="px-3 py-2.5 text-center font-bold text-red-500">{{ $s['absent'] }}</td>
                                <td class="px-3 py-2.5 text-center font-bold text-amber-500">{{ $s['late'] }}</td>
                                <td class="px-3 py-2.5 text-center font-bold text-blue-500">{{ $s['excused'] }}</td>
                                <td class="px-3 py-2.5 text-center font-bold {{ $pctColor }}">{{ $s['percentage'] }}%</td>
                                <td class="px-3 py-2.5 text-center">
                                    <a href="{{ route('reports.individualReport', ['student' => $student, 'subject' => $subject->id]) }}"
                                       class="bg-sky-400 hover:bg-sky-500 text-white text-xs font-semibold px-3 py-1 rounded transition">
                                        ดูรายงาน
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        @if($dates->count() > 0)
            {{-- วันเดือนปีที่มีการเช็คชื่อ --}}
            <div class="bg-white rounded-xl shadow overflow-hidden mt-4">
                <div class="px-6 py-4 border-b bg-pink-50">
                    <h2 class="font-bold text-gray-800 text-base">วันเดือนปีที่มีการเช็คชื่อ</h2>
                </div>
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="px-6 py-3 text-left">ว/ด/ป</th>
                            <th class="px-6 py-3 text-center">ดูข้อมูล</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dates as $d)
                            @php $rowId = 'subj-detail-' . str_replace('-', '', $d); @endphp
                            <tr class="border-t">
                                <td class="px-6 py-3 text-gray-700">
                                    {{ \Carbon\Carbon::parse($d)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <button onclick="toggleRow('{{ $rowId }}')"
                                            style="background:#38bdf8;color:#fff;font-size:0.75rem;font-weight:600;padding:4px 14px;border-radius:4px;border:none;cursor:pointer;">
                                        ดูข้อมูล
                                    </button>
                                </td>
                            </tr>
                            <tr id="{{ $rowId }}" style="display:none;" class="bg-slate-50">
                                <td colspan="2" class="px-8 py-4">
                                    <table class="min-w-full text-sm">
                                        <thead>
                                            <tr class="text-xs text-gray-500 border-b">
                                                <th class="text-left py-1 pr-6">รหัสนักศึกษา</th>
                                                <th class="text-left py-1 pr-6">ชื่อ-นามสกุล</th>
                                                <th class="text-center py-1">สถานะ</th>
                                                <th class="text-center py-1">รายงาน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($dateAttendances[$d] ?? [] as $att)
                                                <tr class="border-t">
                                                    <td class="py-1.5 pr-6 text-gray-400 text-xs">{{ $att->student->student_id }}</td>
                                                    <td class="py-1.5 pr-6 text-gray-700">{{ $att->student->name }}</td>
                                                    <td class="py-1.5 text-center">
                                                        @if($att->status === 'present')
                                                            <span class="text-green-600 font-semibold">มาเรียน</span>
                                                        @elseif($att->status === 'absent')
                                                            <span class="text-red-500 font-semibold">ขาด</span>
                                                        @elseif($att->status === 'late')
                                                            <span class="text-amber-500 font-semibold">มาสาย</span>
                                                        @elseif($att->status === 'excused')
                                                            <span class="text-blue-500 font-semibold">ลา</span>
                                                        @endif
                                                    </td>
                                                    <td class="py-1.5 text-center">
                                                        <a href="{{ route('reports.individualReport', ['student' => $att->student, 'subject' => $subject->id]) }}"
                                                           style="background:#38bdf8;color:#fff;font-size:0.75rem;font-weight:600;padding:4px 12px;border-radius:4px;display:inline-block;text-decoration:none;">
                                                            ดูรายงาน
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <script>
            function toggleRow(id) {
                var row = document.getElementById(id);
                if (row) row.style.display = row.style.display === 'none' ? '' : 'none';
            }
            </script>
        @elseif($attendanceRecords !== null)
            <div class="bg-white rounded-xl shadow px-6 py-8 text-center text-blue-700 font-medium mt-4">
                ยังไม่มีข้อมูลเวลาเรียนของนักศึกษาในรายวิชานี้
            </div>
        @endif
    @endif

    <div class="mb-8">
        <a href="{{ route('subjects.index') }}"
           class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg font-semibold transition">กลับ</a>
    </div>

</div>
</div>

<script>
(function () {
    const url  = '{{ route('subjects.schedules-json', $subject) }}';
    const el   = document.getElementById('schedule-list');
    const stat = document.getElementById('schedule-status');

    function renderSchedules(data) {
        if (!data.length) {
            el.innerHTML = '<p class="text-gray-400 text-sm text-center py-6">ไม่มีตารางเรียนสำหรับวันนี้</p>';
            return;
        }
        const rows = data.map(s =>
            `<div class="flex items-center gap-3 py-2.5 border-b last:border-0">
                <div class="flex-shrink-0 w-2 h-2 rounded-full bg-emerald-400"></div>
                <div class="flex-1 text-sm">
                    <span class="font-semibold text-gray-800">${s.class_name}</span>
                    <span class="mx-1 text-gray-400">&mdash;</span>
                    <span class="text-gray-600">วัน${s.day}</span>
                    <span class="ml-2 text-gray-500">${s.start_time.slice(0,5)}&ndash;${s.end_time.slice(0,5)}</span>
                    <span class="ml-2 text-xs text-gray-400">ห้อง ${s.room}</span>
                </div>
            </div>`
        ).join('');
        el.innerHTML = rows;
    }

    async function fetchSchedules() {
        try {
            const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await res.json();
            renderSchedules(data);
            const now = new Date();
            stat.textContent = 'อัปเดต ' + now.getHours().toString().padStart(2,'0') + ':' + now.getMinutes().toString().padStart(2,'0') + ':' + now.getSeconds().toString().padStart(2,'0');
        } catch (e) {
            stat.textContent = 'ไม่สามารถโหลดได้';
        }
    }

    fetchSchedules();
    setInterval(fetchSchedules, 10000); // poll ทุก 10 วินาที
})();

function toggleRow(id) {
    var row = document.getElementById(id);
    if (row) row.style.display = row.style.display === 'none' ? '' : 'none';
}
</script>
</x-app-layout>
