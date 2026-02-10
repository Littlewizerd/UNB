@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">จัดการครู</h1>

    <a href="{{ route('teachers.create') }}" class="btn btn-primary mb-3">+ เพิ่มครูใหม่</a>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">รายชื่อครู</h5>
        </div>
        <div class="card-body">
            @if($teachers->count() > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>รหัสครู</th>
                            <th>ชื่อ</th>
                            <th>สาขา/แผนก</th>
                            <th>อีเมล</th>
                            <th>โทรศัพท์</th>
                            <th>ดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teachers as $teacher)
                            <tr>
                                <td>{{ $teacher->teacher_id }}</td>
                                <td>{{ $teacher->name }}</td>
                                <td>{{ $teacher->department ?? '-' }}</td>
                                <td>{{ $teacher->email }}</td>
                                <td>{{ $teacher->phone ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('teachers.show', $teacher) }}" class="btn btn-info btn-sm">ดู</a>
                                    <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                                    <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบ?')">ลบ</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $teachers->links() }}
                </div>
            @else
                <div class="alert alert-info">ยังไม่มีครู</div>
            @endif
        </div>
    </div>
</div>
@endsection
