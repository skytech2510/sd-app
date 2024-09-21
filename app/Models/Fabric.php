<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fabric extends Model
{
    use HasFactory;
    protected $fillable = ['fabric_cod', 'name', 'fabric_width', 'composition', 'colors', 'collection_id', 'cost', 'shipping', 'discount', 'ST', 'IPI', 'price', 'status_id', 'company_id'];

    public function Collection()
    {
        return $this->belongsTo(Collection::class, 'collection_id')->select([
            'id',
            'name',
        ]);
    }
}
