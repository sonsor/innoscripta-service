<?php

namespace App\Http\Controllers;

use App\Pizza as Model;
use Illuminate\Http\Request;


class Pizza extends Controller
{
    /**
     * @return Model[]|\Illuminate\Database\Eloquent\Collection
     */
    public function list()
    {
        return Model::all();
    }

    /**
     * @param Model $pizza
     * @return Model
     */
    public function show(Model $pizza)
    {
        return $pizza;
    }
}
