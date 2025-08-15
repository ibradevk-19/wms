<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'code',
        'category_id',
        'unit_id',
        'alert_threshold',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function stocks()
    {
        return $this->hasMany(ProductStock::class);
    }

    // رصيد الصنف في جميع المخازن
    public function totalStock()
    {
        return $this->stocks()->sum('quantity');
    }

    // رصيد الصنف في مخزن محدد
    public function stockInWarehouse($warehouse_id)
    {
        return $this->stocks()->where('warehouse_id', $warehouse_id)->value('quantity');
    }
}