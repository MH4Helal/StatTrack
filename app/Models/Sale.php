<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['datetime', 'customer_id', 'product_id', 'price', 'sales_agent_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function salesAgent()
    {
        return $this->belongsTo(SalesAgent::class);
    }
}
