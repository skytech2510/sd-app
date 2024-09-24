<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $table = 'partners';

    protected $fillable = [
        'name',
        'type',
        'CPF',
        'birthday',
        'gender',
        'CEP',
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
        'social_network',
        'bank',
        'agency',
        'account_number',
        'pix_key',
        'consultant',
    ];
}
