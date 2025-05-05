<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Variation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'colour',
        'image_path',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
