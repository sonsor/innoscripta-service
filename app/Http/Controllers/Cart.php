<?php

namespace App\Http\Controllers;

use App\Cart as Model;
use App\Item;
use App\Pizza;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\AssignOp\Mod;

class Cart extends Controller
{
    /**
     * @return
     */
    public function generate()
    {
        $cart = new Model();
        $id = $cart->generate()->id;
        return $cart->get($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function get(Request $request)
    {
        $cart = new Model();
        return $cart->get($request->id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function add(Request $request)
    {
        $body = json_decode($request->getContent(), TRUE);
        $item = new Item();
        return $item->add(
            $request->id,
            $body
        );
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        $body = json_decode($request->getContent(), TRUE);
        $item = new Item();
        return $item->edit(
            $request->id,
            $request->item,
            $body
        );
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function remove(Request $request)
    {
        $item = new Item();
        return $item->remove(
            $request->id,
            $request->item
        );
    }

    /**
     * @param Request $request
     * @return array
     */
    public function checkout(Request $request)
    {
        $cart = new Model();
        return $cart->place(
            $request->id
        );
    }
}
