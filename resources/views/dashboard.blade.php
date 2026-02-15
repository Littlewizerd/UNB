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

                    <a href="{{ route('messages.index') }}" class="bg-gradient-to-br from-cyan-50 to-cyan-100 rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-cyan-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 9h12v2H6V9zm13 5H6v-2h13v2zm0-4H6V8h13v2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">ข้อความ</h3>
                                <p class="text-sm text-gray-600">จัดการข้อความ</p>
                            </div>
                        </div>
                    </a>
                @endif

                @if(Auth::user()->role === 'student')
                    <!-- Student Menu -->
                    <a href="{{ route('attendance.check-in') }}" class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">ลงเวลา</h3>
                                <p class="text-sm text-gray-600">ลงเวลาเข้า-ออก</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('attendance.history') }}" class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">ประวัติเวลา</h3>
                                <p class="text-sm text-gray-600">ดูประวัติการลงเวลา</p>
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
                                <p class="text-sm text-gray-600">ดูข้อความของฉัน</p>
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

                    <a href="{{ route('classes.index') }}" class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:scale-105">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M5 13h14v8H5z M19 3H5c-1.1 0-2 .9-2 2v4h16V5c0-1.1-.9-2-2-2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">ชั้นเรียน</h3>
                                <p class="text-sm text-gray-600">ดูชั้นเรียนของฉัน</p>
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
                                <p class="text-sm text-gray-600">ดูข้อความของฉัน</p>
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
