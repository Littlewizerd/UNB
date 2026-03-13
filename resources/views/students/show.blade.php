@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">ข้อมูลนักเรียน</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">ข้อมูลส่วนตัว</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">รหัสนักเรียน:</th>
                            <td>{{ $student->student_id }}</td>
                        </tr>
                        <tr>
                            <th>ชื่อ-นามสกุล:</th>
                            <td>{{ $student->name }}</td>
                        </tr>
                        <tr>
                            <th>อีเมล:</th>
                            <td>{{ $student->email }}</td>
                        </tr>
                        <tr>
                            <th>โทรศัพท์:</th>
                            <td>{{ $student->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>ชั้นเรียน:</th>
                            <td>{{ $student->studentClass->class_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>สร้างเมื่อ:</th>
                            <td>{{ $student->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="mt-3">
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('students.edit', $student) }}" class="btn btn-warning">แก้ไข</a>
        @endif
        <a href="{{ route('students.index') }}" class="btn btn-secondary">กลับ</a>
        @if(auth()->user()->role === 'admin')
            <form action="{{ route('students.destroy', $student) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm({{ \Illuminate\Support\Js::from('ยืนยันการลบนักเรียน ' . $student->name . '?') }})">ลบ</button>
            </form>
        @endif
    </div>
</div>
@endsection
