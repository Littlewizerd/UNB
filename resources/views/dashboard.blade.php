<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">แผงควบคุม</h1>
                        <p class="text-gray-600">ยินดีต้อนรับ, {{ Auth::user()->name }}! 
                            <span class="inline-block ml-2 px-3 py-1 rounded-full text-sm font-semibold
                                @if(Auth::user()->role === 'admin') bg-blue-100 text-blue-800
                                @elseif(Auth::user()->role === 'teacher') bg-yellow-100 text-yellow-800
                                @else bg-green-100 text-green-800
                                @endif">
                                @if(Auth::user()->role === 'admin') ผู้ดูแลระบบ
                                @elseif(Auth::user()->role === 'teacher') อาจารย์
                                @else นักเรียน
                                @endif
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            @if(Auth::user()->role === 'admin' && isset($stats))
            <!-- Admin Statistics -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <div class="text-3xl font-bold text-blue-600">{{ $stats['totalUsers'] }}</div>
                    <div class="text-sm text-gray-600">ผู้ใช้ทั้งหมด</div>
                </div>
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <div class="text-3xl font-bold text-green-600">{{ $stats['totalStudents'] }}</div>
                    <div class="text-sm text-gray-600">นักเรียน</div>
                </div>
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <div class="text-3xl font-bold text-yellow-600">{{ $stats['totalTeachers'] }}</div>
                    <div class="text-sm text-gray-600">อาจารย์</div>
                </div>
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <div class="text-3xl font-bold text-purple-600">{{ $stats['totalClasses'] }}</div>
                    <div class="text-sm text-gray-600">ชั้นเรียน</div>
                </div>
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <div class="text-3xl font-bold text-orange-600">{{ $stats['totalSubjects'] }}</div>
                    <div class="text-sm text-gray-600">วิชา</div>
                </div>
                <div class="bg-white rounded-lg shadow p-4 text-center">
                    <div class="text-3xl font-bold text-pink-600">{{ $stats['totalSchedules'] }}</div>
                    <div class="text-sm text-gray-600">ตารางเรียน</div>
                </div>
            </div>

            <!-- Today's Attendance Summary -->
            @if(isset($todayAttendance))
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">สรุปการเข้าเรียนวันนี้</h2>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-gray-800">{{ $todayAttendance['total'] }}</div>
                        <div class="text-sm text-gray-600">ทั้งหมด</div>
                    </div>
                    <div class="text-center p-3 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $todayAttendance['present'] }}</div>
                        <div class="text-sm text-gray-600">มาเรียน</div>
                    </div>
                    <div class="text-center p-3 bg-red-50 rounded-lg">
                        <div class="text-2xl font-bold text-red-600">{{ $todayAttendance['absent'] }}</div>
                        <div class="text-sm text-gray-600">ขาด</div>
                    </div>
                    <div class="text-center p-3 bg-yellow-50 rounded-lg">
                        <div class="text-2xl font-bold text-yellow-600">{{ $todayAttendance['late'] }}</div>
                        <div class="text-sm text-gray-600">สาย</div>
                    </div>
                    <div class="text-center p-3 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $todayAttendance['excused'] }}</div>
                        <div class="text-sm text-gray-600">ลา</div>
                    </div>
                </div>
            </div>
            @endif
            @endif

            @if(Auth::user()->role === 'teacher' && isset($stats))
            <!-- Teacher Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-4xl font-bold text-pink-600">{{ $stats['totalSchedules'] }}</div>
                    <div class="text-gray-600">ตารางสอนทั้งหมด</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-4xl font-bold text-purple-600">{{ $stats['totalClasses'] }}</div>
                    <div class="text-gray-600">ชั้นเรียนที่สอน</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-4xl font-bold text-green-600">{{ $stats['totalStudents'] }}</div>
                    <div class="text-gray-600">นักเรียนทั้งหมด</div>
                </div>
            </div>

            @if(isset($todaySchedules) && $todaySchedules->count() > 0)
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">ตารางสอนวันนี้</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">เวลา</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">วิชา</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ชั้นเรียน</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ห้อง</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($todaySchedules as $schedule)
                            <tr>
                                <td class="px-4 py-3 text-sm">{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                                <td class="px-4 py-3 text-sm font-medium">{{ $schedule->subject->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm">{{ $schedule->studentClass->class_name ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm">{{ $schedule->room ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            @endif

            @if(Auth::user()->role === 'student' && isset($stats))
            <!-- Student Statistics -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-4xl font-bold text-green-600">{{ $stats['present'] }}</div>
                    <div class="text-gray-600">มาเรียน</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-4xl font-bold text-red-600">{{ $stats['absent'] }}</div>
                    <div class="text-gray-600">ขาด</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-4xl font-bold text-yellow-600">{{ $stats['late'] }}</div>
                    <div class="text-gray-600">สาย</div>
                </div>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <div class="text-4xl font-bold {{ $stats['percentage'] >= 80 ? 'text-green-600' : ($stats['percentage'] >= 60 ? 'text-yellow-600' : 'text-red-600') }}">{{ $stats['percentage'] }}%</div>
                    <div class="text-gray-600">อัตราเข้าเรียน</div>
                </div>
            </div>

            @if(isset($todaySchedules) && $todaySchedules->count() > 0)
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">ตารางเรียนวันนี้</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">เวลา</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">วิชา</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">อาจารย์ผู้สอน</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ห้อง</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($todaySchedules as $schedule)
                            <tr>
                                <td class="px-4 py-3 text-sm">{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                                <td class="px-4 py-3 text-sm font-medium">{{ $schedule->subject->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm">{{ $schedule->teacher->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm">{{ $schedule->room ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            @endif

            <!-- Main Dashboard Content -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Menu Items based on Role -->
                @if(Auth::user()->role === 'admin')
                    <!-- Admin Menu -->
                    <a href="{{ route('users.index') }}" class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">จัดการผู้ใช้</h3>
                                <p class="text-sm text-gray-600">จัดการบัญชีหรือสิทธิ์ผู้ใช้</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('students.index') }}" class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">จัดการนักเรียน</h3>
                                <p class="text-sm text-gray-600">ดูและจัดการนักเรียน</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('classes.index') }}" class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M5 13h14v8H5z M19 3H5c-1.1 0-2 .9-2 2v4h16V5c0-1.1-.9-2-2-2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">จัดการชั้นเรียน</h3>
                                <p class="text-sm text-gray-600">ดูและจัดการชั้นเรียน</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('subjects.index') }}" class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-orange-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">จัดการวิชา</h3>
                                <p class="text-sm text-gray-600">ดูและจัดการวิชาเรียน</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('semesters.index') }}" class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">จัดการภาคเรียน</h3>
                                <p class="text-sm text-gray-600">ดูและจัดการภาคเรียน</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('schedules.index') }}" class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-pink-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">ตารางเรียน</h3>
                                <p class="text-sm text-gray-600">ดูและจัดการตารางเรียน</p>
                            </div>
                        </div>
                    </a>

                @endif

                @if(Auth::user()->role === 'student')
                    <!-- Student Menu -->
                    <a href="{{ route('subjects.index') }}" class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">วิชาเรียน</h3>
                                <p class="text-sm text-gray-600">ดูรายวิชาที่เรียน</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('schedules.student-schedule') }}" class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-pink-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">ตารางเรียนของฉัน</h3>
                                <p class="text-sm text-gray-600">ดูตารางเรียนส่วนตัว</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('messages.index') }}" class="bg-gradient-to-br from-cyan-50 to-cyan-100 rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-cyan-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 9h12v2H6V9zm13 5H6v-2h13v2zm0-4H6V8h13v2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">ข้อความ</h3>
                                <p class="text-sm text-gray-600">ส่งข้อความถึงอาจารย์</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('reports.individualReport', Auth::id()) }}" class="bg-gradient-to-br from-teal-50 to-teal-100 rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-teal-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">รายงานผลเข้าเรียน</h3>
                                <p class="text-sm text-gray-600">ดูและส่งออก PDF</p>
                            </div>
                        </div>
                    </a>
                @endif

                @if(Auth::user()->role === 'teacher')
                    <!-- Teacher Menu -->
                    <a href="{{ route('teacher.record') }}" class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-yellow-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">บันทึกเวลา</h3>
                                <p class="text-sm text-gray-600">บันทึกการลงเวลานักเรียน</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('students.index') }}" class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">จัดการนักศึกษา</h3>
                                <p class="text-sm text-gray-600">จัดการข้อมูลนักศึกษาในรายวิชา</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('subjects.index') }}" class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">รายวิชาที่สอน</h3>
                                <p class="text-sm text-gray-600">ดูรายวิชาที่สอนทั้งหมด</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('schedules.teacher-schedule') }}" class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-pink-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">ตารางสอนของฉัน</h3>
                                <p class="text-sm text-gray-600">ดูตารางสอนส่วนตัว</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('messages.index') }}" class="bg-gradient-to-br from-cyan-50 to-cyan-100 rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-cyan-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 9h12v2H6V9zm13 5H6v-2h13v2zm0-4H6V8h13v2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">ข้อความ</h3>
                                <p class="text-sm text-gray-600">ส่งข้อความถึงนักศึกษา</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('reports.dailySummary') }}" class="bg-gradient-to-br from-teal-50 to-teal-100 rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-teal-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">รายงาน</h3>
                                <p class="text-sm text-gray-600">ส่งออกรายงาน PDF</p>
                            </div>
                        </div>
                    </a>
                @endif
            </div>

            <!-- Info Box -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">ข้อมูลบัญชี</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-600 text-sm">ชื่อ</p>
                        <p class="font-semibold text-lg">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-600 text-sm">อีเมล</p>
                        <p class="font-semibold text-sm">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-600 text-sm">บทบาท</p>
                        <p class="font-semibold text-lg">
                            @if(Auth::user()->role === 'admin') ผู้ดูแลระบบ
                            @elseif(Auth::user()->role === 'teacher') อาจารย์
                            @else นักเรียน
                            @endif
                        </p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-600 text-sm">สมาชิกตั้งแต่</p>
                        <p class="font-semibold text-sm">{{ Auth::user()->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
