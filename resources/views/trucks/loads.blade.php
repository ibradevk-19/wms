@extends('layouts.master')

@section('content')
<div class="container">
    <h1>📦 سجل الحمولات - الشاحنة: {{ $truck->plate_number }}</h1>
    <p><strong>السائق:</strong> {{ $truck->driver_name }} | <strong>الهاتف:</strong> {{ $truck->driver_phone }}</p>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>رقم الفاتورة</th>
                <th>تاريخ التوريد</th>
                <th>المخزن المستقبل</th>
                <th>تفاصيل الأصناف</th>
            </tr>
        </thead>
        <tbody>
            @foreach($truck->supplyInvoices as $invoice)
                <tr>
                    <td>{{ $invoice->invoice_number ?? $invoice->id }}</td>
                    <td>{{ $invoice->invoice_date }}</td>
                    <td>{{ $invoice->warehouse->name ?? '-' }}</td>
                    <td>
                        <ul>
                            @foreach($invoice->items as $item)
                                <li>
                                    {{ $item->product->name ?? 'غير معروف' }} -
                                    عدد المشاطيح: {{ $item->pallets_count }} -
                                    الوزن: {{ $item->total_weight }} كجم
                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
