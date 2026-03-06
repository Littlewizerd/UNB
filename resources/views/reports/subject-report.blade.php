@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">รายงานการเข้าเรียน - {{ $subject->name }}</h1>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">รายละเอียดวิชา</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>รหัสวิชา:</strong> {{ $subject->subject_code }}</p>
                    <p><strong>ชื่อวิชา:</strong> {{ $subject->name }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>ผู้สอน:</strong> {{ $subject->teacher->name ?? '-' }}</p>
                    <p><strong>หน่วยกิต:</strong> {{ $subject->credits ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

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
                            <th>นักเรียน</th>
                            <th>เวลาเข้า</th>
                            <th>เวลาออก</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $record)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($record->attendance_date)->format('d/m/Y') }}</td>
                                <td>{{ $record->student->name ?? '-' }}</td>
                                <td>{{ $record->check_in_time ?? '-' }}</td>
                                <td>{{ $record->check_out_time ?? '-' }}</td>
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
                <div class="alert alert-info">ยังไม่มีบันทึกการเข้าเรียนสำหรับวิชานี้</div>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('subjects.index') }}" class="btn btn-secondary">กลับ</a>
    </div>
</div>
@endsection
