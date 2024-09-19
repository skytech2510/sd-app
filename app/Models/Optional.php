<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
class Optional extends Model
{
    use HasFactory;
    protected $table = 'optionals';
    protected $fillable = ["name", "status_id", "observation", "annotation", "manufacturer_id", "price"];
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }
}
