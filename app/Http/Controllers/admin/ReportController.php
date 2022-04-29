<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ParkedCount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller
{
    public function generatePDF()
    {
        $index = ParkedCount::query();
        $date = Carbon::now();

        $index->where("created_at", $date)
        ->orderBy("created_at", 'desc');
        
        // retreive all records from db
        $data = ['cars' => $index->get(),"grandtotal" =>$index->count()];
  
        // share data to view;
        $pdf = PDF::loadView('daily_reports', $data)->setPaper('a4', 'landscape');
  
        // download PDF file with download method
        return $pdf->download('DAILYREPORTS.pdf');
    }
}
