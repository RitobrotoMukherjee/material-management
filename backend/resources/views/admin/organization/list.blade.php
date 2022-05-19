@extends('layouts.main')
@section('body')

@php 
// dd($filters);
@endphp

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Organizations</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Filters</h3>
                        </div>
                        <div class="card-body">
                            <form role="form" id="purchase-date-filter" method="GET" action="{{ route('org.list') }}" >
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="purchase_from_date">Purchase From Date</label>
                                            <input type="text" class="form-control" id="purchase_from_date" placeholder="purchase from date" name="data[purchase_from_date]" value="{{ old('data.purchase_from_date') }}" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask required >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="purchase_to_date">Purchase To Date</label>
                                            <input type="text" class="form-control" id="purchase_to_date" placeholder="purchase to date" name="data[purchase_to_date]" value="{{ old('data.purchase_to_date') }}" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <div class="form-group">
                                            <label for="purchase-date-btn">---</label>
                                            <button id="purchase-date-btn" type="submit" class="btn btn-primary btn-md form-control">Filter By Purchase Date</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form role="form" id="renewal-date-filter" method="GET" action="{{ route('org.list') }}" >
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="renewal_from_date">Renewal Start Date</label>
                                            <input type="text" class="form-control" id="renewal_from_date" placeholder="renewal from date" name="data[renewal_from_date]" value="{{ old('data.renewal_from_date') }}" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask required >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="renewal_to_date">Renewal End Date</label>
                                            <input type="text" class="form-control" id="renewal_to_date" placeholder="Renewal to date" name="data[renewal_to_date]" value="{{ old('data.renewal_to_date') }}" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <div class="form-group">
                                            <label for="renewal_date_btn">---</label>
                                            <button id="renewal_date_btn" type="submit" class="btn btn-primary btn-md form-control">Filter Renewal date</button>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="col-6 pull-right">
                                <a class='btn btn-warning btn-md card-title' href="{{ route('org.add.edit') }}" >Add Organization</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="data-list" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Login Id</th>
                                        <th>Organization Name</th>
                                        <th>Email</th>
                                        <th>Contact Person</th>
                                        <th>Contact No</th>
                                        <th>Renewal Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
@parent
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' });
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' });
        //Money Euro
        $('[data-mask]').inputmask();
        $('#data-list').DataTable({
            "processing": true,
            "serverSide": true,
            "buttons": ["excel", "colvis"],
            "responsive": true,
            "ordering": false,
            "language": {
                "searchPlaceholder": "Search Organization."
            },
            "ajax": {
                "url": "{{ route('org.server.list') }}",
                "dataType": "JSON",
                "type": "POST",
                "data": function ( d ) {
                    const filter = {
                        'purchase_from': "<?= $filters['purchase_from'] ?>",
                        'purchase_to': "<?= $filters['purchase_to'] ?>",
                        'renewal_from': "<?= $filters['renewal_from'] ?>",
                        'renewal_to': "<?= $filters['renewal_to'] ?>",
                    };
                    d.filters = filter;
                }
            },
            "columns": [
                {"data": "login_id"},
                {"data": "name"},
                {"data": "email"},
                {"data": "contact_person"},
                {"data": "contact_no"},
                {"data": "renewal_date"},
                {"data": "status"},
                {"data": "options"}
            ]
        }).buttons().container().appendTo('#client-data-list_wrapper .col-md-6:eq(0)');

        @if (request()->session()->get('error'))
        toastr.error("<?= request()->session()->get('error') ?>");
        @endif
        @if (request()->session()->get('message'))
        toastr.success("<?= request()->session()->get('message') ?>");
        @endif
    });
</script>
@endsection