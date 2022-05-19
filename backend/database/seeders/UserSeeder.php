<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@mm.identy.in',
                'password' => Hash::make('Admin@mm$1'),
                'is_admin' => 1,
                'login_id' => 'admin-1'
            ],
            [
                'name' => 'Organization',
                'contact_person' => 'Rito',
                'email' => 'org@mm.in',
                'password' => Hash::make('OrgTest'),
                'address' => 'ABCd',
                'contact_no' => '8167270301',
                'is_admin' => 0,
                'login_id' => 'org-test',
                'purchase_date' => date('Y-m-d'),
                'renewal_date' => date('Y-m-d', strtotime('+1 year')),
            ]
        ];
        
        foreach($users as $user){
            User::create($user);
        }
    }
}
