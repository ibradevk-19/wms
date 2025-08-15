{{-- مهم: لا @extends ولا @section هنا --}}
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>Supply Invoices Report</title>
    <style>
        /* اختياري: تنسيق بسيط inline فقط */
        table { border-collapse: collapse; width: 100%; }
        th, td { border:1px solid #000; padding:6px; }
        th { background:#eee; }
    </style>
</head>
<body>
<table>
    <thead>
        <tr>
            <th>رقم الفاتورة</th>
            <th>التاريخ</th>
            <th>المورد</th>
            <th>المخزن</th>
            <th>عدد الأصناف</th>
            <th>الوزن الكلي (جم)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($invoices as $inv)
            <tr>
                <td>{{ $inv->invoice_number }}</td>
                <td>{{ $inv->invoice_date }}</td>
                <td>{{ $inv->supplier->name ?? '' }}</td>
                <td>{{ $inv->warehouse->name ?? '' }}</td>
                <td>{{ $inv->items->count() }}</td>
                {{-- تأكد أن القيمة رقمية بدون فواصل أو HTML --}}
                <td>{{ (float) $inv->items->sum('total_weight') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
