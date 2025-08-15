<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;

class WarehouseReportController extends Controller
{

    public function index()
    {
        $warehouses = Warehouse::select('id', 'name')->get();
        return view('warehouse_reports.index', compact('warehouses'));
    }


   public function view(Request $request)
    {
        $reportType = $request->report_type;
        $warehouseId = $request->warehouse_id;
        $from = $request->from;
        $to = $request->to;

        $reportData = [];

        switch ($reportType) {
            case 'current_stock':
                $query = \App\Models\WarehouseItem::with('product', 'warehouse');
                if ($warehouseId) $query->where('warehouse_id', $warehouseId);
                $reportData = $query->get();
                return view('warehouse_reports.current_stock', compact('reportData'));

            case 'supplies':
                $query = \App\Models\SupplyInvoice::with('warehouse', 'items.product');
                if ($warehouseId) $query->where('warehouse_id', $warehouseId);
                if ($from) $query->whereDate('invoice_date', '>=', $from);
                if ($to) $query->whereDate('invoice_date', '<=', $to);
                $reportData = $query->get();
                return view('warehouse_reports.supplies', compact('reportData'));

            case 'deliveries':
                $query = \App\Models\IssueInvoice::with('warehouse', 'items.product');
                if ($warehouseId) $query->where('warehouse_id', $warehouseId);
                if ($from) $query->whereDate('issue_date', '>=', $from);
                if ($to) $query->whereDate('issue_date', '<=', $to);
                $reportData = $query->get();
                return view('warehouse_reports.deliveries', compact('reportData'));

            case 'adjustments':
                $query = \App\Models\InventoryAdjustment::with('warehouse', 'product');
                if ($warehouseId) $query->where('warehouse_id', $warehouseId);
                if ($from) $query->whereDate('adjustment_date', '>=', $from);
                if ($to) $query->whereDate('adjustment_date', '<=', $to);
                $reportData = $query->get();
                return view('warehouse_reports.adjustments', compact('reportData'));

            default:
                return back()->with('error', 'يرجى اختيار نوع التقرير.');
        }
    }


}
