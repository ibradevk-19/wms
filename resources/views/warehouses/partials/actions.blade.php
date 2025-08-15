<div class="btn-group">


    <a href="{{ route('warehouses.show', $row->id) }}" class="btn btn-sm btn-info">عرض</a>
    <a href="{{ route('warehouses.edit', $row->id) }}" class="btn btn-warning btn-sm">تعديل</a>
    <a href="{{ route('warehouses.items', $row->id) }}" class="btn btn-sm btn-info">الاصناف</a>

    <button onclick="deleteWarehouse({{ $row->id }})" class="btn btn-sm btn-danger">حذف</button>
</div>
