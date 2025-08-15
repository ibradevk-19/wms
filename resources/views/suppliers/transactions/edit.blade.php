@extends('layouts.master')

@section('content')
<div class="container">
    <h2>✏️ تعديل تعامل المورد: {{ $supplier->name }}</h2>

    <form action="{{ route('supplier-transactions.update', $transaction) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>نوع التعامل</label>
            <select name="type" class="form-control" required>
                <option value="supply_invoice" {{ $transaction->type == 'supply_invoice' ? 'selected' : '' }}>فاتورة توريد</option>
                <option value="payment" {{ $transaction->type == 'payment' ? 'selected' : '' }}>دفعة مالية</option>
                <option value="note" {{ $transaction->type == 'note' ? 'selected' : '' }}>ملاحظة</option>
            </select>
        </div>

        <div class="mb-3">
            <label>المرجع</label>
            <input type="text" name="reference" value="{{ $transaction->reference }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>الكمية</label>
            <input type="number" step="0.01" name="amount" value="{{ $transaction->amount }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>التاريخ</label>
            <input type="date" name="transaction_date" value="{{ $transaction->transaction_date }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>الوصف</label>
            <textarea name="description" class="form-control" rows="3">{{ $transaction->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">💾 تحديث</button>
        <a href="{{ route('suppliers.show', $supplier) }}" class="btn btn-secondary">🔙 عودة</a>
    </form>
</div>
@endsection
