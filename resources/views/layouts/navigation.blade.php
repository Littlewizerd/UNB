<nav x-data="{ open: false }" class="bg-blue-700 text-white py-3 px-6 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @php
            $navLinkClass = request()->routeIs('dashboard') ? 'text-white hover:text-blue-200' : '';
        @endphp
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-white p-1 flex items-center justify-center">
                    <img src="{{ asset('images/PNG Host.png') }}" alt="Logo" class="w-10 h-10 object-cover rounded-full">
                </div>
                <div class="ms-3 hidden md:block">
                    <h1 class="font-bold text-lg text-white">คลินิก จองคิวผู้เข้ารับบริการ</h1>
                    <p class="text-sm text-blue-100">ระบบจองคิวออนไลน์ สำหรับผู้รับบริการ</p>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link class="text-white hover:text-blue-200" :href="url('/')" :active="request()->root() === url('/') && !request()->segment(1)">
                        หน้าแรก
                    </x-nav-link>
                    @if (auth()->user()->role === 'admin')

    <x-nav-link class="text-white hover:text-blue-200" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
       Dashboard
    </x-nav-link>

    <x-nav-link class="text-white hover:text-blue-200" :href="route('users.index')" :active="request()->routeIs('users.index')">
        จัดการข้อมูลผู้ใช้
    </x-nav-link>

    <x-nav-link class="text-white hover:text-blue-200" :href="route('doctor.schedule')" :active="request()->routeIs('doctor.schedule')">
        จัดตารางการทำงานของหมอ
    </x-nav-link>

    <!-- รายงาน (Hover Dropdown) -->
    <div class="relative group flex items-center h-full">
        <button class="inline-flex items-center px-1 pt-1 text-sm font-medium text-white hover:text-blue-200 focus:outline-none transition">
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
            <a href="{{ route('report.users.pdf') }}" target="_blank"
               class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 border-b">
                <span class="text-blue-500">📄</span>
                รายงานบัญชีผู้ใช้ (PDF)
            </a>
            <a href="{{ route('report.service.pdf') }}" target="_blank"
               class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-green-50 border-b">
                <span class="text-green-500">📋</span>
                รายงานผู้เข้ารับบริการ (PDF)
            </a>
            <a href="{{ route('report.booking-summary') }}" target="_blank"
               class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 border-b">
                <span class="text-blue-500">📄</span>
                รายงานสรุปการจองคิว (PDF)
            </a>
            <a href="{{ route('report.booking-history') }}" target="_blank"
               class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-green-50">
                <span class="text-green-500">📋</span>
                รายงานประวัติการจองคิว (PDF)
            </a>
        </div>
    </div>

@endif

                    @if (strtolower(Auth::user()->role ?? '') === 'patient')
                        <x-nav-link class="{{ $navLinkClass }}" :href="route('queue.book')" :active="request()->routeIs('queue.book')">
                            จองคิว
                        </x-nav-link>
                        <x-nav-link :href="route('queue.my')" :active="request()->routeIs('queue.my')">
                            สถานะคิวของฉัน
                        </x-nav-link>
                        <x-nav-link :href="route('queue.current')" :active="request()->routeIs('queue.current')">
                            ลำดับคิวปัจจุบัน
                        </x-nav-link>
                        <x-nav-link :href="route('queue.history')" :active="request()->routeIs('queue.history')">
                            ประวัติการจอง
                        </x-nav-link>
                    @endif
                    @if (strtolower(Auth::user()->role ?? '') === 'staff')
                        <x-nav-link :href="route('staff.dashboard')" :active="request()->routeIs('staff.dashboard')">
                            Dashboard สรุปคิว
                        </x-nav-link>
                        <x-nav-link :href="route('queue.manage')" :active="request()->routeIs('queue.manage')">
                            จัดการคิว
                        </x-nav-link>
                        <x-nav-link :href="route('queue.call')" :active="request()->routeIs('queue.call')">
                            เรียกและอัพเดทคิว
                        </x-nav-link>
                        <x-nav-link :href="route('report.daily')" :active="request()->routeIs('report.daily')">
                            รายงานประจำวัน (PDF)
                        </x-nav-link>
                    @endif
                    @if (strtolower(Auth::user()->role ?? '') === 'doctor')
                        <x-nav-link :href="route('doctor.queue.list')" :active="request()->routeIs('doctor.queue.list')">
                            รายการคิวผู้ป่วยและค้นหา
                        </x-nav-link>
                        <x-nav-link :href="route('doctor.patient.record')" :active="request()->routeIs('doctor.patient.record')">
                            บันทึกข้อมูลผู้ป่วยเบื้องต้น
                        </x-nav-link>
                        <x-nav-link :href="route('doctor.patient.history')" :active="request()->routeIs('doctor.patient.history')">
                            ประวัติผู้รับบริการ
                        </x-nav-link>
                        <x-nav-link :href="route('doctor.report.pdf')" :active="request()->routeIs('doctor.report.pdf')">
                            รายงานผู้เข้ารับบริการ (PDF)
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
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
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                จัดการข้อมูลผู้ใช้
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