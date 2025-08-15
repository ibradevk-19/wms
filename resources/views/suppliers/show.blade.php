@extends('layouts.master')

@section('content')
<div class="container">
    <h1 class="mb-4">📄 تفاصيل المورد: {{ $supplier->name }}</h1>

    <ul class="list-group">
        <li class="list-group-item">رقم الهاتف: {{ $supplier->phone }}</li>
        <li class="list-group-item">البريد الإلكتروني: {{ $supplier->email }}</li>
        <li class="list-group-item">المدينة: {{ $supplier->city }}</li>
        <li class="list-group-item">الحالة: {{ $supplier->status == 'active' ? 'نشط' : 'غير نشط' }}</li>
    </ul>

    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary mt-3">🔙 عودة</a>
</div>

<hr class="my-4">
<h4>📑 سجل التعاملات</h4>
<a href="{{ route('suppliers.transactions.create', $supplier) }}" class="btn btn-sm btn-primary mb-3">
    ➕ تسجيل تعامل جديد
</a>
@if($supplier->transactions->count())
    <table class="table table-striped mt-2">
        <thead>
            <tr>
                <th>📆 التاريخ</th>
                <th>📋 النوع</th>
                <th>🔢 المرجع</th>
                <th> الكمية</th>
                <th>📝 الوصف</th>
                <th> الاجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($supplier->transactions as $trans)
                <tr>
                    <td>{{ $trans->transaction_date ? $trans->transaction_date : '-' }}</td>
                    <td>
                        @switch($trans->type)
                            @case('supply_invoice') فاتورة توريد @break
                            @case('payment') دفعة مالية @break
                            @case('note') ملاحظة @break
                        @endswitch
                    </td>
                    <td>{{ $trans->reference ?? '-' }}</td>
                    <td>{{ $trans->amount ? number_format($trans->amount, 2) : '-' }}</td>
                    <td>{{ $trans->description }}</td>
                    <td>
                        <a href="{{ route('supplier-transactions.edit', $trans) }}" class="btn btn-sm btn-warning">✏️ تعديل</a>
                        <form action="{{ route('supplier-transactions.destroy', $trans) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من الحذف؟')">🗑️ حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p class="text-muted">لا توجد تعاملات مسجلة لهذا المورد.</p>
@endif

@endsection
