<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SupplyInvoicesImport;

class ImportsController extends Controller
{
    public function showSupplyForm()
    {
        return view('imports.supply_form');
    }

    public function importSupply(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv,html',
        ]);

        // تنظيف أي خرج سابق لمنع مشاكل "Invalid HTML file" عند استخدام FromView في أماكن أخرى
        if (ob_get_length()) { ob_end_clean(); }

        Excel::import(new SupplyInvoicesImport, $request->file('file'));

        return back()->with('success', 'تم استيراد فواتير التوريد بنجاح.');
    }
}
