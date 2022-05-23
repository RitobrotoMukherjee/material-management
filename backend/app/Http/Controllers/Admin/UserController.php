<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Traits\PaginationTrait;
use Illuminate\Http\Request;
use App\Services\Admin\OrganizationService;
use App\Http\Requests\Admin\OrganizationRequest;
use App\Services\FileuploadService;

class UserController extends Controller
{
    use PaginationTrait;
    
    private $service, $fs;
    
    public function __construct(OrganizationService $sr, FileuploadService $fs) {
        parent::__construct();
        $this->service = $sr;
        $this->fs = $fs;
        $this->data['status'] = $this->getStatus();
    }
    
    public function getDetailById($id=""){
        if(isset($id) && $id > 0){
            $this->data['detail'] = $this->service->getDetailById($id);
        }
        return view('admin.organization.detail', ['data' => $this->data]);
    }
    
    public function upsert(OrganizationRequest $request) {
        $message = "Data Not Saved";
        $result = $this->service->upsertData($request->input('data'));
        if(isset($result->id) && $request->hasFile('data.image_link')) {
            $message = $this->uploadFiles($request->file(), $result->id);
        }
        return redirect()->route('org.list')->with('message', $message);
    }
    
    public function list(Request $req){
        $inputs = $req->only('data');
        
        $filter['purchase_from'] = (isset($inputs['data']['purchase_from_date']) && $inputs['data']['purchase_from_date'] !== "") ? date('Y-m-d', strtotime($inputs['data']['purchase_from_date'])) : null;
        $filter['purchase_to'] = (isset($inputs['data']['purchase_to_date']) && $inputs['data']['purchase_to_date'] !== "") ? date('Y-m-d', strtotime($inputs['data']['purchase_to_date'])) : null;
        $filter['renewal_from'] = (isset($inputs['data']['renewal_from_date']) && $inputs['data']['renewal_from_date'] !== "") ? date('Y-m-d', strtotime($inputs['data']['renewal_from_date'])) : null;
        $filter['renewal_to'] = (isset($inputs['data']['renewal_to_date']) && $inputs['data']['renewal_to_date'] !== "") ? date('Y-m-d', strtotime($inputs['data']['renewal_to_date'])) : null;
        
        return view('admin.organization.list', ['filters' => $filter]);
    }
    public function serverList(Request $request): string {
        $result = [];
        
        $filters = $this->getFilters($request->input('filters'));
        
        $organizations = $this->service->getList($request->input('start'), $request->input('length'), $request->input('search.value'), $filters);
        
        if(!empty($organizations)){
            $result = $this->getPaginationData($organizations['data']);
        }
        $json_data =  $this->getPaginationReturnData($request, $organizations['totalData'], $organizations['totalFiltered'], $result);
        return json_encode($json_data); 
    }
    
    private function getPaginationData(object $organizations): array {
        $result = [];
        foreach ($organizations as $organization)
            {
                if($organization->id === 1) {
                    continue;
                }
                $edit = route('org.add.edit', [$organization->id]);
                
                $nestedData['login_id'] = $organization->login_id;
                $nestedData['name'] = $organization->name;
                $nestedData['email'] = $organization->email;
                $nestedData['contact_person'] = $organization->contact_person;
                $nestedData['contact_no'] = $organization->contact_no;
                $nestedData['renewal_date'] = date('d/m/Y', strtotime($organization->renewal_date));
                $nestedData['status'] = $organization->status;
                $nestedData['options'] = "<a class='btn btn-xs btn-default text-primary mx-1 shadow' title='Edit' href='{$edit}' ><i class='fa fa-lg fa-fw fa-pen'></i></a>";
                $result[] = $nestedData;

            }
        return $result;
    }
    
    private function uploadFiles(array $inputs, int $id) : string {
        $message = "Data uploaded Without File";
        $directory_file = $this->fs->getFilePath('admin', 'organization', $id);
//        dd($directory_file);
        // * check has file and send to service
        // 1. delete file
        // 2. upload new file for the admin data
        // 3. Use Upload single file function
        if(isset($inputs['data']['image_link'])) {
            $return = $this->fs->uploadFile($inputs['data']['image_link'], $directory_file, 'User', $id, 'image_link');
            $message = $return['message'];
        }
        
        return $message;
    }
    
    private function getFilters(array $filters): array {
        foreach($filters as $key => $filter){
            if(!isset($filters[$key])){
                unset ($filters[$key]);
            }
        }
        return $filters;
    }
}
