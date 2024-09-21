<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'supplier_id', 'solution_id','status_id', 'company_id'];

    public function Supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id')->select([
            'id',
            'name',
        ]);
    }

    public function Solution()
    {
        return $this->belongsTo(Solution::class, 'solution_id')->select([
            'id',
            'name',
        ]);
    }

}
