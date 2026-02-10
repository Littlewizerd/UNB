@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">รายงานการเข้าเรียนแบบรายชั้นเรียน</h1>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $class->class_name }} ({{ $class->class_code }})</h5>
            <a href="{{ route('reports.classReportPdf', $class) }}" class="btn btn-success btn-sm">ดาวน์โหลด PDF</a>
        </div>
        <div class="card-body">
            @if($reportData)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>รหัสนักเรียน</th>
                            <th>ชื่อ</th>
                            <th>มาเรียน</th>
                            <th>ขาดเรียน</th>
                            <th>มาสาย</th>
                            <th>ลากิจ/ป่วย</th>
                            <th>รวม</th>
                            <th>ร้อยละ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reportData as $data)
                            <tr>
                                <td>{{ $data['student']->student_id }}</td>
                                <td>{{ $data['student']->name }}</td>
                                <td><span class="badge bg-success">{{ $data['present'] }}</span></td>
                                <td><span class="badge bg-danger">{{ $data['absent'] }}</span></td>
                                <td><span class="badge bg-warning">{{ $data['late'] }}</span></td>
                                <td><span class="badge bg-info">{{ $data['excused'] }}</span></td>
                                <td>{{ $data['total'] }}</td>
                                <td>
                                    <span class="badge {{ $data['percentage'] >= 80 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $data['percentage'] }}%
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info">ยังไม่มีข้อมูล</div>
            @endif
        </div>
    </div>
</div>
@endsection
