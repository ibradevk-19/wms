@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class="mb-3">⬆️ استيراد فواتير التوريد من Excel</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            {{ implode(' | ', $errors->all()) }}
        </div>
    @endif

    <form method="POST" action="{{ route('imports.supply.run') }}" enctype="multipart/form-data" class="row g-3">
        @csrf
        <div class="col-md-6">
            <label class="form-label">اختر ملف Excel</label>
            <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv,.html" required>
        </div>
        <div class="col-12">
            <button class="btn btn-primary">🚀 بدء الاستيراد</button>
        </div>
    </form>

    <hr>
    <p class="text-muted">صيغة الأعمدة المتوقعة: invoice_number, invoice_date, supplier, truck_plate, warehouse, product, unit, pallets_count, quantity_per_pallet, total_weight.</p>
</div>
@endsection
