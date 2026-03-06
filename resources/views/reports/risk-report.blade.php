@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">รายงานนักเรียนเสี่ยง</h1>

    <div class="alert alert-warning">
        <strong>หมายเหตุ:</strong> นักเรียนที่มีอัตราการขาดเรียนมากกว่า 20% จะถูกแสดงในรายงานนี้
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">รายชื่อนักเรียนเสี่ยง</h5>
            <span class="badge bg-danger">{{ count($riskStudents) }} คน</span>
        </div>
        <div class="card-body">
            @if(count($riskStudents) > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>รหัสนักเรียน</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>ชั้นเรียน</th>
                            <th>จำนวนเข้าเรียน</th>
                            <th>จำนวนขาด</th>
                            <th>% ขาด</th>
                            <th>ระดับเสี่ยง</th>
                            <th>ดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riskStudents as $index => $data)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $data['student']->student_id }}</td>
                                <td>{{ $data['student']->name }}</td>
                                <td>{{ $data['student']->studentClass->class_name ?? '-' }}</td>
                                <td>{{ $data['total'] }}</td>
                                <td class="text-danger fw-bold">{{ $data['absent'] }}</td>
                                <td>{{ $data['percentage'] }}%</td>
                                <td>
                                    @if($data['risk_level'] === 'สูง')
                                        <span class="badge bg-danger">{{ $data['risk_level'] }}</span>
                                    @else
                                        <span class="badge bg-warning">{{ $data['risk_level'] }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('reports.individualReport', $data['student']) }}" class="btn btn-info btn-sm">ดูรายละเอียด</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-success mb-0">
                    <i class="bi bi-check-circle"></i> ไม่พบนักเรียนที่มีความเสี่ยง
                </div>
            @endif
        </div>
    </div>

    <div class="mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card border-warning">
                    <div class="card-body">
                        <h6 class="card-title text-warning">ระดับเสี่ยงปานกลาง</h6>
                        <p class="card-text small">นักเรียนที่ขาดเรียน 20-30% ควรได้รับการติดตามและเตือน</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-danger">
                    <div class="card-body">
                        <h6 class="card-title text-danger">ระดับเสี่ยงสูง</h6>
                        <p class="card-text small">นักเรียนที่ขาดเรียนมากกว่า 30% ต้องได้รับการดูแลเป็นพิเศษ</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
