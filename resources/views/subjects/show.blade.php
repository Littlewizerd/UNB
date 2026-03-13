@extends('layouts.app')

@section('content')
<div class="container">
    @php
        $canManageSubject = strtolower(auth()->user()->role ?? '') === 'admin';
    @endphp

    <h1 class="my-4">ข้อมูลวิชา</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">รายละเอียดวิชา</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">รหัสวิชา:</th>
                            <td>{{ $subject->subject_code }}</td>
                        </tr>
                        <tr>
                            <th>ชื่อวิชา:</th>
                            <td>{{ $subject->name }}</td>
                        </tr>
                        <tr>
                            <th>หน่วยกิต:</th>
                            <td>{{ $subject->credits ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>ผู้สอน:</th>
                            <td>{{ $subject->teacher->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>รายละเอียด:</th>
                            <td>{{ $subject->description ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>สร้างเมื่อ:</th>
                            <td>{{ $subject->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            @if($subject->schedules && $subject->schedules->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">ตารางเรียน</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($subject->schedules as $schedule)
                            <li class="list-group-item">
                                {{ $schedule->studentClass->class_name ?? '-' }} - 
                                @php
                                    $dayMap = ['M' => 'จันทร์', 'T' => 'อังคาร', 'W' => 'พุธ', 'TH' => 'พฤหัสบดี', 'F' => 'ศุกร์', 'SA' => 'เสาร์', 'SU' => 'อาทิตย์'];
                                @endphp
                                {{ $dayMap[$schedule->day_of_week] ?? $schedule->day_of_week }}
                                {{ $schedule->start_time }} - {{ $schedule->end_time }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>

    @if($attendanceRecords)
        {{-- รายชื่อนักศึกษาในรายวิชา (p11: จัดการนักศึกษาในรายวิชา) --}}
        @if(isset($enrolledStudents) && $enrolledStudents->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">นักศึกษาในรายวิชานี้ ({{ $enrolledStudents->count() }} คน)</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>รหัสนักศึกษา</th>
                                <th>ชื่อ-นามสกุล</th>
                                <th>ห้องเรียน</th>
                                <th>อีเมล</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enrolledStudents as $idx => $student)
                                <tr>
                                    <td>{{ $idx + 1 }}</td>
                                    <td>{{ $student->student_id ?? '-' }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->studentClass->class_name ?? '-' }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>
                                        <a href="{{ route('reports.individualReport', $student) }}" class="btn btn-sm btn-info">ดูรายงาน</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">เวลาเรียนของนักศึกษาในรายวิชานี้</h5>
            </div>
            <div class="card-body">
                @if($attendanceRecords->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>วันที่</th>
                                    <th>รหัสนักศึกษา</th>
                                    <th>ชื่อนักศึกษา</th>
                                    <th>เวลาเข้า</th>
                                    <th>เวลาออก</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendanceRecords as $record)
                                    <tr>
                                        <td>{{ optional($record->attendance_date)->format('d/m/Y') }}</td>
                                        <td>{{ $record->student->student_id ?? '-' }}</td>
                                        <td>{{ $record->student->name ?? '-' }}</td>
                                        <td>{{ $record->check_in_time ?? '-' }}</td>
                                        <td>{{ $record->check_out_time ?? '-' }}</td>
                                        <td>{{ \App\Models\Attendance::STATUSES[$record->status] ?? $record->status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $attendanceRecords->links() }}
                    </div>
                @else
                    <div class="alert alert-info mb-0">ยังไม่มีข้อมูลเวลาเรียนของนักศึกษาในรายวิชานี้</div>
                @endif
            </div>
        </div>
    @endif

    <div class="mt-3">
        @if($canManageSubject)
            <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-warning">แก้ไข</a>
        @endif
        <a href="{{ route('subjects.index') }}" class="btn btn-secondary">กลับ</a>
        @if($canManageSubject)
            <form action="{{ route('subjects.destroy', $subject) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('ยืนยันการลบวิชา {{ $subject->name }}?')">ลบ</button>
            </form>
        @endif
    </div>
</div>
@endsection
