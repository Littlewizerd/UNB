<nav x-data="{ open: false }" class="bg-blue-700 text-white px-4 py-2 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @php
            $navLinkClass = request()->routeIs('dashboard') ? 'text-white hover:text-blue-200' : '';
        @endphp
        <div class="flex min-h-[64px] items-center justify-between gap-3">
            <div class="flex min-w-0 flex-1 items-center">
                <div class="h-11 w-11 shrink-0 rounded-full bg-white p-1 flex items-center justify-center">
                    <img src="{{ asset('images/PNG Host.png') }}" alt="Logo" class="w-10 h-10 object-cover rounded-full">
                </div>
                <div class="ms-3 hidden lg:block shrink-0">
                    <h1 class="font-semibold text-base text-white whitespace-nowrap">ระบบตรวจสอบเวลาเรียน</h1>
                    <p class="text-xs text-blue-100 whitespace-nowrap">Attendance Management System</p>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:ms-6 sm:flex sm:flex-1">
                    <div class="flex items-center gap-2 whitespace-nowrap py-1">
                    <x-nav-link class="text-white hover:text-blue-200" :href="url('/')" :active="request()->root() === url('/') && !request()->segment(1)">
                        หน้าแรก
                    </x-nav-link>
                    @if (auth()->user()->role === 'admin')
                        <x-nav-link class="text-white hover:text-blue-200" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            แผงควบคุม
                        </x-nav-link>

                        <div class="relative group flex items-center h-full">
                            <button class="inline-flex items-center rounded-md px-3 py-2 text-sm font-medium text-white hover:text-blue-200 focus:outline-none transition">
                                จัดการข้อมูล
                                <svg class="ml-1 h-4 w-4 fill-current" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div class="absolute left-0 top-full z-50 mt-0 w-64 rounded-md border border-gray-200 bg-white shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                <a href="{{ route('users.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 border-b">จัดการผู้ใช้</a>
                                <a href="{{ route('students.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 border-b">จัดการนักเรียน</a>
                                <a href="{{ route('classes.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 border-b">จัดการชั้นเรียน</a>
                                <a href="{{ route('subjects.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 border-b">จัดการวิชา</a>
                                <a href="{{ route('semesters.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 border-b">จัดการภาคเรียน</a>
                                <a href="{{ route('schedules.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 border-b">ตารางเรียน</a>
                                <a href="{{ route('makeup-schedules.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">ตารางชดเชย</a>
                            </div>
                        </div>

                        <!-- รายงาน (Hover Dropdown) -->
                        <div class="relative group flex items-center h-full">
                            <button class="inline-flex items-center rounded-md px-3 py-2 text-sm font-medium text-white hover:text-blue-200 focus:outline-none transition">
                                รายงาน
                                <svg class="ml-1 h-4 w-4 fill-current" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div class="absolute left-0 top-full mt-0 w-64 bg-white border border-gray-200 rounded-md shadow-lg
                                        opacity-0 invisible group-hover:opacity-100 group-hover:visible
                                        transition-all duration-200 z-50">
                                <a href="{{ route('reports.userReportPdf') }}"
                                   class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 border-b">
                                    <span class="text-indigo-500">👤</span>
                                    รายงานบัญชีผู้ใช้ PDF
                                </a>
                                <a href="{{ route('reports.subjectReportPdf') }}"
                                   class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 border-b">
                                    <span class="text-purple-500">📚</span>
                                    รายงานรายวิชา PDF
                                </a>
                                <a href="{{ route('reports.classroomReportPdf') }}"
                                   class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 border-b">
                                    <span class="text-teal-500">🏫</span>
                                    รายงานห้องเรียน PDF
                                </a>
                                <a href="{{ route('reports.scheduleReportPdf') }}"
                                   class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-green-50">
                                    <span class="text-green-500">📋</span>
                                    รายงานตารางเรียน/สอน PDF
                                </a>
                            </div>
                        </div>
                    @endif

                    @if (strtolower(Auth::user()->role ?? '') === 'student')
                        <x-nav-link :href="route('subjects.index')" :active="request()->routeIs('subjects.*')">
                            วิชาเรียน
                        </x-nav-link>
                        <x-nav-link :href="route('schedules.student-schedule')" :active="request()->routeIs('schedules.student-schedule')">
                            ตารางเรียนของฉัน
                        </x-nav-link>
                        <x-nav-link :href="route('makeup-schedules.student-schedule')" :active="request()->routeIs('makeup-schedules.student-schedule')">
                            ตารางชดเชย
                        </x-nav-link>
                        <x-nav-link :href="route('reports.individualReport', Auth::id())" :active="request()->routeIs('reports.individualReport')">
                            รายงานผลเข้าเรียน
                        </x-nav-link>
                    @endif
                    
                    @if (strtolower(Auth::user()->role ?? '') === 'teacher')
                        <x-nav-link :href="route('subjects.index')" :active="request()->routeIs('subjects.*')">
                            รายวิชา
                        </x-nav-link>
                        <x-nav-link :href="route('teacher.record')" :active="request()->routeIs('teacher.record')">
                            บันทึกเวลา
                        </x-nav-link>
                        <x-nav-link :href="route('students.index')" :active="request()->routeIs('students.*')">
                            นักศึกษา
                        </x-nav-link>
                        <x-nav-link :href="route('schedules.teacher-schedule')" :active="request()->routeIs('schedules.teacher-schedule')">
                            ตารางสอนของฉัน
                        </x-nav-link>
                        <x-nav-link :href="route('makeup-schedules.teacher-schedule')" :active="request()->routeIs('makeup-schedules.*')">
                            ตารางชดเชย
                        </x-nav-link>
                        <x-nav-link :href="route('reports.dailySummary')" :active="request()->routeIs('reports.dailySummary')">
                            รายงาน
                        </x-nav-link>
                    @endif

                    <!-- Messages for all authenticated users -->
                    <x-nav-link class="text-white hover:text-blue-200" :href="route('messages.index')" :active="request()->routeIs('messages.index')">
                        ข้อความ
                        <span id="msg-badge-desktop" class="ml-1 inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-xs font-bold text-white bg-red-500 rounded-full leading-none {{ ($unreadMessageCount ?? 0) > 0 ? '' : 'hidden' }}">
                            {{ ($unreadMessageCount ?? 0) > 99 ? '99+' : ($unreadMessageCount ?? 0) }}
                        </span>
                    </x-nav-link>
                    </div>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden shrink-0 sm:ms-4 sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div class="flex items-center">
                                {{ Auth::user()->name }}
                                @if (strtolower(Auth::user()->role ?? '') === 'admin')
                                    <span class="ml-2 px-2 py-1 text-xs font-bold text-white bg-red-600 rounded-full">
                                        ADMIN
                                    </span>
                                @endif
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="url('/')" :active="request()->root() === url('/') && !request()->segment(1)">
                หน้าแรก
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('แผงควบคุม') }}
            </x-responsive-nav-link>
            @if (auth()->user()->role === 'admin')
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                    จัดการข้อมูลผู้ใช้
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('semesters.index')" :active="request()->routeIs('semesters.index')">
                    จัดการภาคเรียน
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('schedules.index')" :active="request()->routeIs('schedules.index')">
                    ตารางเรียน
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('makeup-schedules.index')" :active="request()->routeIs('makeup-schedules.*')">
                    ตารางชดเชย
                </x-responsive-nav-link>
            @endif
            @if (strtolower(auth()->user()->role ?? '') === 'student')
                <x-responsive-nav-link :href="route('subjects.index')" :active="request()->routeIs('subjects.*')">
                    วิชาเรียน
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('schedules.student-schedule')" :active="request()->routeIs('schedules.student-schedule')">
                    ตารางเรียนของฉัน
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('makeup-schedules.student-schedule')" :active="request()->routeIs('makeup-schedules.student-schedule')">
                    ตารางชดเชย
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('reports.individualReport', Auth::id())" :active="request()->routeIs('reports.individualReport')">
                    รายงานผลเข้าเรียน
                </x-responsive-nav-link>
            @endif
            @if (strtolower(auth()->user()->role ?? '') === 'teacher')
                <x-responsive-nav-link :href="route('subjects.index')" :active="request()->routeIs('subjects.*')">
                    รายวิชา
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('teacher.record')" :active="request()->routeIs('teacher.record')">
                    บันทึกเวลา
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('students.index')" :active="request()->routeIs('students.*')">
                    นักศึกษา
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('schedules.teacher-schedule')" :active="request()->routeIs('schedules.teacher-schedule')">
                    ตารางสอนของฉัน
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('makeup-schedules.teacher-schedule')" :active="request()->routeIs('makeup-schedules.*')">
                    ตารางชดเชย
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('reports.dailySummary')" :active="request()->routeIs('reports.dailySummary')">
                    รายงาน
                </x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.index')">
                ข้อความ
                <span id="msg-badge-mobile" class="ml-2 inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 text-xs font-bold text-white bg-red-500 rounded-full leading-none {{ ($unreadMessageCount ?? 0) > 0 ? '' : 'hidden' }}">
                    {{ ($unreadMessageCount ?? 0) > 99 ? '99+' : ($unreadMessageCount ?? 0) }}
                </span>
            </x-responsive-nav-link>
        </div>
        
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="flex items-center font-medium text-base text-gray-800">
                    {{ Auth::user()->name }}
                    @if (strtolower(Auth::user()->role ?? '') === 'admin')
                        <span class="ml-2 px-2 py-1 text-xs font-bold text-white bg-red-600 rounded-full">
                            ADMIN
                        </span>
                    @endif
                </div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

@auth
<script>
(function () {
    const POLL_INTERVAL = 30000;
    const countUrl = '{{ route("notifications.count") }}';

    function updateBadges(count) {
        const text = count > 99 ? '99+' : String(count);
        ['msg-badge-desktop', 'msg-badge-mobile'].forEach(function (id) {
            const badge = document.getElementById(id);
            if (!badge) return;
            if (count > 0) {
                badge.textContent = text;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        });
    }

    async function pollNotifications() {
        try {
            const res = await fetch(countUrl, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            });
            if (!res.ok) return;
            const data = await res.json();
            updateBadges(data.unread_messages ?? 0);
        } catch (e) {
            // silent fail on network error
        }
    }

    setInterval(pollNotifications, POLL_INTERVAL);
})();
</script>
@endauth