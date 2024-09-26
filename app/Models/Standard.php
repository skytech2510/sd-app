<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standard extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'solution_id', 'status_id', 'manufacturer_id', 'collection_ids', 'colors', 'min_width', 'max_width', 'min_height', 'max_height', 'max_area', 'product_feature', 'NCM', 'CFOP', 'drives', 'optionals', 'supplies'];

    protected $casts = [
        'collection_ids' => 'array',
        'drives' => 'array',
        'optionals' => 'array',
        'supplies' => 'array',
        'colors' => 'array',
    ];
}
