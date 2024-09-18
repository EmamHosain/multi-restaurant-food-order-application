<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Product $product)
    {

        if(session()->has('coupon')){
            session()->forget('coupon');
        }

        $product_id = $product->id;

        $cart_items = session()->get('cart', []);
        if (isset($cart_items[$product_id])) {
            $cart_items[$product_id]['quantity']++;
        } else {

            $price = isset($product->discount_price) ? $product->discount_price : $product->price;
            $cart_items[$product_id] = [
                'id' => $product_id,
                'name' => $product->name,
                'image' => $product->image,
                'price' => $price,
                'quantity' => 1,
                'client_id' => $product->client_id,
            ];
        }

        session()->put('cart', $cart_items);

        $notification = [
            'alert-type' => 'success',
            'message' => 'Product added to cart successfully.'
        ];

        return redirect()->back()->with($notification);
    }


    public function updateCartQuantity(Request $request)
    {

        if(session()->has('coupon')){
            session()->forget('coupon');
        }
        $product_id = $request->input('id');
        $quanaity = $request->input('quantity');

        $cart = session()->get('cart', []);
        if (isset($cart[$product_id])) {
            $cart[$product_id]['quantity'] = $quanaity;
            session()->put('cart', $cart);

        }

        $notification = [
            'alert-type' => 'success',
            'message' => 'Quantity updated successfully.'
        ];

        return response()->json($notification);


    }


    public function removeFromCart(Request $request)
    {

        $product_id = $request->input('id');

        $cart = session()->get('cart', []);

        if (isset($cart[$product_id])) {
            unset($cart[$product_id]);
            session()->put('cart', $cart);
        }

        $notification = [
            'alert-type' => 'success',
            'message' => 'Cart item deleted successfully.'
        ];

        return response()->json($notification);
    }
}
