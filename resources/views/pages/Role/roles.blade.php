@extends('main')
@section('subtitle',' Roles')
@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ URL::asset('css/dataTable.css') }}">

    <script src="{{ URL::asset('js/dataTable.js') }}"></script>
    <script src="{{ URL::asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('js/pdfmake.min.js') }}"></script>
@endsection
@section('content')
    <div class="content-wrapper">
        <br>
        <br>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-content-md-center" style="height: 80px">
                            <div class="col-md-10">
                                <h4 class="card-title">Roles</h4>
                            </div>
                        	<div class="col-md-1 align-content-md-center">
                                <div class="search-container">
                                    <input class="search expandright" id="search" type="text" placeholder="Search">
                                    <label class="search-button search-button-icon" for="search">
                                        <i class="icon-search"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-1 align-content-md-center">
                                <a href="javascript:void(0)" class="add-hbtn export-to-excel" title="Export to excel">
                                    <i>
                                        <img src="{{ asset('images/excel.png') }}" alt="Export to excel">
                                    </i>
                                </a>
                                <span class="dt-hbtn"></span>
                                <a href="javascript:void(0)" id="add-new-role" class="add-hbtn" title="Add">
                                    <i>
                                        <img src="{{ asset('images/add.png') }}" alt="Add">
                                    </i>
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover" id="laravel_datatable" style="text-align: center">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th style="color: black">Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="role-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form id="role-form" name="role-form" class="form-horizontal">
                        <input type="hidden" name="role_id" id="role_id">
                        <input type="hidden" id="mode" value="new">
                        <div class="form-group">
                            <label for="role_name">Role</label>
                            <div class="col-sm-12">
                                <input type="text" id="role_name" minlength="1" maxlength="30" name="role_name" placeholder="enter role name" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <div class="col-sm-12">
                                <select id="status" name="status" value="" required="">
                                    <option value="default">Please select status</option>
                                    <option value="1">Active</option>
                                    <option value="0">InActive</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <p id="error" style="margin-left: 30px;margin-bottom: 10px;color: red;"></p>
                        </div>
                        <div class="col-sm-12">
                            <button type="submit" id="btn-save">Save
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="role-confirm-modal" tabindex="-1" data-bs-backdrop="static"
         data-bs-keyboard="false" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmTitle"></h5>
                </div>
                <div class="modal-body">
                    <div>
                        <input type="hidden" id="curr_role_id">
                        <input type="hidden" id="mod_id">
                        <label class="col-sm-12 confirm-text" id="confirmText"></label>
                    </div>

                    <div class="row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4">
                            <button type="button" class="btn-cancel" data-dismiss="modal" id="btn-cancel">Cancel
                            </button>
                        </div>
                        <div class="col-sm-4">
                            <button type="button" data-dismiss="modal" id="btn-yes">Yes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- loader modal -->
    <div class="modal" id="loader-modal" tabindex="-1" data-backdrop="static" data-keyboard="false"
         role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 250px">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                        <div class="col-sm-10">
                            <label class="loading">
                                loading...
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- error modal -->
    <div class="modal fade" id="error-pop-up-modal" tabindex="-1" data-bs-backdrop="static"
         data-bs-keyboard="false" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorTitle">Error</h5>
                </div>
                <div class="modal-body">
                    <div>
                        <label class="col-sm-12 confirm-text" id="errorText"></label>
                    </div>
                    <div class="modal-footer">
                        <div class="col-sm-12">
                            <button type="submit" class="btn-cancel" data-dismiss="modal" value="create">OK
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#laravel_datatable').DataTable({
                dom: 'lBrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    title: 'Roles',
                    exportOptions: {
                        columns: [1, 2]
                    }
                }],

                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('RoleController.index') }}",
                    type: 'GET',
                },
                columns: [
                    {data: 'id', name: 'id', 'visible': false},
                    {data: 'name', name: 'name'},
                    {
                        data: 'status', render: function (data) {
                            if (data == 1) {
                                return "<p style='color: green'>Active</p>"
                            } else {
                                return "<p style='color: red'>InActive</p>"
                            }
                        }
                    },
                    {data: 'action', name: 'action', orderable: false}
                ],
                order: [[0, 'desc']]
            });

            $('.export-to-excel').click(function () {
                $('#laravel_datatable').DataTable().button('.buttons-excel').trigger();
            });

        	var oTable = $('#laravel_datatable').DataTable();

            $('#search').on('keyup', function () {
                oTable.search(this.value).draw();
            });

            $('#add-new-role').click(function () {
                $('#mode').val('new');
                $('#role_id').val('');
                $('#role_name').val('');
                $('#role-form').trigger("reset");
                $('#modal-title').html("New Role");
                $('#role-modal').modal('show');
            });

            $('body').on('click', '#delete-role', function () {
                var role_id = $(this).data("id");
                $('#confirmTitle').html('Delete role');
                $('#curr_role_id').val(role_id);
                $('#mod_id').val('2');
                var confirmText = 'Are you sure you want to delete this role?';
                $('#confirmText').html(confirmText);
                $('#role-confirm-modal').modal('show');
            });

            $('body').on('click', '#activate-role', function () {
                var role_id = $(this).data("id");
                $('#confirmTitle').html('Activate Role');
                $('#curr_role_id').val(role_id);
                $('#mod_id').val('1');
                var confirmText = "Are you sure want to activate this role?";
                $('#confirmText').html(confirmText);
                $('#role-confirm-modal').modal('show');
            });

            $('body').on('click', '#deActivate-role', function () {
                var role_id = $(this).data("id");
                $('#confirmTitle').html('Deactivate Role');
                $('#curr_role_id').val(role_id);
                $('#mod_id').val('0');
                var confirmText = "Are you sure want to deactivate this role?";
                $('#confirmText').html(confirmText);
                $('#role-confirm-modal').modal('show');
            });

            $('body').on('click', '#edit-role', function () {
                $('#mode').val('edit');
                var role_id = $(this).data('id');
                $('#loader-modal').modal('show');

                var url = "{{ route('roleGetById', ":role_id") }}";
                url = url.replace(':role_id', role_id);

                $.get( url, function (data) {
                })
                    .done(function (data) {
                        $('#loader-modal').modal('hide');

                        if (data['errCode'] == '1') {
                            $('#modal-title').html("Edit Role");
                            $('#role-modal').modal('show');
                            $('#role_id').val(data['data']['id']);
                            $('#role_name').val(data['data']['name']);
                            $('#status').val(data['data']['status']);
                        } else {
                            $('#errorText').html(data['errMsg']);
                            $('#error-pop-up-modal').modal('show');
                        }
                    })
                    .fail(function (data) {
                        $('#role-modal').modal('hide');
                        $('#loader-modal').modal('hide');
                    });
                $('#btn-save').html('Save');
            });

            $('#role-confirm-modal button').on('click', function (event) {
                var $button = $(event.target);
                $(this).closest('.modal').one('hidden.bs.modal', function () {
                    if ($button[0].id === 'btn-yes') {
                        $('#loader-modal').modal('show');
                        var role_id = $('#curr_role_id').val();
                        var mode_id = $('#mod_id').val();
                        var url ='';
                        if (mode_id === '0' || mode_id === '1'){
                            url = "{{ route('roleChangeStatus', [':role_id',':status_id']) }}";
                            url = url.replace(':role_id', role_id);
                            url = url.replace(':status_id', mode_id);
                        }
                        else{
                            url = "{{ route('roleDelete', ':role_id') }}";
                            url = url.replace(':role_id', role_id);
                        }

                        $.ajax({
                            type: "get",
                            url: url,
                            success: function (data) {
                                $('#loader-modal').modal('hide');
                                if (data['errCode'] == '1') {
                                    var oTable = $('#laravel_datatable').dataTable();
                                    oTable.fnDraw(false);
                                } else {
                                    $('#errorText').html(data['errMsg']);
                                    $('#error-pop-up-modal').modal('show');
                                }
                            },
                            error: function (data) {
                                $('#loader-modal').modal('hide');
                                $('#errorText').html(data['errMsg']);
                                $('#error-pop-up-modal').modal('show');
                            }
                        });
                    }
                });
            });
        });

        if ($("#role-form").length > 0) {
            $("#role-form").validate({
                rules: {
                    status: {valueNotEquals: "default"}
                },
                submitHandler: function (form) {
                    $('#btn-save').html('Sending..');
                    $('#loader-modal').modal('show');
                    var url = "{{ route('roleCreate') }}";
                    if($('#mode').val() === 'edit'){
                        url = "{{ route('roleUpdate') }}";
                    }
                    $.ajax({
                        data: $('#role-form').serialize(),
                        url: url,
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                            $('#loader-modal').modal('hide');
                            $('#role-form').trigger("reset");
                            $('#role-modal').modal('hide');
                            if(data['errCode']==1){
                                var oTable = $('#laravel_datatable').dataTable();
                                oTable.fnDraw(false);
                            }
                            else{
                                $('#errorText').html(data['errMsg']);
                                $('#error-pop-up-modal').modal('show');
                            }
                        },
                        error: function (data) {
                            $('#loader-modal').modal('hide');
                            $('#role-modal').modal('hide');
                            $('#errorText').html(data['errMsg']);
                            $('#error-pop-up-modal').modal('show');
                        }
                    });
                    $('#btn-save').html('Save');
                }
            })
        }
        jQuery.validator.addMethod("valueNotEquals",
            function (value, element, params) {
                return params !== value;
            }, " Please select a value");
    </script>
@endsection
