<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>รายงานข้อมูลห้องเรียน</title>
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
        .summary {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px 8px;
            text-align: center;
            font-size: 13px;
        }
        th {
            background-color: #f0f0f0;
        }
        .text-left {
            text-align: left;
        }
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
        <h1>รายงานข้อมูลห้องเรียนทั้งหมด</h1>
        <p>ระบบตรวจสอบเวลาเรียน - Attendance Management System</p>
        <p>วันที่พิมพ์: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="summary">
        <strong>จำนวนห้องเรียนทั้งหมด:</strong> {{ $classes->count() }} ห้อง
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="12%">รหัสห้องเรียน</th>
                <th width="20%" class="text-left">ชื่อห้องเรียน</th>
                <th width="10%">ระดับชั้น</th>
                <th width="18%" class="text-left">อาจารย์ที่ปรึกษา</th>
                <th width="10%">จำนวนนักศึกษา</th>
                <th width="10%">จำนวนตารางเรียน</th>
                <th width="15%" class="text-left">รายละเอียด</th>
            </tr>
        </thead>
        <tbody>
            @foreach($classes as $index => $class)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $class->class_code }}</td>
                    <td class="text-left">{{ $class->class_name }}</td>
                    <td>{{ $class->level ?? '-' }}</td>
                    <td class="text-left">{{ $class->advisor->name ?? '-' }}</td>
                    <td>{{ $class->students_count }}</td>
                    <td>{{ $class->schedules_count }}</td>
                    <td class="text-left">{{ $class->description ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>ระบบตรวจสอบเวลาเรียน - Attendance Management System</p>
    </div>
</body>
</html>
