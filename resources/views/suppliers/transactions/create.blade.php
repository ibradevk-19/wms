@extends('layouts.master')

@section('content')
<div class="container">
    <h2>➕ تسجيل تعامل جديد للمورد: {{ $supplier->name }}</h2>

    <form action="{{ route('suppliers.transactions.store', $supplier) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>نوع التعامل</label>
            <select name="type" class="form-control" required>
                <option value="">-- اختر النوع --</option>
                <option value="supply_invoice">فاتورة توريد</option>
                <option value="payment">دفعة مالية</option>
                <option value="note">ملاحظة</option>
            </select>
        </div>

        <div class="mb-3">
            <label>المرجع (اختياري)</label>
            <input type="text" name="reference" class="form-control">
        </div>

        <div class="mb-3">
            <label>الكمية </label>
            <input type="number" step="0.01" name="amount" class="form-control">
        </div>

        <div class="mb-3">
            <label>التاريخ</label>
            <input type="date" name="transaction_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>الوصف</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">💾 حفظ التعامل</button>
        <a href="{{ route('suppliers.show', $supplier) }}" class="btn btn-secondary">🔙 عودة</a>
    </form>
</div>
@endsection
