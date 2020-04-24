<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cart;

class Item extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'pizza_id',
        'cart_id',
        'quantity',
        'price'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * @param int $cart_id
     * @param array $data
     * @return mixed
     */
    public function add(int $cart_id, array $data)
    {
        $pizza = Pizza::findOrFail($data['product_id']);
        $id = $cart_id . '' . $data['product_id'];

        $item = Item::find($id);

        if ($item) {
            return $this->edit(
                $cart_id,
                $id,
                [
                    'quantity' => $item->quantity + $data['quantity']
                ]
            );
        }

        $this->create([
            'id' => $id,
            'pizza_id' => $data['product_id'],
            'cart_id' => $cart_id,
            'quantity' => $data['quantity'],
            'price' => $pizza->price
        ]);
        return Cart::calculate($cart_id);
    }

    /**
     * @param int $cart_id
     * @param int $item_id
     * @param array $data
     * @return mixed
     */
    public function edit(int $cart_id, int $item_id, array $data)
    {
        $item = $this->find($item_id);
        $item->quantity = $data['quantity'];
        $item->save();
        return Cart::calculate($cart_id);
    }

    /**
     * @param int $cart_id
     * @param int $item_id
     * @return mixed
     */
    public function remove(int $cart_id, int $item_id)
    {
        $item = $this->find($item_id);
        if ($item) {
            $item->delete();
        }
        return Cart::calculate($cart_id);
    }
}
