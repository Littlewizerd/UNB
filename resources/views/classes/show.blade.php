@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">ข้อมูลชั้นเรียน</h1>

    <div class="row">
        <div class="col-md-5">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">รายละเอียดชั้นเรียน</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">รหัสชั้นเรียน:</th>
                            <td>{{ $class->class_code }}</td>
                        </tr>
                        <tr>
                            <th>ชื่อชั้นเรียน:</th>
                            <td>{{ $class->class_name }}</td>
                        </tr>
                        <tr>
                            <th>ระดับชั้น:</th>
                            <td>{{ $class->level ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>อาจารย์ที่ปรึกษา:</th>
                            <td>{{ $class->advisor->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>จำนวนนักเรียน:</th>
                            <td>{{ $class->students->count() ?? 0 }} คน</td>
                        </tr>
                        <tr>
                            <th>หมายเหตุ:</th>
                            <td>{{ $class->description ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>สร้างเมื่อ:</th>
                            <td>{{ $class->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="mb-3">
                <a href="{{ route('classes.edit', $class) }}" class="btn btn-warning">แก้ไข</a>
                <a href="{{ route('classes.index') }}" class="btn btn-secondary">กลับ</a>
                <form action="{{ route('classes.destroy', $class) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('ยืนยันการลบชั้นเรียน {{ $class->class_name }}?')">ลบ</button>
                </form>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">รายชื่อนักเรียน</h5>
                    <span class="badge bg-primary">{{ $class->students->count() }} คน</span>
                </div>
                <div class="card-body">
                    @if($class->students && $class->students->count() > 0)
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>รหัส</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>อีเมล</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($class->students as $index => $student)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $student->student_id }}</td>
                                        <td>
                                            <a href="{{ route('students.show', $student) }}">{{ $student->name }}</a>
                                        </td>
                                        <td>{{ $student->email }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-info mb-0">ยังไม่มีนักเรียนในชั้นเรียนนี้</div>
                    @endif
                </div>
            </div>

            @if($class->schedules && $class->schedules->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">ตารางเรียน</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>วัน</th>
                                <th>วิชา</th>
                                <th>เวลา</th>
                                <th>ห้อง</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $dayMap = ['M' => 'จันทร์', 'T' => 'อังคาร', 'W' => 'พุธ', 'TH' => 'พฤหัสบดี', 'F' => 'ศุกร์', 'SA' => 'เสาร์', 'SU' => 'อาทิตย์'];
                            @endphp
                            @foreach($class->schedules as $schedule)
                                <tr>
                                    <td>{{ $dayMap[$schedule->day_of_week] ?? $schedule->day_of_week }}</td>
                                    <td>{{ $schedule->subject->name ?? '-' }}</td>
                                    <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                                    <td>{{ $schedule->room ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
