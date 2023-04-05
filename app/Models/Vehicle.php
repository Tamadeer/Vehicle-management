<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $guarded = ['id'];

       public function client():BelongsTo
    {
        return $this->belongsTo(Client::class ,'client_id');
    }

    public function Reports():HasMany
    {
        return $this->hasMany(Report::class);
    }
    public function inspection(): HasMany
    {
        return $this->hasMany(Inspection::class);
    }
    public function check()
    {
        $vec=Vehicle::all();
        foreach ($vec as $ve)
        foreach ($ve->inspection as $per)
        {
//            foreach ($ve->inspection as $per)
            if($ve->id==$per->Center->id)
                return true;
            else
                return false;
        }

    }
}
