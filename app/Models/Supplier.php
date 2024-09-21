<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Optional extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    protected $fillable = [
        'name',
        'fantansy_name',
        'document',
        'ie',
        'zip_code',
        'address',
        'number_address',
        'complement_address',
        'state_id',
        'city_id',
        'region',
        'accountable_name',
        'phone',
        'cellphone',
        'email',
        'site',
        'status_id',
        'company_id',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }
}
