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

                    <!-- Icon 2: Attendance -->
                    <a href="@auth{{ route('attendance.check-in') }}@else{{ route('login') }}@endauth" class="flex flex-col items-center text-center hover:transform hover:scale-110 transition duration-300 cursor-pointer group">
                        <div class="w-28 h-28 md:w-32 md:h-32 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl flex items-center justify-center mb-4 shadow-md group-hover:shadow-xl group-hover:from-blue-100 group-hover:to-blue-200 transition duration-300">
                            <svg class="w-14 h-14 md:w-16 md:h-16 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-700 text-base md:text-lg group-hover:text-blue-600 transition">ลงเวลา</h3>
                    </a>

                    <!-- Icon 3: History -->
                    <a href="@auth{{ route('attendance.history') }}@else{{ route('login') }}@endauth" class="flex flex-col items-center text-center hover:transform hover:scale-110 transition duration-300 cursor-pointer group">
                        <div class="w-28 h-28 md:w-32 md:h-32 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl flex items-center justify-center mb-4 shadow-md group-hover:shadow-xl group-hover:from-blue-100 group-hover:to-blue-200 transition duration-300">
                            <svg class="w-14 h-14 md:w-16 md:h-16 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-700 text-base md:text-lg group-hover:text-blue-600 transition">ประวัติ</h3>
                    </a>
                </div>
            </div>

            <!-- Project Scope Section -->
            <div class="space-y-4">
                <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">1.3 ขอบเขตของโครงงาน</h2>
                <p class="text-center text-gray-600 mb-8 text-lg">ระบบบันทึกเวลาเรียนของนักศึกษา โดยกำหนดบทบาทผู้ใช้งาน 3 กลุ่ม ดังนี้ ผู้ดูแลระบบ (Administrator) อาจารย์ (Instructor) และนักศึกษา (Student)</p>

                <!-- Section 1: อาจารย์ -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden border-l-4 border-blue-500">
                    <button onclick="toggleSection(this)" class="w-full bg-blue-600 hover:bg-blue-700 text-white p-4 flex justify-between items-center font-semibold transition">
                        <span class="flex items-center gap-2">
                            <span>👨‍🏫</span>
                            <span>1.3.1 อาจารย์ (Instructor)</span>
                        </span>
                        <span class="toggle-icon text-xl">−</span>
                    </button>
                    <div class="content hidden p-6 bg-gray-50 text-gray-800">
                        <ol class="list-decimal pl-6 space-y-2">
                            <li>การเข้าสู่ระบบ/การออกจากระบบ</li>
                            <li>การอัปเดตโปรไฟล์</li>
                            <li>การเปลี่ยนรหัสผ่าน</li>
                            <li>บันทึกเวลาเรียนเข้านักศึกษา</li>
                            <li>เรียกดูรายวิชาที่สอน</li>
                            <li>การจัดการข้อมูลนักศึกษาในรายวิชา (บันทึก แก้ไข ลบ ค้นหา)</li>
                            <li>ค้นหาข้อมูลนักศึกษาและรายวิชาที่สอน</li>
                            <li>รายงานสรุปผลการเข้าเรียน (ส่งออก PDF)</li>
                            <li>ดูตารางสอน</li>
                            <li>ส่งข้อความตอบกลับถึงนักศึกษา</li>
                        </ol>
                    </div>
                </div>

                <!-- Section 2: นักศึกษา -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden border-l-4 border-green-500">
                    <button onclick="toggleSection(this)" class="w-full bg-green-600 hover:bg-green-700 text-white p-4 flex justify-between items-center font-semibold transition">
                        <span class="flex items-center gap-2">
                            <span>👨‍🎓</span>
                            <span>1.3.2 นักศึกษา (Student)</span>
                        </span>
                        <span class="toggle-icon text-xl">−</span>
                    </button>
                    <div class="content hidden p-6 bg-gray-50 text-gray-800">
                        <ol class="list-decimal pl-6 space-y-2">
                            <li>การเข้าสู่ระบบ/การออกจากระบบ</li>
                            <li>การอัปเดตโปรไฟล์</li>
                            <li>การเปลี่ยนรหัสผ่าน</li>
                            <li>แดชบอร์ดสรุปผลการเข้าห้องเรียน</li>
                            <li>รายงานสรุปผลการเข้าเรียน (ส่งออก PDF)</li>
                            <li>ดูตารางเรียน</li>
                            <li>ส่งข้อความถึงอาจารย์ผู้สอน</li>
                        </ol>
                    </div>
                </div>

                <!-- Section 3: ผู้ดูแลระบบ -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden border-l-4 border-red-500">
                    <button onclick="toggleSection(this)" class="w-full bg-red-600 hover:bg-red-700 text-white p-4 flex justify-between items-center font-semibold transition">
                        <span class="flex items-center gap-2">
                            <span>⚙️</span>
                            <span>1.3.3 ผู้ดูแลระบบ (Administrator)</span>
                        </span>
                        <span class="toggle-icon text-xl">−</span>
                    </button>
                    <div class="content hidden p-6 bg-gray-50 text-gray-800">
                        <ol class="list-decimal pl-6 space-y-2">
                            <li>การเข้าสู่ระบบ/การออกจากระบบ</li>
                            <li>การอัปเดตโปรไฟล์</li>
                            <li>การเปลี่ยนรหัสผ่าน</li>
                            <li>แดชบอร์ดสรุปข้อมูล (เวลาเรียน การเข้าเรียน การขาดเรียน)</li>
                            <li>การจัดการบัญชีผู้ใช้ (บันทึก แก้ไข ลบ ค้นหา)</li>
                            <li>การจัดการข้อมูลภาคเรียน (บันทึก แก้ไข ลบ ค้นหา)</li>
                            <li>การจัดการข้อมูลห้องเรียน (บันทึก แก้ไข ลบ ค้นหา)</li>
                            <li>การจัดการข้อมูลรายวิชา (บันทึก แก้ไข ลบ ค้นหา)</li>
                            <li>การจัดการข้อมูลนักศึกษา (บันทึก แก้ไข ลบ ค้นหา)</li>
                            <li>รายงานบัญชีผู้ใช้ (ส่งออก PDF)</li>
                            <li>รายงานข้อมูลรายวิชา (ส่งออก PDF)</li>
                            <li>รายงานข้อมูลห้องเรียน (ส่งออก PDF)</li>
                            <li>รายงานสรุปผลการเข้าเรียน (ส่งออก PDF)</li>
                            <li>จัดการตารางสอน (เพิ่ม/แก้ไข/ดูตาราง)</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- About Us Section -->
            <div id="about-us" class="mt-16">
                <h2 class="text-2xl font-bold text-center mb-4">เกี่ยวกับเรา</h2>
                <p class="text-center text-gray-600 mb-8">ทีมพัฒนาระบบบันทึกเวลาเรียนของนักศึกษา</p>
                
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
                        <h3 class="font-bold text-gray-800 text-lg mb-2">นาย นฤเบศ พึ่งกลั่น</h3>
                        <p class="text-blue-700 font-semibold mb-1">รหัส: 026740491007-2</p>
                        <p class="text-gray-600 text-sm">สาขาวิชา: เทคโนโลยีสารสนเทศ</p>
                    </div>

                    <!-- Student 3 -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 text-center shadow-md hover:shadow-lg transition">
                        <div class="w-24 h-24 mx-auto mb-4 rounded-full overflow-hidden border-4 border-purple-300 shadow-md">
                            <img src="{{ asset('images/student3.jpg') }}" alt="ชยากร" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-bold text-gray-800 text-lg mb-2">นาย พิชชากร ประยูรวงศ์</h3>
                        <p class="text-purple-700 font-semibold mb-1">รหัส: 026740491005-6</p>
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