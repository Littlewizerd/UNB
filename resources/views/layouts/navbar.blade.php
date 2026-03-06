<!-- Navbar with Report Dropdown -->
<nav class="bg-green-700 text-white py-3 px-6 shadow-lg">
    <div class="container mx-auto flex items-center justify-between">
        <div class="flex items-center gap-3">
            <!-- Logo -->
            <div class="w-12 h-12 rounded-full bg-white p-1 flex items-center justify-center">
                <img src="{{ asset('images/PNG Host.png') }}" alt="Logo" class="w-10 h-10 object-cover rounded-full">
            </div>
            <div>
                <h1 class="font-bold text-lg">คลินิก จองคิวผู้เข้ารับบริการ</h1>
                <p class="text-sm text-green-100">ระบบจองคิวออนไลน์ สำหรับผู้รับบริการ</p>
            </div>
        </div>
        <div class="hidden md:flex gap-6 text-sm items-center">
            <a href="{{ url('/') }}" class="hover:text-green-200">หน้าแรก</a>
            <a href="#services" class="hover:text-green-200">บริการ</a>
            <a href="#about" class="hover:text-green-200">เกี่ยวกับ</a>
            <a href="#contact" class="hover:text-green-200">ติดต่อ</a>
            
            <!-- Report Dropdown -->
            @auth
            <div class="relative group">
                <button class="hover:text-green-200 flex items-center gap-1">
                    รายงาน ▼
                </button>
                <div class="absolute hidden group-hover:block bg-white text-gray-800 rounded shadow-lg mt-2 w-56 z-50 right-0">
                    <a href="{{ route('reports.dailySummary') }}" target="_blank" class="block px-4 py-2 hover:bg-gray-100 border-b">
                        📄 รายงานสรุปประจำวัน
                    </a>
                </div>
            </div>
            @endauth
            
            <!-- Auth Buttons -->
            <div class="flex gap-3 ml-4 border-l border-green-500 pl-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded font-semibold hover:bg-blue-700 transition">
                        ผู้ใช้งานระบบ
                    </a>
                    <span class="text-sm">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded font-semibold hover:bg-red-700 transition">
                            ออกจากระบบ
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-white text-green-700 px-4 py-2 rounded font-semibold hover:bg-green-100 transition">
                        เข้าสู่ระบบ
                    </a>
                    <a href="{{ route('register') }}" class="bg-green-600 text-white px-4 py-2 rounded font-semibold hover:bg-green-800 transition border border-white">
                        สมัครสมาชิก
                    </a>
                @endauth
            </div>
        </div>

        <!-- Mobile Menu Button -->
        <button class="md:hidden text-white text-2xl" onclick="toggleMobileMenu()">
            ☰
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden mt-4 pb-4 border-t border-green-500">
        <a href="{{ url('/') }}" class="block py-2 hover:text-green-200">หน้าแรก</a>
        <a href="#services" class="block py-2 hover:text-green-200">บริการ</a>
        <a href="#about" class="block py-2 hover:text-green-200">เกี่ยวกับ</a>
        <a href="#contact" class="block py-2 hover:text-green-200">ติดต่อ</a>
        
        @auth
        <div class="mt-2 border-t border-green-500 pt-2">
            <a href="{{ route('reports.dailySummary') }}" target="_blank" class="block py-2 hover:text-green-200">
                📄 รายงานสรุปประจำวัน
            </a>
        </div>
        @endauth
        
        <div class="flex gap-2 mt-4 flex-col">
            @auth
                <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-3 py-2 rounded font-semibold text-center hover:bg-blue-700 transition">
                    แผงควบคุม
                </a>
                <span class="block py-2 text-sm">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 text-white px-3 py-2 rounded font-semibold text-center hover:bg-red-700 transition">
                        ออกจากระบบ
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="bg-white text-green-700 px-3 py-2 rounded font-semibold text-center hover:bg-green-100 transition">
                    เข้าสู่ระบบ
                </a>
                <a href="{{ route('register') }}" class="bg-green-600 text-white px-3 py-2 rounded font-semibold text-center hover:bg-green-800 transition">
                    สมัครสมาชิก
                </a>
            @endauth
        </div>
    </div>
</nav>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('hidden');
    }
</script>
