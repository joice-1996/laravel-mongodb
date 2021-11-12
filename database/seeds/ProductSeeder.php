<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date=date('Y-m-d');
        $time=date('H:i:s');
        $date=$date."T".$time;
        Product::insert([
            ['product_name'=>'Choclate',
            'status'=>1,
            'created'=>$date],
            ['product_name'=>'Watch',
            'status'=>1,
            'created'=>$date],
            ['product_name'=>'Soap',
            'status'=>1,
            'created'=>$date],
            ['product_name'=>'Dress',
            'status'=>1,
            'created'=>$date],
            ['product_name'=>'Chair',
            'status'=>1,
            'created'=>$date],
            ['product_name'=>'Fan',
            'status'=>1,
            'created'=>$date],
            ['product_name'=>'Bulb',
            'status'=>1,
            'created'=>$date],
        ]);
    }
}
