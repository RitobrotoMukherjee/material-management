@extends('layouts.main')
@section('body')

@php
    $id = $data['detail']->id ?? '';
    $title = ($id != "") ? "Edit Organization" : "Add Organization";
    //dd($data['detail']->toArray());
@endphp
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $title }}</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>
                        </div>
                    
                        <form role="form" id="organization-add-edit" method="POST" action="{{ route('org.upsert') }}" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" class="form-control" id="organization-id" name="data[id]" value="{{ $data['detail']->id ?? old('data.id') }}">
                            <input type="hidden" class="form-control" id="is-admin" name="data[is_admin]" value="{{ __('0') }}">

                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class='row'>
                                            <div class="col-md-6 offset-md-3 alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="organizationName">Organization Name</label>
                                                <input type="text" class="form-control" id="organizationName" placeholder="Organization Name" name="data[name]" value="{{ $data['detail']->name ?? old('data.name') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="login_id">Login Id</label>
                                                <input type="text" class="form-control" id="login_id" placeholder="Login Id" name="data[login_id]" value="{{ $data['detail']->login_id ?? old('data.login_id') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control" id="email" placeholder="Email" name="data[email]" value="{{ $data['detail']->email ?? old('data.email') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address">Organization Address</label>
                                                <input type="text" class="form-control" id="address" placeholder="Organization Address" name="data[address]" value="{{ $data['detail']->address ?? old('data.address') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="contact_person">Contact Person Name</label>
                                                <input type="text" class="form-control" id="contact_person" placeholder="Contact Person Name" name="data[contact_person]" value="{{ $data['detail']->contact_person ?? old('data.contact_person') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="contact_no">Contact Number</label>
                                                <input type="text" class="form-control" id="contact_no" placeholder="Contact Number" name="data[contact_no]" value="{{ $data['detail']->contact_no ?? old('data.contact_no') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="purchase_date">Purchase Date</label>
                                                <input type="text" class="form-control" id="purchase_date" placeholder="Purchase Date" name="data[purchase_date]" value="{{ $data['detail']->purchase_date ?? old('data.purchase_date') }}" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="renewal_date">Renewal Date</label>
                                                <input type="text" class="form-control" id="renewal_date" placeholder="Renewal Date" name="data[renewal_date]" value="{{ $data['detail']->renewal_date ?? old('data.renewal_date') }}" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select class="form-control " id="status" name="data[status]" required>
                                                    <option value=''>Select Status</option>
                                                @foreach($data['status'] as $k => $v)
                                                    <option value='{{ $k }}' {{ (isset($data['detail']->status) && ($data['detail']->status == $k)) ? 'selected' : (old('data.status') == $k ? 'selected' : '') }}>{{ $v }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" id="password" placeholder="Password" name="data[password]" {{ isset($id) && ($id=='') ? 'required' : '' }}>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password_confirmation">Password Confirmation</label>
                                                <input type="text" class="form-control" id="password_confirmation" placeholder="Password Confirmation" name="data[password_confirmation]" {{ isset($id) && ($id=='') ? 'required' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @if(isset($data['detail']->image_link) && $data['detail']->image_link !== "")
                                        <div class='col-sm-4 col-xs-6 col-md-3 col-lg-2'>
                                            <img id="image-{{ $data['detail']->id }}" src="{{ asset($data['detail']->image_link) }}" width="100px">
                                        </div>
                                        @endif
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="image_link">App Top Image</label>
                                                <input type="file" class="form-control" id="image_link" placeholder="Browse App Top Image" name="data[image_link]" {{ (isset($data['detail']) && (is_null($data['detail']->image_link) || $data['detail']->image_link == "")) ? 'required' : '' }}>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 offset-md-3 text-center">
                                            @if($id == '')
                                            <button type="submit" class="btn btn-success btn-block">Save</button>
                                            @else
                                            <button type="submit" class="btn btn-primary btn-block">Update</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                    
            </div>
    </section>
</div>

    
@stop

@section('css')
    @parent
@stop

@section('scripts')
    @parent
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.js"></script>
    <script type="text/javascript">
        
        $(document).ready(function(){ 
            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' });
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' });
            //Money Euro
            $('[data-mask]').inputmask();
            $("#organization-add-edit").validate({
                rules:{
                    "data[name]": {
                        required: true,
                    },
                    "data[status]":{
                        required:true
                    }
                }
            });
        });
    </script>
@stop