@extends('layouts.master')

@section('content')
<div class="container">
    <h1 class="mb-4">🚛 قائمة الشاحنات</h1>

    <a href="{{ route('trucks.create') }}" class="btn btn-success mb-3">➕ إضافة شاحنة</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>رقم اللوحة</th>
                <th>اسم السائق</th>
                <th>الهاتف</th>
                <th>الحالة</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trucks as $truck)
                <tr>
                    <td>{{ $truck->plate_number }}</td>
                    <td>{{ $truck->driver_name }}</td>
                    <td>{{ $truck->driver_phone }}</td>
                    <td>{{ $truck->is_active ? 'نشطة' : 'غير نشطة' }}</td>
                    <td>
                        <a href="{{ route('trucks.edit', $truck) }}" class="btn btn-sm btn-primary">✏️ تعديل</a>
                       <a href="{{ route('trucks.loads', $truck->id) }}" class="btn btn-sm btn-info">📦 سجل الحمولات</a>

                        <form action="{{ route('trucks.destroy', $truck) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('هل أنت متأكد؟')" class="btn btn-sm btn-danger">🗑️ حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

   
</div>
@endsection
