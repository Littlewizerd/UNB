<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function bookingSummary()
    {
        $user = Auth::user();
        $bookings = $user->bookings; // ต้องเขียน Model Booking ที่ relation กับ User
        
        $pdf = Pdf::loadView('reports.booking-summary', compact('bookings', 'user'));
        return $pdf->download('booking-summary-' . now()->format('Y-m-d') . '.pdf');
    }

    public function bookingHistory()
    {
        $user = Auth::user();
        $bookings = $user->bookings()->orderBy('created_at', 'desc')->get();
        
        $pdf = Pdf::loadView('reports.booking-history', compact('bookings', 'user'));
        return $pdf->download('booking-history-' . now()->format('Y-m-d') . '.pdf');
    }
}
