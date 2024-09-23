<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status_id', 'company_id'];

    public function Optional()
    {
        return $this->hasMany(Optional::class);
    }

    public function Product()
    {
        return $this->hasMany(Product::class);
    }
}
