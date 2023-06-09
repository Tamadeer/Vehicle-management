<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SparePart extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    public function Warehouse():BelongsToMany
    {
        return $this->BelongsToMany(Warehouse::class,'warehouse_spare_part');
    }

    public function Bills():BelongsToMany{
        return $this->BelongsToMany(Bill::class,'bill_spare_part');
    }

    public function Report(): BelongsToMany
    {
        return $this->belongsToMany(SparePart::class,'report_spare_part');
    }
}
