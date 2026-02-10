@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">ข้อมูลผู้ใช้</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td class="fw-bold">ID:</td>
                            <td>{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">ชื่อ:</td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">อีเมล:</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">บทบาท:</td>
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
                        </tr>
                        <tr>
                            <td class="fw-bold">สถานะอีเมล:</td>
                            <td>
                                @if($user->email_verified_at)
                                    <span class="badge bg-success">ยืนยันแล้ว</span>
                                @else
                                    <span class="badge bg-warning">ยังไม่ยืนยัน</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">สร้างเมื่อ:</td>
                            <td>{{ $user->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">แก้ไขล่าสุด:</td>
                            <td>{{ $user->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </table>

                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">แก้ไข</a>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">กลับ</a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;" 
                              onsubmit="return confirm('ยืนยันการลบผู้ใช้นี้?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">ลบ</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
