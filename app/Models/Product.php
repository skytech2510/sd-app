<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'supplier_code',
        'solution_id',
        'manufacturer_id',
        'supplier_id',
        'item',
        'color',
        'size',
        'NCM',
        'CFOP',
        'discount',
        'ST',
        'IPI',
        'freight',
        'markup',
        'price',
        'observation',
    ];

    public function Solution()
    {
        return $this->belongsTo(Solution::class);
    }

    public function Manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function Supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
