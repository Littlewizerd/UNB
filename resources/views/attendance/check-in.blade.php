<x-app-layout>
    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h1 class="text-2xl font-bold text-indigo-700">📋 ลงเวลาเข้าเรียน</h1>
                <p class="text-gray-500 mt-1">วันที่ <span class="font-semibold text-gray-700">{{ \Carbon\Carbon::today()->locale('th')->translatedFormat('l j F Y') }}</span></p>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-800 px-4 py-3 rounded mb-4">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-800 px-4 py-3 rounded mb-4">
                    <ul class="list-disc pl-4">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Schedule List --}}
            @if($schedules->count() > 0)
                <div class="space-y-4">
                    @foreach($schedules as $schedule)
                        @php
                            $alreadyChecked = isset($todayAttendances[$schedule->id]);
                            $checkedStatus = $alreadyChecked ? $todayAttendances[$schedule->id] : null;

                            $now = \Carbon\Carbon::now();
                            $startTime = \Carbon\Carbon::createFromTimeString($schedule->start_time);
                            $endTime = \Carbon\Carbon::createFromTimeString($schedule->end_time);
                            $isInSession = $now->between($startTime->copy()->subMinutes(30), $endTime);
                            $isPast = $now->greaterThan($endTime);
                        @endphp

                        <div class="bg-white rounded-lg shadow-md overflow-hidden border {{ $alreadyChecked ? 'border-green-300' : ($isInSession ? 'border-indigo-300' : 'border-gray-200') }}">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between p-5">
                                {{-- Subject Info --}}
                                <div class="flex-1 mb-3 md:mb-0">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-indigo-100 text-indigo-700 font-bold text-sm px-3 py-1 rounded">
                                            {{ $schedule->subject->subject_code ?? '-' }}
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-800">{{ $schedule->subject->name ?? '-' }}</h3>
                                    </div>
                                    <div class="flex flex-wrap gap-4 mt-2 text-sm text-gray-600">
                                        <span>🕐 {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</span>
                                        <span>🏫 ห้อง {{ $schedule->room ?? '-' }}</span>
                                        <span>👨‍🏫 {{ $schedule->teacher->name ?? '-' }}</span>
                                    </div>
                                </div>

                                {{-- Status / Actions --}}
                                <div class="flex-shrink-0">
                                    @if($alreadyChecked)
                                        {{-- Already checked in --}}
                                        @php
                                            $badgeClass = match($checkedStatus) {
                                                'present' => 'bg-green-100 text-green-800 border-green-300',
                                                'late' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                                                'absent' => 'bg-red-100 text-red-800 border-red-300',
                                                'excused' => 'bg-blue-100 text-blue-800 border-blue-300',
                                                default => 'bg-gray-100 text-gray-800 border-gray-300',
                                            };
                                            $badgeText = match($checkedStatus) {
                                                'present' => '✅ มาเรียน',
                                                'late' => '⚠️ มาสาย',
                                                'absent' => '❌ ขาดเรียน',
                                                'excused' => '📝 ลา',
                                                default => 'ไม่ระบุ',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-4 py-2 rounded-lg border text-sm font-bold {{ $badgeClass }}">
                                            {{ $badgeText }}
                                        </span>
                                    @elseif($isInSession)
                                        {{-- Can check in now --}}
                                        <div x-data="{ open: false }">
                                            <button @click="open = !open"
                                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-5 py-2.5 rounded-lg shadow transition flex items-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                ลงเวลาเข้าเรียน
                                            </button>

                                            {{-- Check-in form (inline expand) --}}
                                            <div x-show="open" x-transition class="mt-3 p-4 bg-indigo-50 rounded-lg border border-indigo-200">
                                                <form action="{{ route('attendance.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                        <div>
                                                            <label class="block text-sm font-semibold text-gray-700 mb-1">เวลาเข้า</label>
                                                            <input type="time" name="check_in_time" required
                                                                   value="{{ now()->format('H:i') }}"
                                                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-semibold text-gray-700 mb-1">เวลาออก <span class="text-gray-400 font-normal">(ไม่บังคับ)</span></label>
                                                            <input type="time" name="check_out_time"
                                                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center gap-3 mt-3">
                                                        <button type="submit"
                                                                class="bg-green-600 hover:bg-green-700 text-white font-bold px-4 py-2 rounded-lg shadow transition text-sm">
                                                            💾 บันทึก
                                                        </button>
                                                        <button type="button" @click="open = false"
                                                                class="text-gray-500 hover:text-gray-700 text-sm">
                                                            ยกเลิก
                                                        </button>
                                                    </div>

                                                    <p class="text-xs text-gray-500 mt-2">
                                                        ⏰ เข้าก่อนหรือตรงเวลา = <span class="text-green-600 font-semibold">มาเรียน</span> |
                                                        เข้าหลังเวลา = <span class="text-yellow-600 font-semibold">มาสาย</span>
                                                    </p>
                                                </form>
                                            </div>
                                        </div>
                                    @elseif($isPast)
                                        {{-- Session ended, not checked in --}}
                                        <span class="inline-flex items-center px-4 py-2 rounded-lg border border-red-200 bg-red-50 text-red-600 text-sm font-semibold">
                                            ❌ หมดเวลาลงเวลา
                                        </span>
                                    @else
                                        {{-- Not yet started --}}
                                        <span class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-200 bg-gray-50 text-gray-500 text-sm">
                                            🕓 ยังไม่ถึงเวลา
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Session indicator bar --}}
                            @if($isInSession && !$alreadyChecked)
                                <div class="bg-indigo-500 h-1"></div>
                            @elseif($alreadyChecked)
                                <div class="bg-green-500 h-1"></div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <div class="text-gray-300 mb-4">
                        <svg class="mx-auto h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <p class="text-gray-500 text-lg font-semibold">ไม่มีตารางเรียนในวันนี้</p>
                    <p class="text-gray-400 text-sm mt-1">ตรวจสอบตารางเรียนของคุณที่หน้าตารางเรียน</p>
                </div>
            @endif

            {{-- Legend --}}
            <div class="bg-white rounded-lg shadow-md p-4 mt-6">
                <h3 class="text-sm font-bold text-gray-700 mb-2">📌 สัญลักษณ์สถานะ</h3>
                <div class="flex flex-wrap gap-4 text-xs text-gray-600">
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-green-500 inline-block"></span> มาเรียน (เข้าก่อน/ตรงเวลา)</span>
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-yellow-500 inline-block"></span> มาสาย (หลังเวลาเริ่ม)</span>
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-red-500 inline-block"></span> ขาดเรียน (ไม่มาลงเวลา)</span>
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-blue-500 inline-block"></span> ลา (อาจารย์บันทึก)</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
