<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <h1 class="text-3xl font-bold text-gray-800">{{ $user->name }}</h1>
            </div>

            <!-- Info Card -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="border-b md:border-b-0 pb-4 md:pb-0">
                        <p class="text-gray-600 text-sm">ID</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $user->id }}</p>
                    </div>
                    <div class="border-b md:border-b-0 pb-4 md:pb-0">
                        <p class="text-gray-600 text-sm">ชื่อ</p>
                        <p class="text-xl font-semibold text-gray-800">{{ $user->name }}</p>
                    </div>
                    <div class="border-b md:border-b-0 pb-4 md:pb-0">
                        <p class="text-gray-600 text-sm">อีเมล</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $user->email }}</p>
                    </div>
                    <div class="border-b md:border-b-0 pb-4 md:pb-0">
                        <p class="text-gray-600 text-sm">บทบาท</p>
                        @php
                            $roleText = match($user->role) {
                                'admin' => 'ผู้ดูแลระบบ',
                                'teacher' => 'ครู',
                                'student' => 'นักเรียน',
                                default => $user->role
                            };
                            $roleBadgeClass = match($user->role) {
                                'admin' => 'bg-blue-100 text-blue-800',
                                'teacher' => 'bg-yellow-100 text-yellow-800',
                                'student' => 'bg-green-100 text-green-800',
                                default => 'bg-gray-100 text-gray-800'
                            };
                        @endphp
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $roleBadgeClass }}">{{ $roleText }}</span>
                    </div>
                    <div class="border-b md:border-b-0 pb-4 md:pb-0">
                        <p class="text-gray-600 text-sm">สถานะอีเมล</p>
                        @if($user->email_verified_at)
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">ยืนยันแล้ว</span>
                        @else
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">ยังไม่ยืนยัน</span>
                        @endif
                    </div>
                    <div class="border-b md:border-b-0 pb-4 md:pb-0">
                        <p class="text-gray-600 text-sm">สร้างเมื่อ</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="border-b pb-4 md:border-b-0 md:pb-0">
                        <p class="text-gray-600 text-sm">แก้ไขล่าสุด</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 pt-6 border-t">
                    <a href="{{ route('users.edit', $user) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg font-semibold transition">
                        แก้ไข
                    </a>
                    <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-semibold transition">
                        กลับ
                    </a>
                    <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;" 
                          onsubmit="return confirm('ยืนยันการลบผู้ใช้ {{ addslashes($user->name) }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                            ลบ
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
