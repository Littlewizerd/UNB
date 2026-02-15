<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ระบบตรวจสอบเวลาเรียนนักศึกษา</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100">
        <!-- เรียกใช้ Navbar ตรงนี้ -->
        @include('components/navbar')

        <!-- Main Content -->
        <div class="container mx-auto py-8 px-4 md:px-0">
            <!-- Hero Section with 2 Icons -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <div class="flex flex-wrap justify-center gap-8 md:gap-16">
                    <!-- Icon 1: Attendance -->
                    <a href="@auth{{ route('attendance.check-in') }}@else{{ route('login') }}@endauth" class="flex flex-col items-center text-center hover:transform hover:scale-110 transition duration-300 cursor-pointer group">
                        <div class="w-28 h-28 md:w-32 md:h-32 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl flex items-center justify-center mb-4 shadow-md group-hover:shadow-xl group-hover:from-blue-100 group-hover:to-blue-200 transition duration-300">
                            <svg class="w-14 h-14 md:w-16 md:h-16 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-700 text-base md:text-lg group-hover:text-blue-600 transition">ลงเวลา</h3>
                    </a>

                    <!-- Icon 2: History -->
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

            <!-- About Us Section -->
            <div id="about-us" class="mt-16">
                <h2 class="text-2xl font-bold text-center mb-8">ระบบตรวจสอบเวลาเรียน</h2>
                
                <!-- Content Section with Image and Video -->
                <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Left Side: Image -->
                        <div class="flex items-center justify-center">
                            <div class="border-4 border-cyan-400 rounded-lg p-4 bg-gray-50 w-full">
                                <img src="{{ asset('images/system-demo.jpg') }}" alt="ระบบตรวจสอบเวลาเรียน" class="w-full h-96 object-cover rounded-lg">
                            </div>
                        </div>
                        
                        <!-- Right Side: YouTube Video -->
                        <div class="flex items-center justify-center">
                            <div class="w-full">
                                <iframe width="100%" height="384" src="https://www.youtube.com/embed/vVGa8I0Atcg" 
                                        title="ระบบตรวจสอบเวลาเรียน" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen class="rounded-lg shadow-lg">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>


            <!-- Team Section -->
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-center mb-4">เกี่ยวกับเรา</h2>
                <p class="text-center text-gray-600">ทีมพัฒนาระบบตรวจสอบเวลาเรียนนักศึกษา</p>
                
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
                            <img src="{{ asset('images/student2.jpg') }}" alt="นฤเบศ" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-bold text-gray-800 text-lg mb-2">นาย นฤเบศ พึ่งกลั่น</h3>
                        <p class="text-blue-700 font-semibold mb-1">รหัส: 026740491007-2</p>
                        <p class="text-gray-600 text-sm">สาขาวิชา: เทคโนโลยีสารสนเทศ</p>
                    </div>

                    <!-- Student 3 -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 text-center shadow-md hover:shadow-lg transition">
                        <div class="w-24 h-24 mx-auto mb-4 rounded-full overflow-hidden border-4 border-purple-300 shadow-md">
                            <img src="{{ asset('images/student3.jpg') }}" alt="พิชชากร" class="w-full h-full object-cover">
                        </div>
                        <h3 class="font-bold text-gray-800 text-lg mb-2">นาย พิชชากร ประยูรวงศ์</h3>
                        <p class="text-purple-700 font-semibold mb-1">รหัส: 026740491005-6</p>
                        <p class="text-gray-600 text-sm">สาขาวิชา: เทคโนโลยีสารสนเทศ</p>
                    </div>
                </div>
            </div>
        </div>

        <script>
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