<!-- resources/views/issue_invoices/show.blade.php -->

@extends('layouts.master')
@section('content')
<div class="container">
    <h2>📄 تفاصيل فاتورة الصرف #{{ $issueInvoice->issue_number }}</h2>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>التاريخ:</strong> {{ $issueInvoice->issue_date }}</p>
            <p><strong>المخزن:</strong> {{ $issueInvoice->warehouse->name }}</p>
            <p><strong>الجهة المصروف إليها:</strong> {{ $issueInvoice->issued_to_id ?? '-' }}</p>
            <p><strong>تم الإنشاء بواسطة:</strong> {{ $issueInvoice->creator->name }}</p>
            <p><strong>الحالة:</strong> {{ $issueInvoice->status }}</p>
            <p><strong>ملاحظات:</strong> {{ $issueInvoice->notes ?? '—' }}</p>
        </div>
    </div>

    <h5>📦 الأصناف المصروفة</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>الصنف</th>
                <th>الكمية</th>
                <th>الوحدة</th>
                <th>ملاحظات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($issueInvoice->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->unit->name }}</td>
                <td>{{ $item->remarks ?? '—' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('issue-invoices.index') }}" class="btn btn-secondary">🔙 العودة</a>
</div>
@endsection
