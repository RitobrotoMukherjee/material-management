<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Traits;

/**
 *
 * @author Ritobroto
 */
trait CategoryBelongsToRelationshipTrait {
    public function category() {
        return $this->belongsTo(Category::class);
    }
    
    public function department() {
        return $this->belongsTo(Department::class);
    }
}
