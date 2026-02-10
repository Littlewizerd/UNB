@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">สรุปการเข้าเรียนประจำวัน</h1>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6 class="card-title">รวมทั้งสิ้น</h6>
                    <h4 class="text-primary">{{ $summary['total'] }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6 class="card-title">มาเรียน</h6>
                    <h4 class="text-success">{{ $summary['present'] }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6 class="card-title">ขาดเรียน</h6>
                    <h4 class="text-danger">{{ $summary['absent'] }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6 class="card-title">มาสาย</h6>
                    <h4 class="text-warning">{{ $summary['late'] }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">รายละเอียด</h5>
        </div>
        <div class="card-body">
            @if($attendances->count() > 0)
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>นักเรียน</th>
                            <th>ชั้นเรียน</th>
                            <th>วิชา</th>
                            <th>เวลาเข้า</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $record)
                            <tr>
                                <td>{{ $record->student->name }}</td>
                                <td>{{ $record->student->studentClass->class_name ?? '-' }}</td>
                                <td>{{ $record->subject->name ?? '-' }}</td>
                                <td>{{ $record->check_in_time ?? '-' }}</td>
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
            @else
                <div class="alert alert-info">ยังไม่มีบันทึกการเข้าเรียนในวันนี้</div>
            @endif
        </div>
    </div>
</div>
@endsection
