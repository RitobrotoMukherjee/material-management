<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/**
 * Description of FileuploadService
 *
 * @author Ritobroto
 */
class FileuploadService {
    
    public function getFilePath(string $user_type, string $page, int $id, string $type=""): string {
        $main_path = storage_path('app/assets/'.$user_type);
//        dd($main_path);
        if (!File::exists($main_path.'/'.$page)) {
            File::makeDirectory($main_path.'/'.$page, 0777, true, true);
        }
        if (!File::exists($main_path.'/'.$page.'/'.$id)) {
            File::makeDirectory($main_path.'/'.$page.'/'.$id, 0777, true, true);
        }
        if ($type != "" && !File::exists($main_path.'/'.$page.'/'.$id.'/'.$type)) {
            File::makeDirectory($main_path.'/'.$page.'/'.$id.'/'.$type, 0777, true, true);
        }
        return 'assets\\'.$user_type.'\\'.$page.'\\'.$id.'\\'.$type;
    }
    
    public function uploadFile(object $file, string $file_path, string $parent_model_name, int $parent_id, string $field_name): array {
        $return['message'] = 'No file Uploaded'; 
        $model_name = "\\App\\Models\\".$parent_model_name;
        $model = $model_name::findOrFail($parent_id);
        
        if(isset($model->id) && !is_null($model->$field_name) && Storage::exists($model->$field_name)){
            Storage::delete($model->$field_name); // if already have an image delete it
            $return['message'] = 'Old File Deleted But Not Updated'; 
        }
        if(isset($model->id)){
            $image_link = $file->store($file_path);
            $model->$field_name = $image_link;
            $model->save();
            $return['message'] = 'Data & New File Updated'; 
            $return['model'] = $model; 
        }
        return $return;
    }
    
    public function uploadMultipleFiles(array $files, string $file_path, string $model_name, int $parent_id, string $parent_field_name, string $field_name) : string {
        $return = 'No files Uploaded'; 
        $model = "\\App\\Models\\".$model_name;
        /*
         * insert array
         * insert all data in DB using 1 query instead of multiple
         */
        $insert = [];
        foreach($files as $key => $file) {
            $insert[$key][$parent_field_name] = $parent_id;
            $insert[$key][$field_name] = $file->store($file_path);
            $insert[$key]['image_name'] = $file->getClientOriginalName();
            $insert[$key]['created_at'] = date('Y-m-d H:i:s');
            $insert[$key]['updated_at'] = date('Y-m-d H:i:s');
        }
        $result = $model::insert($insert);
        if($result){
            $return = count($insert).' Images Uploaded';
        }
        return $return;
    }
    
    public function deleteImage(string $model_name, int $id, string $field_name): string {
        $message = 'Cannot Delete File';
        $model =  "\\App\\Models\\".$model_name;
        
        $data = $model::findOrFail($id);
        if(isset($data->id) && !is_null($data->$field_name) && Storage::exists($data->$field_name)) {
            Storage::delete($data->$field_name); // if have an image delete it
            $message = "File Delete Successful, But Cannot Delete DB Record!!";
        }
        if(isset($data->id)){
            $model::destroy($id);
            $message = 'File & Corresponding Record Deleted Successfully';
        }
        return $message;
    }
}
