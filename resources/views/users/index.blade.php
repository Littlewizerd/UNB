@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>จัดการบัญชีผู้ใช้</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('users.create') }}" class="btn btn-primary">+ เพิ่มผู้ใช้ใหม่</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Search Bar -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('users.index') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="ค้นหาชื่อ, อีเมล, หรือบทบาท..." value="{{ old('search', $search ?? '') }}">
                <button type="submit" class="btn btn-outline-primary">ค้นหา</button>
                @if($search)
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">ล้าง</a>
                @endif
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-header bg-light">
            <h5 class="mb-0">รายชื่อผู้ใช้ทั้งหมด ({{ $users->total() }} คน)</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>ชื่อ</th>
                        <th>อีเมล</th>
                        <th>บทบาท</th>
                        <th>เข้าสู่ระบบล่าสุด</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @php
                                    $roleBadgeClass = match($user->role) {
                                        'admin' => 'info',
                                        'teacher' => 'warning',
                                        'student' => 'success',
                                        default => 'secondary'
                                    };
                                    $roleText = match($user->role) {
                                        'admin' => 'ผู้ดูแลระบบ',
                                        'teacher' => 'ครู',
                                        'student' => 'นักเรียน',
                                        default => $user->role
                                    };
                                @endphp
                                <span class="badge bg-{{ $roleBadgeClass }}">{{ $roleText }}</span>
                            </td>
                            <td>
                                @if($user->last_login_at)
                                    {{ $user->last_login_at->format('d/m/Y H:i') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('users.show', $user) }}" class="btn btn-info" title="ดู">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning" title="แก้ไข">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;" 
                                          onsubmit="return confirm('ยืนยันการลบผู้ใช้นี้?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="ลบ">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-2"></i>
                                    <p>ไม่พบผู้ใช้</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-light">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
