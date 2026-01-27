<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100">
        <!-- เรียกใช้ Navbar ตรงนี้ -->
        @include('components/navbar')

        <!-- Main Content -->
        <div class="container mx-auto py-8 px-4 md:px-0">
            <!-- Hero Section with 3 Icons -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <div class="flex flex-wrap justify-center gap-8 md:gap-16">
                    <!-- Icon 1: Home -->
                    <a href="{{ url('/') }}" class="flex flex-col items-center text-center hover:transform hover:scale-110 transition duration-300 cursor-pointer group">
                        <div class="w-28 h-28 md:w-32 md:h-32 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl flex items-center justify-center mb-4 shadow-md group-hover:shadow-xl group-hover:from-blue-100 group-hover:to-blue-200 transition duration-300">
                            <svg class="w-14 h-14 md:w-16 md:h-16 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-700 text-base md:text-lg group-hover:text-blue-600 transition">หน้าหลัก</h3>
                    </a>

                    <!-- Icon 2: Profile/Queue -->
                    <a href="@auth{{ url('/booking') }}@else{{ route('login') }}@endauth" class="flex flex-col items-center text-center hover:transform hover:scale-110 transition duration-300 cursor-pointer group">
                        <div class="w-28 h-28 md:w-32 md:h-32 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl flex items-center justify-center mb-4 shadow-md group-hover:shadow-xl group-hover:from-blue-100 group-hover:to-blue-200 transition duration-300">
                            <svg class="w-14 h-14 md:w-16 md:h-16 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-700 text-base md:text-lg group-hover:text-blue-600 transition">จองคิว</h3>
                    </a>

                    <!-- Icon 3: Mobile/Cancel -->
                    <a href="@auth{{ url('/booking') }}@else{{ route('login') }}@endauth" class="flex flex-col items-center text-center hover:transform hover:scale-110 transition duration-300 cursor-pointer group">
                        <div class="w-28 h-28 md:w-32 md:h-32 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl flex items-center justify-center mb-4 shadow-md group-hover:shadow-xl group-hover:from-blue-100 group-hover:to-blue-200 transition duration-300">
                            <svg class="w-14 h-14 md:w-16 md:h-16 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M15.5 1h-8C6.12 1 5 2.12 5 3.5v17C5 21.88 6.12 23 7.5 23h8c1.38 0 2.5-1.12 2.5-2.5v-17C18 2.12 16.88 1 15.5 1zm-4 21c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm4.5-4H7V4h9v14z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-700 text-base md:text-lg group-hover:text-blue-600 transition">ยกเลิก</h3>
                    </a>
                </div>
            </div>

            <!-- Collapsible Sections -->
            <div class="space-y-4">
                <!-- Section 1: ข้อกำหนด/เงื่อนไข -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <button onclick="toggleSection(this)" class="w-full bg-gray-500 hover:bg-gray-600 text-white p-4 flex justify-between items-center font-semibold transition">
                        <span class="flex items-center gap-2">
                            <span>ℹ️</span>
                            <span>ข้อกำหนด/เงื่อนไขในการจองคิวออนไลน์</span>
                        </span>
                        <span class="toggle-icon text-xl">−</span>
                    </button>
                    <div class="content hidden p-6 bg-gray-50 text-gray-800">
                        <ol class="list-decimal pl-6 space-y-3">
                            <li>สามารถจองคิวได้ล่วงหน้า 7 วัน นับจากวันปัจจุบัน</li>
                            <li>ผู้ใช้งานสามารถจองคิวได้ 1 คิว ต่อ 1 ครั้ง</li>
                            <li>กรุณามาถึงอย่างน้อย 10 นาที ก่อนเวลาที่จองไว้ จะถือเป็นการยกเลิกทันที</li>
                            <li>หากไม่สามารถมาได้ สามารถยกเลิกหรือเลื่อนคิวได้ก่อนเวลาที่จอง 3 ชั่วโมง</li>
                        </ol>
                    </div>
                </div>

                <!-- Section 2: วิธีการจองคิว -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <button onclick="toggleSection(this)" class="w-full bg-gray-500 hover:bg-gray-600 text-white p-4 flex justify-between items-center font-semibold transition">
                        <span class="flex items-center gap-2">
                            <span>📋</span>
                            <span>วิธีการจองคิว</span>
                        </span>
                        <span class="toggle-icon text-xl">−</span>
                    </button>
                    <div class="content hidden p-6 bg-gray-50 text-gray-800">
                        <ol class="list-decimal pl-6 space-y-3">
                            <li>เลือกประเภทบริการที่ต้องการรับบริการ</li>
                            <li>กดปุ่ม "จองคิว" เพื่อเลือกวันที่และเวลา</li>
                            <li>คิวที่ว่างจะแสดงเป็นสีม่วง คลิกเลือกคิวที่ต้องการ</li>
                            <li>กรอกข้อมูลส่วนตัว และกดปุ่ม "ยืนยันการจอง"</li>
                            <li>ระบบจะส่งการยืนยันทางอีเมลและ SMS</li>
                        </ol>
                    </div>
                </div>

                <!-- Section 3: บริการที่ให้บริการ -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <button onclick="toggleSection(this)" class="w-full bg-gray-500 hover:bg-gray-600 text-white p-4 flex justify-between items-center font-semibold transition">
                        <span class="flex items-center gap-2">
                            <span>🏥</span>
                            <span>บริการที่ให้บริการ</span>
                        </span>
                        <span class="toggle-icon text-xl">−</span>
                    </button>
                    <div class="content hidden p-6 bg-gray-50 text-gray-800">
                        <ul class="list-disc pl-6 space-y-2">
                            <li>ตรวจสุขภาพทั่วไป</li>
                            <li>ทำฟัน</li>
                            <li>ตรวจเสมหะและวัคซีน</li>
                            <li>ปรึกษาสุขภาพ</li>
                            <li>บริการตรวจเลือด</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- About Us Section -->
            <div id="about-us" class="mt-16">
                <h2 class="text-2xl font-bold text-center mb-4">เกี่ยวกับเรา</h2>
                <p class="text-center text-gray-600">ทีมพัฒนาระบบจองคิวออนไลน์</p>
                
                <!-- Student Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Student 1 -->
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 text-center shadow-md hover:shadow-lg transition">
                        <div class="w-24 h-24 mx-auto mb-4 rounded-full overflow-hidden border-4 border-green-300 shadow-md">
                            <img src="{{ asset('images/student1.jpg') }}" alt="อุดมศักดิ์" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-bold text-gray-800 text-lg mb-2">นาย อุดมศักดิ์ เนตรสุนทร</h3>
                        <p class="text-green-700 font-semibold mb-1">รหัส: 026740491024-7</p>
                        <p class="text-gray-600 text-sm">สาขาวิชา: เทคโนโลยีสารสนเทศ</p>
                    </div>

                    <!-- Student 2 -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 text-center shadow-md hover:shadow-lg transition">
                        <div class="w-24 h-24 mx-auto mb-4 rounded-full overflow-hidden border-4 border-blue-300 shadow-md">
                            <img src="{{ asset('images/student2.jpg') }}" alt="ภณิชรักษ์" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-bold text-gray-800 text-lg mb-2">นาย ภณิชรักษ์ จันเหม</h3>
                        <p class="text-blue-700 font-semibold mb-1">รหัส: 026740491008-0</p>
                        <p class="text-gray-600 text-sm">สาขาวิชา: เทคโนโลยีสารสนเทศ</p>
                    </div>

                    <!-- Student 3 -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 text-center shadow-md hover:shadow-lg transition">
                        <div class="w-24 h-24 mx-auto mb-4 rounded-full overflow-hidden border-4 border-purple-300 shadow-md">
                            <img src="{{ asset('images/student3.jpg') }}" alt="ชยากร" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-bold text-gray-800 text-lg mb-2">นาย ชยากร เหมทานนท์</h3>
                        <p class="text-purple-700 font-semibold mb-1">รหัส: 026740491009-8</p>
                        <p class="text-gray-600 text-sm">สาขาวิชา: เทคโนโลยีสารสนเทศ</p>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function toggleSection(button) {
                const content = button.nextElementSibling;
                const icon = button.querySelector('.toggle-icon');
                
                if (content.classList.contains('hidden')) {
                    content.classList.remove('hidden');
                    icon.textContent = '+';
                } else {
                    content.classList.add('hidden');
                    icon.textContent = '−';
                }
            }

            function toggleMobileMenu() {
                const menu = document.getElementById('mobileMenu');
                menu.classList.toggle('hidden');
            }

            document.addEventListener('DOMContentLoaded', function() {
                const links = document.querySelectorAll('a[href^="#"]');

                links.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const targetId = this.getAttribute('href').substring(1);
                        const targetElement = document.getElementById(targetId);

                        if (targetElement) {
                            window.scrollTo({
                                top: targetElement.offsetTop,
                                behavior: 'smooth'
                            });
                        }
                    });
                });
            });
        </script>
    </body>
</html>