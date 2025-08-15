@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="mb-4">📊 تقرير فواتير التوريد</h2>

    {{-- ✅ نموذج الفلترة --}}
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-3">
            <label>المورد</label>
            <select name="supplier_id" class="form-control">
                <option value="">-- الكل --</option>
                @foreach($suppliers as $s)
                    <option value="{{ $s->id }}" {{ request('supplier_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label>المخزن</label>
            <select name="warehouse_id" class="form-control">
                <option value="">-- الكل --</option>
                @foreach($warehouses as $w)
                    <option value="{{ $w->id }}" {{ request('warehouse_id') == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label>من تاريخ</label>
            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
        </div>
        <div class="col-md-2">
            <label>إلى تاريخ</label>
            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">🔍 تصفية</button>
        </div>
    </form>

    {{-- 🔹 كروت الإحصائيات --}}
    <div class="row text-center mb-4">
        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h5>📄 عدد الفواتير</h5>
                    <h3>{{ $invoiceCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h5>📦 عدد المشاطيح</h5>
                    <h3>{{ $totalPallets }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h5>⚖️ الوزن الكلي (جم)</h5>
                    <h3>{{ number_format($totalWeight, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ جدول الفواتير --}}
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>رقم الفاتورة</th>
                    <th>التاريخ</th>
                    <th>المورد</th>
                    <th>المخزن</th>
                    <th>عدد الأصناف</th>
                    <th>الوزن الكلي</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $inv)
                    <tr>
                        <td>{{ $inv->invoice_number }}</td>
                        <td>{{ $inv->invoice_date }}</td>
                        <td>{{ $inv->supplier->name ?? '-' }}</td>
                        <td>{{ $inv->warehouse->name ?? '-' }}</td>
                        <td>{{ $inv->items->count() }}</td>
                        <td>{{ number_format($inv->items->sum('total_weight'), 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6">لا توجد بيانات حالياً.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 📤 أزرار التصدير --}}
    <div class="mt-4">
        <a href="{{ route('supply_invoices.report.excel', request()->query()) }}" class="btn btn-success">⬇️ تصدير Excel</a>
    </div>

    {{-- 📈 رسم بياني --}}
    <div class="mt-5">
        <h5 class="mb-3">توزيع الوزن حسب المورد</h5>
        <canvas id="supplierChart" height="100"></canvas>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('supplierChart').getContext('2d');

    const chartData = {
        labels: @json($invoices->pluck('supplier.name')->unique()->values()),
        datasets: [{
            label: 'إجمالي الوزن (جم)',
            data: @json($invoices->groupBy('supplier.name')->map(fn($g) => $g->flatMap->items->sum('total_weight'))->values()),
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderWidth: 1
        }]
    };

    new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 100 }
                }
            }
        }
    });
</script>
@endsection
