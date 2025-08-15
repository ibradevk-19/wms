@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class="mb-4">➕ إضافة تصنيف جديد</h3>

    <form method="POST" action="{{ route('categories.store') }}">
        @csrf

        <div class="form-group mb-3">
            <label for="name">اسم التصنيف</label>
            <input type="text" name="name" id="name" class="form-control"
                   value="{{ old('name', $category->name ?? '') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="parent_id">التصنيف الأب (اختياري)</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="">بدون</option>
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}"
                        {{ old('parent_id', $category->parent_id ?? '') == $parent->id ? 'selected' : '' }}>
                        {{ $parent->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">💾 حفظ</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">↩️ إلغاء</a>
    </form>
</div>
@endsection
