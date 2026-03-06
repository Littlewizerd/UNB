<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">จัดการบัญชีผู้ใช้</h1>
                        <p class="text-gray-600">รวมทั้งสิ้น <span class="font-bold text-blue-600">{{ $users->total() }}</span> บัญชี</p>
                    </div>
                    <a href="{{ route('users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        + เพิ่มผู้ใช้ใหม่
                    </a>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Search Bar -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <form action="{{ route('users.index') }}" method="GET" class="flex gap-3">
                    <input type="text" name="search" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           placeholder="ค้นหาชื่อ, อีเมล, หรือบทบาท..." 
                           value="{{ old('search', $search ?? '') }}">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                        ค้นหา
                    </button>
                    @if($search)
                        <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-semibold transition">
                            ล้าง
                        </a>
                    @endif
                </form>
            </div>

            <!-- Users Table -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">ID</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">ชื่อ</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">อีเมล</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">บทบาท</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">เข้าสู่ระบบล่าสุด</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $user->id }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ $user->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $user->email }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        @php
                                            $roleBadgeClass = match($user->role) {
                                                'admin' => 'bg-blue-100 text-blue-800',
                                                'teacher' => 'bg-yellow-100 text-yellow-800',
                                                'student' => 'bg-green-100 text-green-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            };
                                            $roleText = match($user->role) {
                                                'admin' => 'ผู้ดูแลระบบ',
                                                'teacher' => 'อาจารย์',
                                                'student' => 'นักเรียน',
                                                default => $user->role
                                            };
                                        @endphp
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $roleBadgeClass }}">{{ $roleText }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        @if($user->last_login_at)
                                            {{ $user->last_login_at->format('d/m/Y H:i') }}
                                        @else
                                            <span class="text-gray-400">ไม่มี</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex gap-2">
                                            <a href="{{ route('users.show', $user) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded transition" title="ดู">
                                                👁️
                                            </a>
                                            <a href="{{ route('users.edit', $user) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded transition" title="แก้ไข">
                                                ✏️
                                            </a>
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;" 
                                                  onsubmit="return confirm('ยืนยันการลบ {{ addslashes($user->name) }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded transition" title="ลบ">
                                                    🗑️
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center">
                                        <div class="text-gray-500">
                                            <p class="text-lg">ไม่พบผู้ใช้</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-gray-50 px-6 py-4 border-t">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
