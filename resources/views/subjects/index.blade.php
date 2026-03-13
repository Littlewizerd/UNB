@extends('layouts.app')

@section('content')
<div class="container">
    @php
        $canManageSubject = strtolower(auth()->user()->role ?? '') === 'admin';
    @endphp

    <h1 class="my-4">จัดการวิชาเรียน</h1>

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        @if($canManageSubject)
            <a href="{{ route('subjects.create') }}" class="btn btn-primary">+ เพิ่มวิชาใหม่</a>
        @else
            <div class="text-muted small">แสดงข้อมูลรายวิชา (อ่านอย่างเดียว)</div>
        @endif

        <form method="GET" action="{{ route('subjects.index') }}" class="d-flex gap-2" style="max-width: 420px; width: 100%;">
            <input type="text" name="q" value="{{ $search ?? '' }}" class="form-control" placeholder="ค้นหาชื่อวิชา หรือรหัสวิชา">
            <button type="submit" class="btn btn-outline-primary">ค้นหา</button>
            <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary">ล้าง</a>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">รายวิชาเรียน ({{ $subjects->total() }} รายการ)</h5>
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
                                    @if($canManageSubject)
                                        <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                                        <form action="{{ route('subjects.destroy', $subject) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบ?')">ลบ</button>
                                        </form>
                                    @endif
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