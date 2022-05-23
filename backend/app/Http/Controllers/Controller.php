<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    protected $data, $today;
    
    public function __construct(){
        $this->today = date('Y-m-d');
    }
    
    protected function getStatus(): array {
        return [
            'Active' => 'Active',
            'In active' => 'In Active'
        ];
    }
}
