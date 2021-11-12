<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class OrderDetail extends Eloquent
{
    protected $collection="order_detals";

    public function products()
    {
        return $this->belongsTo('App\Product','product_id','_id');
    }
    
}
