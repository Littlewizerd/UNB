@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">ประวัติการเข้าเรียน</h1>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">บันทึกการเข้าเรียนของ {{ Auth::user()->name }}</h5>
        </div>
        <div class="card-body">
            @if($attendances->count() > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>วัน</th>
                            <th>วิชา</th>
                            <th>เวลาเข้า</th>
                            <th>เวลาออก</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $record)
                            <tr>
                                <td>{{ $record->attendance_date->format('d/m/Y') }}</td>
                                <td>{{ $record->subject->name ?? '-' }}</td>
                                <td>{{ $record->check_in_time ?? '-' }}</td>
                                <td>{{ $record->check_out_time ?? '-' }}</td>
                                <td>
                                    @php
                                        $statusClass = match($record->status) {
                                            'present' => 'success',
                                            'absent' => 'danger',
                                            'late' => 'warning',
                                            'excused' => 'info',
                                            default => 'secondary'
                                        };
                                        $statusText = match($record->status) {
                                            'present' => 'มาเรียน',
                                            'absent' => 'ขาดเรียน',
                                            'late' => 'มาสาย',
                                            'excused' => 'ลากิจ/ป่วย',
                                            default => 'ไม่ระบุ'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $attendances->links() }}
                </div>
            @else
                <div class="alert alert-info">ยังไม่มีบันทึกการเข้าเรียน</div>
            @endif
        </div>
    </div>
</div>
@endsection
