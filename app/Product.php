<?php namespace App;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class Product extends Eloquent  
{
	protected $collection = 'product';

    protected $fillable=[
        'product_name','status','created'
    ];
}