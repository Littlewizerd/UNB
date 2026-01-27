<!-- Navbar with Report Dropdown -->
<nav class="bg-blue-700 text-white py-3 px-6 shadow-lg">
    <div class="container mx-auto flex items-center justify-between">
        <div class="flex items-center gap-3">
            <!-- Logo -->
            <div class="w-12 h-12 rounded-full bg-white p-1 flex items-center justify-center">
                <img src="{{ asset('images/PNG Host.png') }}" alt="Logo" class="w-10 h-10 object-cover rounded-full">
            </div>
            <div>
                <h1 class="font-bold text-lg">คลินิก จองคิวผู้เข้ารับบริการ</h1>
                <p class="text-sm text-blue-100">ระบบจองคิวออนไลน์ สำหรับผู้รับบริการ</p>
            </div>
        </div>
        <div class="hidden md:flex gap-6 text-sm items-center">
            <a href="{{ url('/') }}" class="hover:text-blue-200">หน้าแรก</a>
            <a href="#services" class="hover:text-blue-200">บริการ</a>
            <a href="#about-us" class="hover:text-blue-200">เกี่ยวกับ</a>
            <a href="#contact" class="hover:text-blue-200">ติดต่อ</a>
            
            <!-- Auth Buttons -->
            <div class="flex gap-3 ml-4 border-l border-blue-500 pl-4 items-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded font-semibold hover:bg-blue-700 transition">
                        ผู้ใช้งานระบบ
                    </a>
                    <!-- User Dropdown -->
                    <div class="relative">
                        <button class="flex items-center gap-2 hover:opacity-80 transition" onclick="toggleUserDropdown(event)">
                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </button>
                        <div id="userDropdown" class="absolute hidden bg-white text-gray-800 rounded shadow-lg mt-2 w-48 z-50 right-0">
                            <div class="px-4 py-3 border-b text-sm">
                                <p class="font-semibold">{{ Auth::user()->name }}</p>
                                <p class="text-gray-500 text-xs">{{ Auth::user()->email }}</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 text-red-600 font-semibold transition">
                                    ออกจากระบบ
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="bg-white text-blue-700 px-4 py-2 rounded font-semibold hover:bg-blue-100 transition">
                        เข้าสู่ระบบ
                    </a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded font-semibold hover:bg-blue-800 transition border border-white">
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
    <div id="mobileMenu" class="hidden md:hidden mt-4 pb-4 border-t border-blue-500">
        <a href="{{ url('/') }}" class="block py-2 hover:text-blue-200">หน้าแรก</a>
        <a href="#services" class="block py-2 hover:text-blue-200">บริการ</a>
        <a href="#about-us" class="block py-2 hover:text-blue-200">เกี่ยวกับ</a>
        <a href="#contact" class="block py-2 hover:text-blue-200">ติดต่อ</a>
        
        <div class="flex gap-2 mt-4 flex-col">
            @auth
                <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-3 py-2 rounded font-semibold text-center hover:bg-blue-700 transition">
                    ผู้ใช้งานระบบ
                </a>
                <div class="bg-gray-100 px-3 py-2 rounded text-center">
                    <p class="font-semibold text-sm text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-600">{{ Auth::user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 text-white px-3 py-2 rounded font-semibold text-center hover:bg-red-700 transition">
                        ออกจากระบบ
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="bg-white text-blue-700 px-3 py-2 rounded font-semibold text-center hover:bg-blue-100 transition">
                    เข้าสู่ระบบ
                </a>
                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-3 py-2 rounded font-semibold text-center hover:bg-blue-800 transition">
                    สมัครสมาชิก
                </a>
            @endauth
        </div>
    </div>
</nav>

<script>
    function toggleUserDropdown(event) {
        event.stopPropagation();
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('hidden');
    }

    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('hidden');
    }

    // ปิด dropdown เมื่อคลิกที่อื่น
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('userDropdown');
        const button = event.target.closest('button');
        if (dropdown && !dropdown.contains(event.target) && button?.onclick?.toString?.().includes('toggleUserDropdown') === false) {
            dropdown.classList.add('hidden');
        }
    });
</script>
