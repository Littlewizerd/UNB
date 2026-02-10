@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">ลงเวลาเข้าเรียน</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">ตารางเรียนของคุณวันนี้</h5>
        </div>
        <div class="card-body">
            @if($schedules->count() > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>วิชา</th>
                            <th>เวลา</th>
                            <th>ห้องเรียน</th>
                            <th>ครู</th>
                            <th>ลงเวลา</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules as $schedule)
                            <tr>
                                <td>{{ $schedule->subject->name ?? '-' }}</td>
                                <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                                <td>{{ $schedule->room ?? '-' }}</td>
                                <td>{{ $schedule->teacher->name ?? '-' }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" 
                                            data-bs-target="#checkInModal{{ $schedule->id }}">
                                        เข้าเรียน
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="checkInModal{{ $schedule->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">ลงเวลา {{ $schedule->subject->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('attendance.store') }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                                        <div class="mb-3">
                                                            <label class="form-label">เวลาเข้า</label>
                                                            <input type="time" class="form-control" name="check_in_time" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">เวลาออก (ไม่บังคับ)</label>
                                                            <input type="time" class="form-control" name="check_out_time">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                                        <button type="submit" class="btn btn-primary">บันทึก</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info">ไม่มีตารางเรียนวันนี้</div>
            @endif
        </div>
    </div>
</div>
@endsection
