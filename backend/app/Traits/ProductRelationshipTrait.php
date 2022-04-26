<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Traits;

use App\Models\Product;

/**
 *
 * @author Ritobroto
 */
trait ProductRelationshipTrait {
    public function products() {
        return $this->hasMany(Product::class);
    }
}
