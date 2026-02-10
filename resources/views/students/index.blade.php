@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">จัดการนักเรียน</h1>

    <a href="{{ route('students.create') }}" class="btn btn-primary mb-3">+ เพิ่มนักเรียนใหม่</a>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">รายชื่อนักเรียน</h5>
        </div>
        <div class="card-body">
            @if($students->count() > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>รหัสนักเรียน</th>
                            <th>ชื่อ</th>
                            <th>ชั้นเรียน</th>
                            <th>อีเมล</th>
                            <th>โทรศัพท์</th>
                            <th>ดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $student->student_id }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->studentClass->class_name ?? '-' }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->phone ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('students.show', $student) }}" class="btn btn-info btn-sm">ดู</a>
                                    <a href="{{ route('students.edit', $student) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                                    <form action="{{ route('students.destroy', $student) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบ?')">ลบ</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $students->links() }}
                </div>
            @else
                <div class="alert alert-info">ยังไม่มีนักเรียน</div>
            @endif
        </div>
    </div>
</div>
@endsection
