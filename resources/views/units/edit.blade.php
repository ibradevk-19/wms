@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class="mb-4">✏️ تعديل وحدة: {{ $unit->name }}</h3>

    <form method="POST" action="{{ route('units.update', $unit) }}">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="name">اسم الوحدة</label>
            <input type="text" name="name" id="name" class="form-control"
                   value="{{ old('name', $unit->name) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="short_code">الرمز المختصر</label>
            <input type="text" name="short_code" id="short_code" class="form-control"
                   value="{{ old('short_code', $unit->short_code) }}">
        </div>

        <button type="submit" class="btn btn-primary">💾 تحديث</button>
        <a href="{{ route('units.index') }}" class="btn btn-secondary">↩️ إلغاء</a>
    </form>
</div>
@endsection
