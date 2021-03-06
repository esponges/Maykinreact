<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // $product = Product::first();

        // // dd($product);

        // \Cart::add(array(
        //     'id' => $product->id,
        //     'name' => $product->name,
        //     'price' => $product->price,
        //     'quantity' => 1,
        //     'attributes' => array(),
        //     'associatedModel' => $product
        // ));

        $products = \Cart::getContent();

        // return view('cart.index', compact('products'));
        return response()->json($products, 200);
    }

    public function add($id)
    {
        // dd(request()->server->get('QUERY_STRING'));
        // $id = request()->server->get('QUERY_STRING');
        // $product = Product::find($id);
        $product = Product::find($id);

        \Cart::add(array(
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'attributes' => array(),
            'associatedModel' => $product
        ));

        return response()->json(['added items to cart']);
        // return redirect('/');
    }

    public function destroy($id)
    {
        \Cart::remove($id);

        return response()->json(\Cart::getContent());
    }

    public function checkout()
    {
        // $product = Product::first();

        // // dd($product);

        // \Cart::add(array(
        //     'id' => $product->id,
        //     'name' => $product->name,
        //     'price' => $product->price,
        //     'quantity' => 1,
        //     'attributes' => array(),
        //     'associatedModel' => $product
        // ));
        $user = auth()->user();

        $cartTotal = \Cart::getTotal();
        // dd($cartTotal);

        if ($cartTotal != 0) {
            return view('cart.checkout', compact('user'));
        } else {
            return redirect ('/');
        }
    }
}
