<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Order extends Eloquent
{
    protected $collection = "orders";
    public function users()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function order_details()
    {
        return $this->hasMany('App\OrderDetail','order_id','_id');
    }
}
