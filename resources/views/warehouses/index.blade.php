@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class="mb-3">📦 قائمة المخازن</h3>

    <table class="table table-bordered" id="warehouses-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>الاسم</th>
                <th>الرمز</th>
                <th>الموقع</th>
                <th>الحالة</th>
                <th>الطاقة</th>
                <th>الخيارات</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@push('scripts')
<script>
function deleteWarehouse(id) {
    if (confirm('هل أنت متأكد من حذف هذا المخزن؟')) {
        $.ajax({
            url: `/dashboard/warehouses/${id}`,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.status === 'success') {
                    alert(response.message);
                    $('#warehouses-table').DataTable().ajax.reload();
                }
            },
            error: function () {
                alert('حدث خطأ أثناء الحذف');
            }
        });
    }
}
</script>
<script>
$(function () {
    $('#warehouses-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('warehouses.data') }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'code', name: 'code' },
            { data: 'location', name: 'location' },
            { data: 'status', name: 'status' },
            { data: 'capacity', name: 'capacity' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Arabic.json'
        }
    });
});
</script>
@endpush
