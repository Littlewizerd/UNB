<div style="padding: 20px; font-family: Arial, sans-serif;">
    <h1>รายงาน สรุปการจองคิว</h1>
    <p><strong>ชื่อผู้ใช้:</strong> {{ $user->name }}</p>
    <p><strong>วันที่พิมพ์:</strong> {{ now()->format('d/m/Y H:i') }}</p>
    
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background-color: #f0f0f0;">
                <th style="border: 1px solid #ddd; padding: 8px;">ที่</th>
                <th style="border: 1px solid #ddd; padding: 8px;">วันที่จอง</th>
                <th style="border: 1px solid #ddd; padding: 8px;">บริการ</th>
                <th style="border: 1px solid #ddd; padding: 8px;">สถานะ</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
            <tr>
                <td style="border: 1px solid #ddd; padding: 8px;">{{ $loop->iteration }}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">{{ $booking->booking_date->format('d/m/Y') }}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">{{ $booking->service_name }}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">{{ $booking->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="border: 1px solid #ddd; padding: 8px; text-align: center;">ไม่มีข้อมูล</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
