<?php
/**
 * Created by PhpStorm.
 * User: 姚以清
 * Date: 2018/9/28
 * Time: 15:06
 */

namespace App\Http\Controllers\Mi;

use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function order()
    {
        return view('mi.order');
    }

    public function cart()
    {
        return view('mi.cart');
    }
}