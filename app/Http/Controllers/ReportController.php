<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Warehouse;

class ReportController extends Controller
{
    public function lowStock()
    {
        $products = Product::with('unit')
            ->withSum('stocks as total_quantity', 'quantity')
            ->get()
            ->filter(function ($product) {
                return $product->total_quantity <= $product->alert_threshold;
            });

        return view('reports.low_stock', compact('products'));
    }


    public function stockSummary(Request $request)
    {
        $warehouses = Warehouse::all();
        $products = Product::with(['stocks.warehouse', 'unit'])->get();

        return view('reports.stock_summary', compact('products', 'warehouses'));
    }

    public function warehouseStock(Request $request)
    {
        $warehouses = Warehouse::all();
        $selectedWarehouse = $request->input('warehouse_id');

        $products = Product::with(['unit', 'stocks' => function ($q) use ($selectedWarehouse) {
            if ($selectedWarehouse) {
                $q->where('warehouse_id', $selectedWarehouse);
            }
        }])->get();

        return view('reports.warehouse_stock', compact('products', 'warehouses', 'selectedWarehouse'));
    }
}
