@extends('layouts.master')
@section('content')
<div class="container">
    <h1>📦 فواتير الصرف</h1>

    <a href="{{ route('issue-invoices.create') }}" class="btn btn-primary mb-3">➕ إضافة فاتورة صرف</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>رقم الفاتورة</th>
                <th>التاريخ</th>
                <th>المخزن</th>
                <th>الجهة</th>
                <th>الحالة</th>
                <th>الخيارات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
            <tr>
                <td>{{ $invoice->issue_number }}</td>
                <td>{{ $invoice->issue_date }}</td>
                <td>{{ $invoice->warehouse->name }}</td>
                <td>{{ $invoice->issued_to_id ?? '-' }}</td>
                <td>{{ $invoice->status }}</td>
                <td>
                    <a href="{{ route('issue-invoices.show', $invoice) }}" class="btn btn-sm btn-info">عرض</a>
                    <!-- <a href="{{ route('issue-invoices.edit', $invoice) }}" class="btn btn-sm btn-warning">تعديل</a> -->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $invoices->links() }}
</div>
@endsection
