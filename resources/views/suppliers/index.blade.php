@extends('layouts.master')

@section('content')
<div class="container">
    <h1 class="mb-4">📦 قائمة الموردين</h1>

    <a href="{{ route('suppliers.create') }}" class="btn btn-primary mb-3">➕ إضافة مورد جديد</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>الاسم</th>
                <th>الهاتف</th>
                <th>المدينة</th>
                <th>الحالة</th>
                <th>الخيارات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $supplier->phone }}</td>
                    <td>{{ $supplier->city }}</td>
                    <td>{{ $supplier->status == 'active' ? 'نشط' : 'غير نشط' }}</td>
                    <td>
                        <a href="{{ route('suppliers.show', $supplier) }}" class="btn btn-sm btn-info">عرض</a>
                        <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-sm btn-warning">تعديل</a>
                        <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    
</div>
@endsection
