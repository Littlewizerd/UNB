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
    <body class="bg-slate-50 text-slate-800">
        @include('components/navbar')

        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <section class="overflow-hidden rounded-2xl bg-gradient-to-r from-blue-700 to-indigo-700 px-6 py-10 text-white shadow-xl sm:px-10">
                <div class="grid gap-8 md:grid-cols-2 md:items-center">
                    <div>
                        <h1 class="text-3xl font-bold leading-tight sm:text-4xl">ระบบตรวจสอบเวลาเรียน</h1>
                        <p class="mt-3 text-blue-100">ติดตามการเข้าเรียนของนักศึกษาได้ง่าย โปร่งใส และตรวจสอบย้อนหลังได้ทันที</p>
                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="@auth{{ route('subjects.index') }}@else{{ route('login') }}@endauth" class="rounded-lg bg-white px-5 py-2.5 font-semibold text-blue-700 transition hover:bg-blue-50">ดูวิชาเรียน</a>
                            <a href="@auth{{ route('dashboard') }}@else{{ route('login') }}@endauth" class="rounded-lg border border-blue-200 px-5 py-2.5 font-semibold text-white transition hover:bg-white/10">แดชบอร์ด</a>
                        </div>
                    </div>
                    <div class="rounded-xl bg-white/10 p-3 backdrop-blur">
                        <img src="{{ asset('images/PNG Host Copy.png') }}" alt="ระบบตรวจสอบเวลาเรียน" class="h-64 w-full rounded-lg object-contain bg-white/20 p-2 md:h-72">
                    </div>
                </div>
            </section>

            <section id="services" class="mt-12">
                <h2 class="text-2xl font-bold">บริการของระบบ</h2>
                <p class="mt-2 text-slate-600">ออกแบบให้ใช้งานได้ทั้งนักเรียน อาจารย์ และผู้ดูแลระบบ</p>
                <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-xl bg-white p-5 shadow">
                        <h3 class="font-semibold text-blue-700">ลงเวลาเข้า-ออก</h3>
                        <p class="mt-2 text-sm text-slate-600">บันทึกเวลาเรียนรายคาบอย่างรวดเร็ว</p>
                    </div>
                    <div class="rounded-xl bg-white p-5 shadow">
                        <h3 class="font-semibold text-blue-700">ตรวจสอบย้อนหลัง</h3>
                        <p class="mt-2 text-sm text-slate-600">ค้นหาประวัติการเข้าเรียนได้ง่าย</p>
                    </div>
                    <div class="rounded-xl bg-white p-5 shadow">
                        <h3 class="font-semibold text-blue-700">รายงานสรุป</h3>
                        <p class="mt-2 text-sm text-slate-600">ดูสถิติรายวันและรายบุคคลแบบทันที</p>
                    </div>
                    <div class="rounded-xl bg-white p-5 shadow">
                        <h3 class="font-semibold text-blue-700">จัดการตารางเรียน</h3>
                        <p class="mt-2 text-sm text-slate-600">เชื่อมโยงวิชา ห้องเรียน และผู้สอนได้ครบ</p>
                    </div>
                </div>
            </section>

            <section id="about-us" class="mt-12 rounded-2xl bg-white p-6 shadow sm:p-8">
                <div class="grid gap-8 lg:grid-cols-2">
                    <div>
                        <h2 class="text-2xl font-bold">เกี่ยวกับระบบ</h2>
                        <p class="mt-3 text-slate-600">ระบบนี้พัฒนาขึ้นเพื่อช่วยให้การติดตามการเข้าเรียนมีประสิทธิภาพมากขึ้น ลดงานเอกสาร และเพิ่มความถูกต้องของข้อมูล</p>
                        <div class="mt-5 overflow-hidden rounded-xl border border-slate-200">
                            <iframe width="100%" height="320" src="https://www.youtube.com/embed/vVGa8I0Atcg"
                                title="ระบบตรวจสอบเวลาเรียน" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold">ทีมพัฒนา</h3>
                        <div class="mt-4 space-y-4">
                            <div class="flex items-center gap-4 rounded-lg bg-slate-50 p-4">
                                <img src="{{ asset('images/student1.jpg') }}" alt="อุดมศักดิ์" class="h-14 w-14 rounded-full object-cover">
                                <div>
                                    <p class="font-semibold">นาย อุดมศักดิ์ เนตรสุนทร</p>
                                    <p class="text-sm text-slate-600">รหัส: 026740491024-7</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 rounded-lg bg-slate-50 p-4">
                                <img src="{{ asset('images/student2.jpg') }}" alt="นฤเบศ" class="h-14 w-14 rounded-full object-cover">
                                <div>
                                    <p class="font-semibold">นาย นฤเบศ พึ่งกลั่น</p>
                                    <p class="text-sm text-slate-600">รหัส: 026740491007-2</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 rounded-lg bg-slate-50 p-4">
                                <img src="{{ asset('images/student3.jpg') }}" alt="พิชชากร" class="h-14 w-14 rounded-full object-cover">
                                <div>
                                    <p class="font-semibold">นาย พิชชากร ประยูรวงศ์</p>
                                    <p class="text-sm text-slate-600">รหัส: 026740491005-6</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="contact" class="mt-12 rounded-2xl bg-white p-6 shadow sm:p-8">
                <h2 class="text-2xl font-bold">ติดต่อ</h2>
                <p class="mt-2 text-slate-600">หากพบปัญหาการใช้งาน สามารถติดต่อทีมพัฒนาได้ผ่านช่องทางภายในสถาบัน</p>
                <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="rounded-lg border border-slate-200 p-4">
                        <p class="text-sm text-slate-500">อีเมล</p>
                        <p class="font-semibold">support@attendance.local</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 p-4">
                        <p class="text-sm text-slate-500">เวลาให้บริการ</p>
                        <p class="font-semibold">จันทร์ - ศุกร์ 08:30 - 16:30</p>
                    </div>
                    <div class="rounded-lg border border-slate-200 p-4">
                        <p class="text-sm text-slate-500">ระบบ</p>
                        <p class="font-semibold">Attendance Management System</p>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>