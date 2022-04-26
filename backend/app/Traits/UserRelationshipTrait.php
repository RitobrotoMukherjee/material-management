<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Traits;

use App\Models\User;

/**
 *
 * @author Ritobroto
 */
trait UserRelationshipTrait {
    public function user() {
        return $this->belongsTo(User::class);
    }
}
