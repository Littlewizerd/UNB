@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">ข้อมูลครู</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">ข้อมูลส่วนตัว</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">รหัสครู:</th>
                            <td>{{ $teacher->teacher_id }}</td>
                        </tr>
                        <tr>
                            <th>ชื่อ-นามสกุล:</th>
                            <td>{{ $teacher->name }}</td>
                        </tr>
                        <tr>
                            <th>อีเมล:</th>
                            <td>{{ $teacher->email }}</td>
                        </tr>
                        <tr>
                            <th>โทรศัพท์:</th>
                            <td>{{ $teacher->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>แผนก/สาขา:</th>
                            <td>{{ $teacher->department ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>สร้างเมื่อ:</th>
                            <td>{{ $teacher->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">สรุปข้อมูล</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3">
                                <h4 class="text-primary mb-0">{{ $teacher->subjects->count() ?? 0 }}</h4>
                                <small class="text-muted">วิชาที่สอน</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border rounded p-3">
                                <h4 class="text-success mb-0">{{ $totalStudents ?? 0 }}</h4>
                                <small class="text-muted">ห้องเรียนที่สอน</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($teacher->subjects && $teacher->subjects->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">วิชาที่สอน</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($teacher->subjects as $subject)
                            <li class="list-group-item">{{ $subject->name }} ({{ $subject->subject_code }})</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-warning">แก้ไข</a>
        <a href="{{ route('teachers.index') }}" class="btn btn-secondary">กลับ</a>
        <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" style="display:inline;">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('ยืนยันการลบครู {{ $teacher->name }}?')">ลบ</button>
        </form>
    </div>
</div>
@endsection
