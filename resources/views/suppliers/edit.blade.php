@extends('layouts.master')

@section('content')
<div class="container">
    <h1 class="mb-4">تعديل مورد </h1>

    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>اسم المورد</label>
            <input type="text" name="name" value="{{ $supplier->name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>رقم الهاتف</label>
            <input type="text" name="phone" value="{{ $supplier->phone }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>البريد الإلكتروني</label>
            <input type="email" name="email" value="{{ $supplier->email }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>المدينة</label>
            <input type="text" name="city" value="{{ $supplier->city }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>الحالة</label>
            <select name="status" class="form-control">
                <option value="active" @if($supplier->status == 'active') selected  @endif >نشط</option>
                <option value="inactive"  @if($supplier->status == 'inactive') selected  @endif>غير نشط</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">💾 حفظ</button>
    </form>
</div>
@endsection
