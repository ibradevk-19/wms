<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    public function index()
    {
        $trucks = Truck::latest()->get();
        return view('trucks.index', compact('trucks'));
    }

    public function create()
    {
        return view('trucks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'plate_number' => 'required|unique:trucks,plate_number',
            'driver_name' => 'required',
            'driver_phone' => 'nullable',
        ]);

        Truck::create($request->all());

        return redirect()->route('trucks.index')->with('success', 'تمت إضافة الشاحنة بنجاح');
    }

    public function edit(Truck $truck)
    {
        return view('trucks.edit', compact('truck'));
    }

    public function update(Request $request, Truck $truck)
    {
        $request->validate([
            'plate_number' => 'required|unique:trucks,plate_number,' . $truck->id,
            'driver_name' => 'required',
            'driver_phone' => 'nullable',
        ]);

        $truck->update($request->all());

        return redirect()->route('trucks.index')->with('success', 'تم تحديث بيانات الشاحنة');
    }

    public function destroy(Truck $truck)
    {
        $truck->delete();
        return redirect()->route('trucks.index')->with('success', 'تم حذف الشاحنة');
    }


    public function loads($truck_id)
    {
        $truck = Truck::with(['supplyInvoices.items.product', 'supplyInvoices.warehouse'])->findOrFail($truck_id);

        return view('trucks.loads', compact('truck'));
    }
}

