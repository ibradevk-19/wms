@extends('layouts.master')

@section('content')
<div class="container">
    <h3 class="mb-4">✏️ تعديل التصنيف: {{ $category->name }}</h3>

    <form method="POST" action="{{ route('categories.update', $category) }}">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="name">اسم التصنيف</label>
            <input type="text" name="name" id="name" class="form-control"
                   value="{{ old('name', $category->name) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="parent_id">التصنيف الأب (اختياري)</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="">بدون</option>
                @foreach($parents as $parent)
                    @if ($parent->id !== $category->id)
                        <option value="{{ $parent->id }}"
                            {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">💾 تحديث</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">↩️ إلغاء</a>
    </form>
</div>
@endsection
