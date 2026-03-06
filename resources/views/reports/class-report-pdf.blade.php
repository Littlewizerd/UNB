<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>รายงานชั้นเรียน - {{ $class->class_name }}</title>
    <style>
        body {
            font-family: 'sarabun', sans-serif;
            font-size: 14px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
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
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>รายงานการเข้าเรียน</h1>
        <p>ชั้นเรียน: {{ $class->class_name }} ({{ $class->class_code }})</p>
        <p>อาจารย์ที่ปรึกษา: {{ $class->advisor->name ?? '-' }}</p>
        <p>วันที่พิมพ์: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="15%">รหัส</th>
                <th width="25%" class="text-left">ชื่อ-นามสกุล</th>
                <th width="10%">มาเรียน</th>
                <th width="10%">ขาด</th>
                <th width="10%">สาย</th>
                <th width="10%">ลา</th>
                <th width="15%">อัตราเข้าเรียน</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $index => $data)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $data['student']->student_id }}</td>
                    <td class="text-left">{{ $data['student']->name }}</td>
                    <td class="text-success">{{ $data['present'] }}</td>
                    <td class="text-danger">{{ $data['absent'] }}</td>
                    <td class="text-warning">{{ $data['late'] }}</td>
                    <td class="text-info">{{ $data['excused'] }}</td>
                    <td>{{ $data['percentage'] }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>ระบบตรวจสอบเวลาเรียน - Attendance Management System</p>
    </div>
</body>
</html>
