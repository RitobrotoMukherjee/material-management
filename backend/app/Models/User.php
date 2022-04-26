<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Traits\ProductRelationshipTrait;
use App\Traits\AccessorMutatorTrait;

class User extends Authenticatable {

    use HasApiTokens,
        HasFactory,
        Notifiable,
        ProductRelationshipTrait,
        AccessorMutatorTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'contact_person',
        'email',
        'address',
        'contact_no',
        'password',
        'is_admin',
        'login_id',
        'status',
        'purchase_date',
        'renewal_date',
        'image_link'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_admin' => 'boolean',
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    public function categories() {
        return $this->hasMany(Category::class);
    }

    protected function renewalDate(): Attribute {
        return Attribute::make(
                        get: fn($value) => date('Y-m-d', strtotime($value)),
                        set: fn($value) => date('Y-m-d', strtotime($value)),
        );
    }

    protected function purchaseDate(): Attribute {
        return Attribute::make(
                        get: fn($value) => date('Y-m-d', strtotime($value)),
                        set: fn($value) => date('Y-m-d', strtotime($value)),
        );
    }

}
