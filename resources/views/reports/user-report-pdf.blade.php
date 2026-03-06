<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>รายงานบัญชีผู้ใช้</title>
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
        .summary span {
            margin-right: 20px;
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
        .badge-admin { color: #dc3545; font-weight: bold; }
        .badge-teacher { color: #ffc107; font-weight: bold; }
        .badge-student { color: #28a745; font-weight: bold; }
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
        <h1>รายงานบัญชีผู้ใช้ทั้งหมด</h1>
        <p>ระบบตรวจสอบเวลาเรียน - Attendance Management System</p>
        <p>วันที่พิมพ์: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="summary">
        <strong>สรุป:</strong>
        <span>ทั้งหมด {{ $summary['total'] }} คน</span>
        <span>ผู้ดูแลระบบ {{ $summary['admin'] }} คน</span>
        <span>อาจารย์ {{ $summary['teacher'] }} คน</span>
        <span>นักศึกษา {{ $summary['student'] }} คน</span>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="20%" class="text-left">ชื่อ-นามสกุล</th>
                <th width="20%">อีเมล</th>
                <th width="10%">บทบาท</th>
                <th width="12%">รหัสนักศึกษา</th>
                <th width="12%">รหัสอาจารย์</th>
                <th width="10%">โทรศัพท์</th>
                <th width="11%">วันที่สร้าง</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="text-left">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'admin')
                            <span class="badge-admin">ผู้ดูแลระบบ</span>
                        @elseif($user->role === 'teacher')
                            <span class="badge-teacher">อาจารย์</span>
                        @else
                            <span class="badge-student">นักศึกษา</span>
                        @endif
                    </td>
                    <td>{{ $user->student_id ?? '-' }}</td>
                    <td>{{ $user->teacher_id ?? '-' }}</td>
                    <td>{{ $user->phone ?? '-' }}</td>
                    <td>{{ $user->created_at?->format('d/m/Y') ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>ระบบตรวจสอบเวลาเรียน - Attendance Management System</p>
    </div>
</body>
</html>
