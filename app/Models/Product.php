<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'price',
        'category',
    ];

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'invoice_product')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

}