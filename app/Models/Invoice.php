<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    protected $fillable = [
        'client_name',
        'client_email',
        'total',
        'include_vat',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'invoice_product')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
 
}
