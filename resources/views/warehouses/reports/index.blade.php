@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class="mb-4">📊 تقارير المخازن</h3>

    <form method="POST" action="{{ route('warehouse.reports.view') }}">
        @csrf

        <div class="row mb-3">
            <div class="col-md-4">
                <label>نوع التقرير</label>
                <select name="report_type" class="form-control" required>
                    <option value="">-- اختر --</option>
                    <option value="current_stock">الكميات الحالية</option>
                    <option value="supplies">تقرير التوريدات</option>
                    <option value="deliveries">تقرير الصرفيات</option>
                    <option value="adjustments">تقرير الفروقات</option>
                </select>
            </div>

            <div class="col-md-4">
                <label>المخزن (اختياري)</label>
                <select name="warehouse_id" class="form-control">
                    <option value="">جميع المخازن</option>
                    @foreach(\App\Models\Warehouse::all() as $warehouse)
                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label>الفترة (من - إلى)</label>
                <div class="d-flex gap-2">
                    <input type="date" name="from" class="form-control">
                    <input type="date" name="to" class="form-control">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">عرض التقرير</button>
    </form>
</div>
@endsection
