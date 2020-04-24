<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Array_;

class Cart extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'sub_total',
        'discount',
        'shipping_cost',
        'total'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /**
     * @return mixed
     */
    public function generate()
    {
        return $this->create([
            'sub_total' => 0,
            'total' => 0
        ]);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function get(int $id)
    {
        return $this
            ->where('id', $id)
            ->with('items')
            ->first();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public static  function calculate(int $id)
    {
        $cart = Cart::find($id);

        /**
         * @var int $total
         */
        $total = 0;

        /**
         * @var ini $sub_total
         */
        $sub_total = 0;

        /**
         * @var int $discount
         */
        $discount = 0;

        /**
         * @var Array_$cart->items
         */
        foreach ($cart->items as $item) {
            $sub_total += ($item->price * $item->quantity);
        }

        $total = $sub_total - ($sub_total * $discount);

        $cart->sub_total = $sub_total;
        $cart->discount = 0;
        $cart->shipping_cost = 15.00;
        $cart->total = $total + $cart->shipping_cost;
        $cart->save();
        return $cart;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function place(int $id)
    {
        $cart = $this->find($id);
        $cart->complated = true;
        $cart->save;
        return true;
    }
}
