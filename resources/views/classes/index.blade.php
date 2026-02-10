@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">จัดการชั้นเรียน</h1>

    <a href="{{ route('classes.create') }}" class="btn btn-primary mb-3">+ สร้างชั้นเรียนใหม่</a>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">รายชั้นเรียน</h5>
        </div>
        <div class="card-body">
            @if($classes->count() > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>รหัสชั้นเรียน</th>
                            <th>ชื่อชั้นเรียน</th>
                            <th>ระดับ</th>
                            <th>อาจารย์ที่ปรึกษา</th>
                            <th>จำนวนนักเรียน</th>
                            <th>ดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classes as $class)
                            <tr>
                                <td>{{ $class->class_code }}</td>
                                <td>{{ $class->class_name }}</td>
                                <td>{{ $class->level }}</td>
                                <td>{{ $class->advisor->name ?? '-' }}</td>
                                <td>{{ $class->students->count() }}</td>
                                <td>
                                    <a href="{{ route('classes.show', $class) }}" class="btn btn-info btn-sm">ดู</a>
                                    <a href="{{ route('classes.edit', $class) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                                    <form action="{{ route('classes.destroy', $class) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบ?')">ลบ</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $classes->links() }}
                </div>
            @else
                <div class="alert alert-info">ยังไม่มีชั้นเรียน</div>
            @endif
        </div>
    </div>
</div>
@endsection
