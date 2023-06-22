<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Destination extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    protected $table = "destination";
    protected $dates = ['deleted_at'];

    public function origin()
    {
        return $this->belongsTo(Origin::class);
    }

}
