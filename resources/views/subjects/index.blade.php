@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">จัดการวิชาเรียน</h1>

    <a href="{{ route('subjects.create') }}" class="btn btn-primary mb-3">+ เพิ่มวิชาใหม่</a>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">รายวิชาเรียน</h5>
        </div>
        <div class="card-body">
            @if($subjects->count() > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>รหัสวิชา</th>
                            <th>ชื่อวิชา</th>
                            <th>ครูผู้สอน</th>
                            <th>หน่วยกิต</th>
                            <th>ดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subjects as $subject)
                            <tr>
                                <td>{{ $subject->subject_code }}</td>
                                <td>{{ $subject->name }}</td>
                                <td>{{ $subject->teacher->name ?? '-' }}</td>
                                <td>{{ $subject->credits ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('subjects.show', $subject) }}" class="btn btn-info btn-sm">ดู</a>
                                    <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                                    <form action="{{ route('subjects.destroy', $subject) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบ?')">ลบ</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $subjects->links() }}
                </div>
            @else
                <div class="alert alert-info">ยังไม่มีวิชาเรียน</div>
            @endif
        </div>
    </div>
</div>
@endsection
