<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartElement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $cart = Cart::where('user_id', $userId)->where('closed', false)->first();
        return view('cart', ['cart' => $cart]);
    }

    public function addToCart(Request $request)
    {
        $userId = auth()->id();
        $productId = $request->product_id;
        $cart = Cart::firstOrCreate(['user_id' => $userId, 'closed' => false]);

        CartElement::firstOrCreate(['cart_id' => $cart->id, 'product_id' => $productId]);

        $countCartElement = 0;
        $totalPriceSale = 0;
        $totalPrice = 0;
        $totalBonus = 0;

        foreach ($cart->cartElements as $value) {
            $countCartElement += $value->quantity;
            $totalPriceSale += $value->product->priceSale * $value->quantity;
            $totalPrice += $value->product->price * $value->quantity;
            $totalBonus += $value->product->bonus * $value->quantity;
        }

        $priceDifference = $totalPrice - $totalPriceSale;
        $cart->total_discount = ($priceDifference / $totalPrice) * 100;
        $cart->total_price_sale = $totalPriceSale;
        $cart->total_price = $totalPrice;
        $cart->total_bonus = $totalBonus;
        $cart->save();

        return response($countCartElement);
    }

    public function plusQuantity(Request $request)
    {
        $userId = auth()->id();
        $cart = Cart::where('user_id', $userId)
            ->where('closed', false)->first();
        $productId = $request->product_id;

        $cartEl = $cart->cartElements()->where('product_id', $productId)->first();
        // dd($cartEl);
        if ($cartEl) {
            $cartEl->quantity += 1;
            $cartEl->save();
        }
        return response($this->countElement());
    }

    public function minusQuantity(Request $request)
    {
        $userId = auth()->id();

        $cart = Cart::where('user_id', $userId)
            ->where('closed', false)->first();
        $productId = $request->product_id;

        $cartEl = $cart->cartElements()
            ->where('product_id', $productId)
            ->first();

        if ($cartEl) {
            $cartEl->quantity -= 1;
            if (!$cartEl->quantity) {
                $cartEl->delete();
            } else {
                $cartEl->save();
            }
        }

        return response($this->countElement());
    }

    public function countElement()
    {
        $userId = auth()->id();
        $cart = Cart::where('user_id', $userId)
            ->where('closed', false)
            ->first();
        $countCartElement = null;
        foreach ($cart->cartElements as $value) {
            $countCartElement += $value->quantity;
        }
        return $countCartElement;
    }

    public function close(Request $request)
    {
        $userId = Auth::id();
        $writeOffBonuses = $request->query('write_off_bonuses');
        $cart = Cart::where('user_id', $userId)
            ->where('closed', false)
            ->first();
    
        if ($cart) {
            $user = Auth::user();
            if ($writeOffBonuses === 'true') {
                $cart->total_price_sale = $cart->total_price_sale - $user->bonus;
                $user->bonus = 0;
                $user->save();
            } else {
                $user->bonus = $cart->total_bonus;
                $user->save();
            }
    
            $cart->closed = true;
            $cart->save();
    
            return view('thanks', ['cart' => $cart]);
        } else {
            return redirect()->back()->with('error', 'Корзина не найдена или уже закрыта');
        }
    }
    
}
