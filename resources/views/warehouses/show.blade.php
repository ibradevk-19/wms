@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class="mb-4">📦 تفاصيل المخزن: {{ $warehouse->name }}</h3>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>الرمز:</strong> {{ $warehouse->code }}</p>
            <p><strong>الموقع:</strong> {{ $warehouse->location ?? 'غير محدد' }}</p>
            <p><strong>الحالة:</strong> 
                @if($warehouse->status === 'active') ✅ نشط
                @elseif($warehouse->status === 'inactive') ⛔ غير نشط
                @else 🛠️ تحت الصيانة @endif
            </p>
            <p><strong>الطاقة الاستيعابية:</strong> {{ $warehouse->capacity ?? 'غير محددة' }}</p>
            <p><strong>ملاحظات:</strong> {{ $warehouse->notes ?? '-' }}</p>

            <div class="mt-3">
                <label><strong>نسبة الاستخدام الحالي:</strong></label>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {{ $capacityPercent }}%;" aria-valuenow="{{ $capacityPercent }}" aria-valuemin="0" aria-valuemax="100">
                        {{ $capacityPercent }}%
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- عرض العمليات القادمة لاحقًا --}}
    {{-- <h5 class="mb-3">📄 آخر التوريدات / الصرفيات</h5>
    <ul>
        <li>لم يتم ربط أي عمليات بعد.</li>
    </ul> --}}

    <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">↩️ رجوع</a>
</div>
@endsection
