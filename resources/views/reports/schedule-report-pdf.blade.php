<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>รายงานตารางเรียน/สอน</title>
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
            font-size: 12px;
        }
        th {
            background-color: #f0f0f0;
            font-size: 13px;
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
        <h1>รายงานตารางเรียน/ตารางสอนทั้งหมด</h1>
        <p>ระบบตรวจสอบเวลาเรียน - Attendance Management System</p>
        <p>วันที่พิมพ์: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="summary">
        <strong>จำนวนตารางทั้งหมด:</strong> {{ $schedules->count() }} รายการ
    </div>

    @php
        $days = \App\Models\Schedule::DAYS;
    @endphp

    <table>
        <thead>
            <tr>
                <th width="4%">#</th>
                <th width="10%">วัน</th>
                <th width="12%">เวลา</th>
                <th width="20%" class="text-left">วิชา</th>
                <th width="15%" class="text-left">อาจารย์</th>
                <th width="15%" class="text-left">ห้องเรียน</th>
                <th width="10%">ห้อง</th>
                <th width="14%">ภาคเรียน</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedules as $index => $schedule)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $days[$schedule->day_of_week] ?? $schedule->day_of_week }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                    <td class="text-left">{{ $schedule->subject->name ?? '-' }}</td>
                    <td class="text-left">{{ $schedule->teacher->name ?? '-' }}</td>
                    <td class="text-left">{{ $schedule->studentClass->class_name ?? '-' }}</td>
                    <td>{{ $schedule->room ?? '-' }}</td>
                    <td>{{ $schedule->semesterData->name ?? ($schedule->semester ?? '-') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>ระบบตรวจสอบเวลาเรียน - Attendance Management System</p>
    </div>
</body>
</html>
