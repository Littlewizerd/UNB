@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">บันทึกการเข้าเรียน (ครู)</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">เลือกตารางเรียนเพื่อบันทึกการเข้าเรียน</h5>
        </div>
        <div class="card-body">
            @if($schedules->count() > 0)
                @foreach($schedules as $schedule)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6>{{ $schedule->subject->name }} - {{ $schedule->studentClass->class_name }}</h6>
                            <p class="mb-0 text-muted">{{ $schedule->start_time }} - {{ $schedule->end_time }} | ห้อง {{ $schedule->room }}</p>

                            <button class="btn btn-primary btn-sm mt-2" data-bs-toggle="collapse" 
                                    data-bs-target="#attend{{ $schedule->id }}">
                                บันทึกการเข้าเรียน
                            </button>

                            <div class="collapse mt-3" id="attend{{ $schedule->id }}">
                                <form action="{{ route('attendance.recordByTeacher') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>นักเรียน</th>
                                                <th>สถานะ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($schedule->studentClass->students as $student)
                                                <tr>
                                                    <td>{{ $student->name }}</td>
                                                    <td>
                                                        <select class="form-select form-select-sm" 
                                                                name="attendances[{{ $student->id }}][status]" required>
                                                            <option value="">-- เลือก --</option>
                                                            <option value="present">มาเรียน</option>
                                                            <option value="absent">ขาดเรียน</option>
                                                            <option value="late">มาสาย</option>
                                                            <option value="excused">ลากิจ/ป่วย</option>
                                                        </select>
                                                        <input type="hidden" name="attendances[{{ $student->id }}][student_id]" 
                                                               value="{{ $student->id }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <button type="submit" class="btn btn-success btn-sm">บันทึก</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-info">ไม่มีตารางเรียนในวันนี้</div>
            @endif
        </div>
    </div>
</div>
@endsection
