<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hero container like Welcome page -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-800">Dashboard</h1>
                        <p class="text-gray-600">ยินดีต้อนรับ, {{ Auth::user()->name }}!</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <!-- optional quick actions / placeholder to balance layout -->
                    </div>
                </div>
            </div>

            <div>
                <!-- Main Dashboard Content -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <p class="text-gray-600">คุณเข้าสู่ระบบเรียบร้อยแล้ว</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
