<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>รายงานรายบุคคล - {{ $student->name }}@if($selectedSubject) - {{ $selectedSubject->name }}@endif</title>
    <style>
        body {
            font-family: 'sarabun', sans-serif;
            font-size: 14px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-section h3 {
            background-color: #f0f0f0;
            padding: 8px 12px;
            margin: 0 0 10px 0;
            font-size: 16px;
        }
        .info-grid {
            display: table;
            width: 100%;
        }
        .info-row {
            display: table-row;
        }
        .info-label, .info-value {
            display: table-cell;
            padding: 5px 10px;
        }
        .info-label {
            width: 150px;
            font-weight: bold;
        }
        .stats-box {
            text-align: center;
            display: inline-block;
            width: 22%;
            padding: 10px;
            border: 1px solid #ddd;
            margin: 5px 1%;
        }
        .stats-box h4 {
            margin: 0;
            font-size: 24px;
        }
        .stats-box small {
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: center;
            font-size: 12px;
        }
        th {
            background-color: #f0f0f0;
        }
        .text-left {
            text-align: left;
        }
        .text-success { color: #28a745; }
        .text-danger { color: #dc3545; }
        .text-warning { color: #ffc107; }
        .text-info { color: #17a2b8; }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
            color: #666;
        }
        .percentage {
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            padding: 15px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>รายงานการเข้าเรียนรายบุคคล</h1>
        <p>ระบบตรวจสอบเวลาเรียน - Attendance Management System</p>
        @if($selectedSubject)
            <p>รายวิชา: {{ $selectedSubject->name }} @if($selectedSubject->subject_code) ({{ $selectedSubject->subject_code }}) @endif</p>
        @endif
    </div>

    <div class="info-section">
        <h3>ข้อมูลนักเรียน</h3>
        <div class="info-grid">
            <div class="info-row">
                <span class="info-label">รหัสนักเรียน:</span>
                <span class="info-value">{{ $student->student_id }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">ชื่อ-นามสกุล:</span>
                <span class="info-value">{{ $student->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">ชั้นเรียน:</span>
                <span class="info-value">{{ $student->studentClass->class_name ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">อีเมล:</span>
                <span class="info-value">{{ $student->email }}</span>
            </div>
        </div>
    </div>

    <div class="info-section">
        <h3>สถิติการเข้าเรียน</h3>
        <div style="text-align: center;">
            <div class="stats-box">
                <h4 class="text-success">{{ $stats['present'] }}</h4>
                <small>มาเรียน</small>
            </div>
            <div class="stats-box">
                <h4 class="text-danger">{{ $stats['absent'] }}</h4>
                <small>ขาดเรียน</small>
            </div>
            <div class="stats-box">
                <h4 class="text-warning">{{ $stats['late'] }}</h4>
                <small>มาสาย</small>
            </div>
            <div class="stats-box">
                <h4 class="text-info">{{ $stats['excused'] }}</h4>
                <small>ลา</small>
            </div>
        </div>
        @php
            $total = $stats['present'] + $stats['absent'] + $stats['late'] + $stats['excused'];
            $percentage = $total > 0 ? round((($stats['present'] + $stats['late']) / $total) * 100, 2) : 0;
        @endphp
        <div class="percentage {{ $percentage >= 80 ? 'text-success' : ($percentage >= 60 ? 'text-warning' : 'text-danger') }}">
            อัตราการเข้าเรียน: {{ $percentage }}%
        </div>
    </div>

    <!-- ภาพรวมรายวิชา -->
    @if(isset($subjectStats) && $subjectStats->count() > 0)
    <div class="info-section">
        <h3>ภาพรวมรายวิชา</h3>
        <table>
            <thead>
                <tr>
                    <th>วิชา</th>
                    <th>มาเรียน</th>
                    <th>ขาด</th>
                    <th>สาย</th>
                    <th>ลา</th>
                    <th>อัตราเข้าเรียน</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subjectStats as $data)
                    @php
                        $pct = $data['percentage'];
                        $pctColor = $pct >= 80 ? 'text-success' : ($pct >= 60 ? 'text-warning' : 'text-danger');
                    @endphp
                    <tr>
                        <td class="text-left">
                            {{ $data['subject']->name ?? '-' }}
                            @if($data['subject']->subject_code ?? null)
                                <br><span style="color: #888; font-size: 11px;">{{ $data['subject']->subject_code }}</span>
                            @endif
                        </td>
                        <td>{{ $data['present'] }}</td>
                        <td>{{ $data['absent'] }}</td>
                        <td>{{ $data['late'] }}</td>
                        <td>{{ $data['excused'] }}</td>
                        <td class="{{ $pctColor }}">{{ $pct }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="footer">
        <p>วันที่พิมพ์: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
