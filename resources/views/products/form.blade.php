@csrf

<div class="mb-4">
    <label>الاسم:</label>
    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" class="w-full border p-2" required>
</div>

<div class="mb-4">
    <label>الكود:</label>
    <input type="text" name="code" value="{{ old('code', $product->code ?? '') }}" class="w-full border p-2" required>
</div>

<div class="mb-4">
    <label>التصنيف:</label>
    <select name="category_id" class="w-full border p-2">
        <option value="">-- اختر --</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label>وحدة القياس:</label>
    <select name="unit_id" class="w-full border p-2">
        <option value="">-- اختر --</option>
        @foreach($units as $unit)
            <option value="{{ $unit->id }}" {{ old('unit_id', $product->unit_id ?? '') == $unit->id ? 'selected' : '' }}>
                {{ $unit->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label>حد التنبيه (كمية):</label>
    <input type="number" name="alert_threshold" value="{{ old('alert_threshold', $product->alert_threshold ?? 0) }}" class="w-full border p-2">
</div>

<div class="mb-4">
    <label>الوصف:</label>
    <textarea name="description" class="w-full border p-2">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
    💾 حفظ
</button>
