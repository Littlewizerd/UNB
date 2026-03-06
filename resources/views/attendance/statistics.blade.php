@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">สถิติการเข้าเรียน - {{ $student->name }}</h1>

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
        </div>

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">สรุปสถิติการเข้าเรียน</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 col-6 mb-3">
                            <div class="card border-success">
                                <div class="card-body bg-success bg-opacity-10">
                                    <h2 class="text-success mb-0">{{ $stats['present'] }}</h2>
                                    <small class="text-muted">มาเรียน</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="card border-danger">
                                <div class="card-body bg-danger bg-opacity-10">
                                    <h2 class="text-danger mb-0">{{ $stats['absent'] }}</h2>
                                    <small class="text-muted">ขาดเรียน</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="card border-warning">
                                <div class="card-body bg-warning bg-opacity-10">
                                    <h2 class="text-warning mb-0">{{ $stats['late'] }}</h2>
                                    <small class="text-muted">มาสาย</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="card border-info">
                                <div class="card-body bg-info bg-opacity-10">
                                    <h2 class="text-info mb-0">{{ $stats['excused'] }}</h2>
                                    <small class="text-muted">ลากิจ/ป่วย</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h5>อัตราการเข้าเรียน</h5>
                            <div class="progress" style="height: 30px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                     style="width: {{ $stats['percentage'] }}%"
                                     aria-valuenow="{{ $stats['percentage'] }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ $stats['percentage'] }}%
                                </div>
                            </div>
                            <small class="text-muted">จากทั้งหมด {{ $stats['total'] }} ครั้ง</small>
                        </div>
                        <div class="col-md-6 text-center">
                            <h5>สถานะ</h5>
                            @if($stats['percentage'] >= 80)
                                <span class="badge bg-success fs-5">ดีมาก</span>
                                <p class="text-muted small mt-2">เข้าเรียนสม่ำเสมอ</p>
                            @elseif($stats['percentage'] >= 60)
                                <span class="badge bg-warning fs-5">ควรปรับปรุง</span>
                                <p class="text-muted small mt-2">ควรเพิ่มการเข้าเรียน</p>
                            @else
                                <span class="badge bg-danger fs-5">เสี่ยง</span>
                                <p class="text-muted small mt-2">ต้องได้รับการติดตาม</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('students.show', $student) }}" class="btn btn-primary">ดูข้อมูลนักเรียน</a>
        <a href="{{ route('reports.individualReport', $student) }}" class="btn btn-info">ดูรายงานรายบุคคล</a>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">กลับ</a>
    </div>
</div>
@endsection
