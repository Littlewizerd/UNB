@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">รายงานรายบุคคล - {{ $student->name }}</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">ข้อมูลนักเรียน</h5>
                </div>
                <div class="card-body">
                    <p><strong>รหัสนักเรียน:</strong> {{ $student->student_id }}</p>
                    <p><strong>ชื่อ-นามสกุล:</strong> {{ $student->name }}</p>
                    <p><strong>ชั้นเรียน:</strong> {{ $student->studentClass->class_name ?? '-' }}</p>
                    <p><strong>อีเมล:</strong> {{ $student->email }}</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">สถิติการเข้าเรียน</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border rounded p-2 bg-success bg-opacity-10">
                                <h4 class="text-success mb-0">{{ $stats['present'] }}</h4>
                                <small class="text-muted">มาเรียน</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border rounded p-2 bg-danger bg-opacity-10">
                                <h4 class="text-danger mb-0">{{ $stats['absent'] }}</h4>
                                <small class="text-muted">ขาด</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border rounded p-2 bg-warning bg-opacity-10">
                                <h4 class="text-warning mb-0">{{ $stats['late'] }}</h4>
                                <small class="text-muted">สาย</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border rounded p-2 bg-info bg-opacity-10">
                                <h4 class="text-info mb-0">{{ $stats['excused'] }}</h4>
                                <small class="text-muted">ลา</small>
                            </div>
                        </div>
                    </div>
                    @php
                        $total = $stats['present'] + $stats['absent'] + $stats['late'] + $stats['excused'];
                        $attended = $stats['present'] + $stats['late']; // มาสายนับเป็นมาเรียน
                        $percentage = $total > 0 ? round(($attended / $total) * 100, 2) : 0;
                    @endphp
                    <div class="text-center mt-2">
                        <p class="mb-1"><strong>อัตราการเข้าเรียน</strong></p>
                        <small class="text-muted d-block">(นับมาสายเป็นมาเรียน)</small>
                        <h3 class="{{ $percentage >= 80 ? 'text-success' : ($percentage >= 60 ? 'text-warning' : 'text-danger') }}">
                            {{ $percentage }}%
                        </h3>
                    </div>
                </div>
            </div>

            <a href="{{ route('reports.individualReportPdf', $student) }}" class="btn btn-primary w-100 mb-3" target="_blank">
                <i class="bi bi-download"></i> ดาวน์โหลด PDF
            </a>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">ประวัติการเข้าเรียน</h5>
                </div>
                <div class="card-body">
                    @if($attendances->count() > 0)
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>วันที่</th>
                                    <th>วิชา</th>
                                    <th>เวลาเข้า</th>
                                    <th>เวลาออก</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendances as $record)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($record->attendance_date)->format('d/m/Y') }}</td>
                                        <td>{{ $record->schedule->subject->name ?? '-' }}</td>
                                        <td>{{ $record->check_in_time ? \Carbon\Carbon::parse($record->check_in_time)->format('H:i') : '-' }}</td>
                                        <td>{{ $record->check_out_time ? \Carbon\Carbon::parse($record->check_out_time)->format('H:i') : '-' }}</td>
                                        <td>
                                            @php
                                                $statusClass = match($record->status) {
                                                    'present' => 'success', 'absent' => 'danger',
                                                    'late' => 'warning', 'excused' => 'info',
                                                    default => 'secondary'
                                                };
                                                $statusText = match($record->status) {
                                                    'present' => 'มาเรียน', 'absent' => 'ขาดเรียน',
                                                    'late' => 'มาสาย', 'excused' => 'ลากิจ/ป่วย',
                                                    default => 'ไม่ระบุ'
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center">
                            {{ $attendances->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">ยังไม่มีบันทึกการเข้าเรียน</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('students.index') }}" class="btn btn-secondary">กลับ</a>
    </div>
</div>
@endsection
