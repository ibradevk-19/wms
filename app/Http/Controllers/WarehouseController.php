<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;

class WarehouseController extends Controller
{
    public function index()
    {
        return view('warehouses.index');
    }

    public function getData()
    {
        $warehouses = Warehouse::query();

        return datatables()->of($warehouses)
            ->addColumn('actions', function ($row) {
                return view('warehouses.partials.actions', compact('row'))->render();
            })
            ->editColumn('status', function ($row) {
                return $row->status;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function create()
    {
        return view('warehouses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:warehouses,code',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,under_maintenance',
            'capacity' => 'nullable|integer|min:0',
            'notes' => 'nullable|string'
        ]);

        Warehouse::create($validated);

        return redirect()->route('warehouses.index')->with('success', 'تم إنشاء المخزن بنجاح');
    }


    public function edit(Warehouse $warehouse)
    {
        return view('warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:warehouses,code,' . $warehouse->id,
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,under_maintenance',
            'capacity' => 'nullable|integer|min:0',
            'notes' => 'nullable|string'
        ]);

        $warehouse->update($validated);

        return redirect()->route('warehouses.index')->with('success', 'تم تعديل بيانات المخزن بنجاح');
    }


    public function show(Warehouse $warehouse)
    {
        // مثال: نحسب النسبة المستغلة مؤقتًا (في المرحلة القادمة نحسب بناءً على الأصناف الفعلية)
        $usedCapacity = rand(0, $warehouse->capacity ?? 100); // سيتم استبداله لاحقًا بالحساب الحقيقي
        $capacityPercent = $warehouse->capacity ? round(($usedCapacity / $warehouse->capacity) * 100, 2) : 0;

        return view('warehouses.show', compact('warehouse', 'usedCapacity', 'capacityPercent'));
    }


    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();

        return response()->json(['status' => 'success', 'message' => 'تم حذف المخزن بنجاح']);
    }

    public function items(Warehouse $warehouse)
    {
        $items = $warehouse->items()->with('product')->get();

        return view('warehouses.items', compact('warehouse', 'items'));
    }





}
