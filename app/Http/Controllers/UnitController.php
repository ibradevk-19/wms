<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;

class UnitController extends Controller
{

    public function index()
    {
        $units = Unit::paginate(20);
        return view('units.index', compact('units'));
    }

    public function create()
    {
        return view('units.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'short_code' => 'nullable|string|max:10',
        ]);

        Unit::create($data);
        return redirect()->route('units.index')->with('success', 'تمت الإضافة بنجاح');
    }

    public function edit(Unit $unit)
    {
        return view('units.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'short_code' => 'nullable|string|max:10',
        ]);

        $unit->update($data);
        return redirect()->route('units.index')->with('success', 'تم التعديل بنجاح');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('units.index')->with('success', 'تم الحذف بنجاح');
    }

}
