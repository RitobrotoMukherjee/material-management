<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Admin;

use App\Models\User;

/**
 * Description of OrganizationService
 *
 * @author Ritobroto
 */
class OrganizationService {

    public function getList(int $start, int $limit, $query = "", array $filters = []): array {
        $return['totalData'] = User::where('is_admin', 0)->count();
        $return['totalFiltered'] = $return['totalData'];
        $qry = User::where('is_admin', 0);
        if ($query != "") {
            $search = strtolower($query);

            $qry->whereRaw("LOWER(name) LIKE ?", ['%' . $search . '%'])
                    ->OrWhereRaw("LOWER(contact_no) LIKE ?", [$search . '%'])
                    ->OrWhereRaw("LOWER(email) LIKE ?", ['%' . $search . '%']);

            $return['totalFiltered'] = $qry->count();
        }
        if (isset($filters['purchase_from']) || isset($filters['renewal_from'])) {
            if(isset($filters['purchase_from'], $filters['purchase_to'])){
                $qry->whereBetween('purchase_date', [$this->returnDate($filters['purchase_from'])." 00:00:00", $this->returnDate($filters['purchase_to'])." 23:59:59"]);
            }
            if(isset($filters['renewal_from'], $filters['renewal_to'])){
                $qry->whereBetween('renewal_date', [$this->returnDate($filters['renewal_from'])." 00:00:00", $this->returnDate($filters['renewal_to'])." 23:59:59"]);
            }
            $return['totalFiltered'] = $qry->count();
        }

        $return['data'] = $qry->offset($start)->limit($limit)->orderBy('id', 'DESC')->get();

        return $return;
    }

    public function getDetailById(int $id): User {
        return User::findOrFail($id);
    }

    public function upsertData(array $inputs): User {
        if ($inputs['id'] == "") {
            $model = new User();
        }
        if ($inputs['id'] > 0) {
            $model = User::where('id', $inputs['id'])->firstOrfail();
        }
        foreach ($inputs as $k => $v) {
            if ($k == 'id' || $k == 'password_confirmation') {
                continue;
            }
            if($k == 'password' && $v != ""){
                $model->$k = \Hash::make($v);
            }
            if($k != 'password'){
                $model->$k = $v;
            }
        }
        $model->save();
        return $model;
    }
    
    private function returnDate($date): string {
        return date('Y-m-d', strtotime($date));
    }

}
