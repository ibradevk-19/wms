@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="mb-4">📄 تفاصيل فاتورة التوريد: {{ $invoice->invoice_number }}</h2>

    {{-- بيانات الفاتورة --}}
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>تاريخ الفاتورة:</strong> {{ $invoice->invoice_date }}</p>
            <p><strong>المورد:</strong> {{ $invoice->supplier->name ?? '-' }}</p>
            <p><strong>الشاحنة:</strong> {{ $invoice->truck->plate_number ?? '-' }}</p>
            <p><strong>المخزن:</strong> {{ $invoice->warehouse->name ?? '-' }}</p>
            <p><strong>ملاحظات:</strong> {{ $invoice->notes ?? '—' }}</p>
        </div>
    </div>

    {{-- جدول الأصناف --}}
    <div class="table-responsive">
        <h5 class="mb-3">📦 الأصناف الموردة:</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>الصنف</th>
                    <th>الوحدة</th>
                    <th>عدد المشاطيح</th>
                    <th>الكمية لكل مشطاح</th>
                    <th>الإجمالي</th>
                    <th>الوزن الكلي (جم)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->unit->name }}</td>
                        <td>{{ $item->pallets_count }}</td>
                        <td>{{ $item->quantity_per_pallet }}</td>
                        <td>{{ $item->total_quantity }}</td>
                        <td>{{ $item->total_weight}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- زر رجوع وطباعة --}}
    <div class="mt-4">
        <a href="{{ route('supply_invoices.index') }}" class="btn btn-secondary">🔙 رجوع</a>
        {{-- زر الطباعة / التصدير سنفعله لاحقًا --}}
        {{-- <a href="{{ route('supply_invoices.export_pdf', $invoice) }}" class="btn btn-success">🖨️ طباعة PDF</a> --}}
    </div>
</div>
@endsection
