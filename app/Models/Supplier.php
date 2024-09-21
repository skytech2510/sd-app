<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'fantasy_name',
        'document',
        'ie',
        'zip_code',
        'address',
        'number_address',
        'complement_address',
        'region',
        'city_id',
        'state_id',
        'accountable_name',
        'phone',
        'cellphone',
        'email',
        'site',

        'status_id',
        'company_id',
    ];

    public function City()
    {
        return $this->belongsTo(Cidade::class, 'city_id')->select([
            'id',
            'nome',
        ]);
    }

    public function State()
    {
        return $this->belongsTo(Estado::class, 'state_id')->select([
            'id',
            'nome',
        ]);
    }
}
