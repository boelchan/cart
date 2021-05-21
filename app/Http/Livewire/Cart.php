<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Carbon;

class Cart extends Component
{
    public $tax = '0%';
    
    public function render()
    {
        $products = Product::latest()->get();
        
        $condition = new \Darryldecode\Cart\CartCondition([
            'name' => 'pajak',
            'type' => 'tax',
            'target' => 'total',
            'value' => $this->tax,
            'order' => 1
        ]);

        \Cart::session(Auth()->id())->condition($condition);
        $items = \Cart::session(Auth()->id())->getContent()->sortBy(function ($cart) {
            return $cart->attributes->get('added_at');
        });

        if (\Cart::isEmpty()) {
            $cartData = [];
        } else {
            foreach ($items as $item) {
                $cart[] = [
                    'rowId' => $item->id,
                    'name' => $item->name,
                    'qty' => $item->quantity,
                    'priceSingle' => $item->price,
                    'price' => $item->getPriceSum(),
                ];
            }
            $cartData = collect($cart);
        }

        $sub_total = \Cart::session(Auth()->id())->getSubTotal();
        $total = \Cart::session(Auth()->id())->getTotal();

        $newCondition = \Cart::session(Auth()->id())->getCondition('pajak');
        $pajak = $newCondition->getCalculatedValue($sub_total);

        $summary = [
            'total' => $total,
            'sub_total' => $sub_total,
            'pajak' => $pajak
        ];
        
        return view('livewire.cart', [
            'products' => $products,
            'carts' => $cartData,
            'summary' => $summary 
        ]);
    }

    public function addItem($id)
    {
        $rowId = 'Cart'.$id;
        $cart = \Cart::session(Auth()->id())->getContent();
        $cekItemId = $cart->whereIn('id', $rowId);

        if ($cekItemId->isNotEmpty()) {
            \Cart::session(Auth()->id())->update($rowId, [
                'quantity' => [
                    'relative' => true,
                    'value' => 1
                ]
            ]);
        } else {
            $product = Product::findOrFail($id);
            \Cart::session(Auth()->id())->add([
                'id' => 'Cart'.$product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'attributes' => [
                    'added_at' => Carbon::now()
                ]
            ]);
        }
    }

    public function enableTax()
    {
        $this->tax = '10%';
    }
    public function disableTax()
    {
        $this->tax = '0%';
    }

    public function increaseItem($rowId)
    {
        $id = str_replace('Cart', '', $rowId);
        $product = Product::findOrFail($id);

        $cart = \Cart::session(Auth()->id())->getContent();
        $cekItem = $cart->whereIn('id', $rowId);

        if ($product->qty == $cekItem[$rowId]->quantity) {
            session()->flash('error', 'Stok tidak cukup');
        } else {
            \Cart::session(Auth()->id())->update($rowId, [
                'quantity' => [
                    'relative' => true,
                    'value' => 1
                ]
            ]);
        }
        
    }

    public function decreaseItem($rowId)
    {
        $id = str_replace('Cart', '', $rowId);
        $product = Product::findOrFail($id);

        $cart = \Cart::session(Auth()->id())->getContent();
        $cekItem = $cart->whereIn('id', $rowId);

        if ($cekItem[$rowId]->quantity == 1) {
            \Cart::session(Auth()->id())->remove($rowId);
        } else {
            \Cart::session(Auth()->id())->update($rowId, [
                'quantity' => [
                    'relative' => true,
                    'value' => -1
                ]
            ]);
        }
        
    }

    public function removeItem($rowId)
    {
        \Cart::session(Auth()->id())->remove($rowId);
    }
}