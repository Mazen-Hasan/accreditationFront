@extends('main')
@section('subtitle','Company Accreditation Size')
@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ URL::asset('css/dataTable.css') }}">

    <script src="{{ URL::asset('js/dataTable.js') }}"></script>
@endsection
@section('custom_navbar')

                <li id="subsidiaries_nav" class="nav-item">
                     <a class="nav-link {{ str_contains( Request::route()->getName(),'subCompanies') =="1" ? "active" : "" }}"
                        href="{{ route('subCompanies',[$company_parent,$eventId]) }} ">
                         <i class="logout">
                             <img src="{{ asset('images/menu.png') }}" alt="My Sidries">
                         </i>
                         <span class="menu-title">Subsidiaries</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link {{ str_contains( Request::route()->getName(),'dataentrys') =="1" ? "active" : "" }}"
                        href="{{ route('dataentrys',[$company_parent,$eventId]) }}">
                         <i class="logout">
                             <img src="{{ asset('images/menu.png') }}" alt="Data Entry">
                         </i>
                         <span class="menu-title">Data Entry</span>
                     </a>
                 </li>
                 <li class="nav-item">
                    <a class="nav-link {{ str_contains( Request::route()->getName(),'focalpoints') =="1" ? "active" : "" }}"
                    href="{{ route('focalpoints') }}">
                        <i class="logout">
                            <img src="{{ asset('images/user_mng.png') }}" alt="Subsidiaries Accounts">
                        </i>
                        <span class="menu-title">Subsidiaries Accounts</span>
                    </a>
                </li>
@endsection
@section('content')
    <div class="content-wrapper">
        <br><br>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-content-md-center" style="height: 80px">
                            <div class="col-md-11">
                                <h4 class="card-title">
                                    <a class="url-nav" href="{{ route('company-admin') }} ">
                                        <span>My Events:</span>
                                    </a>
                                    <a class="url-nav" href="{{route('companyParticipants',[$companyId ,$eventId])}}">
                                        <span>{{$event_name}} / {{$company_name}}</span>
                                    </a>
                                     : Size ({{$company_size}}) /
                                    Accreditation Size Management
                                </h4>
                            </div>
                            <div class="col-md-1 align-content-md-center">
                                <input type="hidden" id="addable" value={{$addable}} />
                                <a href="javascript:void(0)" class="add-hbtn export-to-excel" title="Export to excel">
                                    <i>
                                        <img src="{{ asset('images/excel.png') }}" alt="Export to excel">
                                    </i>
                                </a>
                                @if($status == 0 && $event_status < 3)
                                    <a href="javascript:void(0)" id="add-new-post" class="add-hbtn" title="Add">
                                        <i>
                                            <img src="{{ asset('images/add.png') }}" alt="Add">
                                        </i>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover" id="laravel_datatable" style="text-align: center">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Accreditation Category</th>
                                    <th>Size</th>
                                    @if($status == 0)
                                        <th>Action</th>
                                    @endif
                                    @if($status != 0)
                                        <th>Status</th>
                                @endif
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="postCrudModal"></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="company_id" id="company_id" value="{{$companyId}}">
                    <input type="hidden" name="event_id" id="event_id" value="{{$eventId}}">
                    <input type="hidden" name="status" id="status" value="{{$status}}">
                    <input type="hidden" name="remaining_size" id="remaining_size" value="{{$remaining_size}}">
                    <input type="hidden" name="post_id" id="post_id" value="">
                    <input type="hidden" name="prev_size" id="prev_size" value="0">
                    <div class="form-group">
                        <label>Accreditation Category</label>
                        <div class="col-sm-12">
                            <select id="accredit_cat_id" name="accredit_cat_id" value="" required="">
                                @foreach ($accreditationCategorys as $accreditationCategory)
                                    <option value="{{ $accreditationCategory->key }}"
                                            @if ($accreditationCategory->key == 1)
                                            selected="selected"
                                        @endif
                                    >{{ $accreditationCategory->value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Size</label>
                        <div class="col-sm-12">
                            <input type="number" min="1" id="size" name="size" value="" required="">
                            <p style="color:red" id=error_message></p>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <button id="edit-size" value="create">Save
                        </button>
                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-element-confirm-modal" tabindex="-1" data-bs-backdrop="static"
         data-bs-keyboard="false" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmTitle"></h5>
                </div>
                <div class="modal-body">
                    <div>
                        <input type="hidden" id="curr_element_id">
                        <input type="hidden" id="curr_size" name="curr_size">
                        <input type="hidden" id="action_button">
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
	<div class="modal fade" id="error-pop-up-modal" tabindex="-1" data-bs-backdrop="static"
         data-bs-keyboard="false" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorTitle"></h5>
                </div>
                <div class="modal-body">
                    <div>
                        <label class="col-sm-12 confirm-text" id="errorText"></label>
                    </div>
                    <div class="row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4">
                            <button type="button" class="btn-cancel" data-dismiss="modal" id="btn-ok">OK
                            </button>
                        </div>
                        <div class="col-sm-4">
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
            var eventId = $('#event_id').val();
            var companyId = $('#company_id').val();
            var status = $('#status').val();
            $('#laravel_datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '../../subCompany-accreditation-size/' + companyId + '/' + eventId,
                    type: 'GET',
                },
                columns: [
                    {data: 'id', name: 'id', 'visible': false},
                    {data: 'name', name: 'name'},
                    {data: 'size', name: 'size'},
                    {data: 'action', name: 'action', orderable: false}
                ],
                order: [[0, 'desc']]
            });

            $('#add-new-post').click(function () {
                var addable = $('#addable').val();
                if(addable == 1){
                    remaining_size = parseInt($('#remaining_size').val());
                    if (remaining_size > 0) {
                        $('#error_message').text('');
                        $('#error_message').hide();
                        $('#btn-save').val("create-post");
                        $('#post_id').val('0');
                        $('#size').val('0');
                        $('#prev_size').val('0');
                        $('#postForm').trigger("reset");
                        $('#postCrudModal').html("Add New Accreditation Category");
                        $('#ajax-crud-modal').modal('show');
                        $('#accredit_cat_id').attr('disabled', false);
                    } else {
                        $('#errorTitle').html('Error: Max Size');
                        $('#errorText').html('you have reached accreditation categories max size');
                        $('#error-pop-up-modal').modal('show');
                    }
                }else{
                        $('#errorTitle').html('Adding Accreditation Category');
                        $('#errorText').html('you can not manage accrediation categories till Event Admin approval');
                        $('#error-pop-up-modal').modal('show');
                    }
            });
            $('body').on('click', '#edit-company-accreditation', function () {
                var post_id = $(this).data('id');
                $('#loader-modal').modal('show');
                //alert(post_id);
                $.get('../../companyAdminController/editCompanyAccreditSize/' + post_id, function (data) {
                    $('#loader-modal').modal('hide');
                    $('#name-error').hide();
                    $('#email-error').hide();
                    $('#postCrudModal').html("Edit Company Accreditation Category");
                    $('#btn-save').val("edit-post");
                    $('#error_message').text('');
                    $('#error_message').hide();
                    $('#ajax-crud-modal').modal('show');
                    $('#post_id').val(data.id);
                    $('#size').val(data.size);
                    $('#prev_size').val(data.size);
                    $('#accredit_cat_id').val(data.accredit_cat_id);
                    $('#accredit_cat_id').attr('disabled', 'disabled');
                })
            });

            $('body').on('click', '#delete-company-accreditation', function () {
                var post_id = $(this).data("id");
                var prev_size = $(this).data("size");
                $('#curr_size').val(prev_size);
                $('#confirmTitle').html('Delete Company Accreditation');
                $('#curr_element_id').val(post_id);
                $('#action_button').val('delete');
                var confirmText = 'Are you sure want to delete ?';
                $('#confirmText').html(confirmText);
                $('#delete-element-confirm-modal').modal('show');
            });
            $('body').on('click', '#edit-size', function () {
                $('#error_message').text('');
                $('#error_message').hide();
                var accredit_cat_id = $('#accredit_cat_id').val();
                var size = $('#size').val();
                var post_id = $('#post_id').val();
                var company_id = $('#company_id').val();
                var eventId = $('#event_id').val();
                var prevsize = parseInt($('#prev_size').val());
                var remaining_size = parseInt($('#remaining_size').val());
                remaining_size = remaining_size + prevsize;
                if (parseInt(size) > parseInt(remaining_size) || parseInt(size) <= 0) {
                    $('#error_message').text('Size has to be more than 0 and less than ' + remaining_size);
                    $('#error_message').show();
                } else {
                    $('#loader-modal').modal('show');
                    $.ajax({
                        type: "get",
                        url: "../../companyAdminController/storeCompanyAccrCatSize/" + post_id + "/" + accredit_cat_id + "/" + size + "/" + company_id + "/" + eventId,
                        success: function (data) {
                            $('#loader-modal').modal('hide');
                            $('#ajax-crud-modal').modal('hide');
                            var oTable = $('#laravel_datatable').dataTable();
                            oTable.fnDraw(false);
                            var remaining_size = parseInt($('#remaining_size').val());
                            var prev_size = parseInt($('#prev_size').val());
                            var inserted_size = data.size;
                            var new_remaining_size = remaining_size + prev_size - inserted_size;
                            $('#remaining_size').val(new_remaining_size);
                            $('#prev_size').val('0');
                            $('#error_message').text('');
                            $('#error_message').hide();
                        },
                        error: function (data) {
                            $('#loader-modal').modal('hide');
                            $('#ajax-crud-modal').modal('hide');
                            $('#errorTitle').html('Error: Duplicate accrediation category');
                            $('#errorText').html('Cant insert duplicate accreditation category size');
                            $('#error-pop-up-modal').modal('show');
                        }
                    });
                }
            });
            $('body').on('click', '#send-approval-request', function () {
                var post_id = $('#id').val();
                var company_id = $('#company_id').val();
                var eventId = $('#event_id').val();
                $('#confirmTitle').html('Approve Accreditation Category Sizes');
                $('#curr_element_id').val(post_id);
                $('#action_button').val('approve');
                var confirmText = "Are you sure you want to confirm Accreditation Category sizes?";
                $('#confirmText').html(confirmText);
                $('#delete-element-confirm-modal').modal('show');
            });
            $('#delete-element-confirm-modal button').on('click', function (event) {
                var $button = $(event.target);
                $(this).closest('.modal').one('hidden.bs.modal', function () {
                    if ($button[0].id === 'btn-yes') {
                        var post_id = $('#curr_element_id').val();
                        var action_button = $('#action_button').val();
                        if (action_button == 'delete') {
                            $('#loader-modal').modal('show');
                            $.ajax({
                                type: "get",
                                url: "../../companyAdminController/destroyCompanyAccreditCat/" + post_id,
                                success: function (data) {
                                    $('#loader-modal').modal('hide');
                                    var oTable = $('#laravel_datatable').dataTable();
                                    oTable.fnDraw(false);
                                    var remaining_size = parseInt($('#remaining_size').val());
                                    var inserted_size = parseInt($('#curr_size').val());
                                    var new_remaining_size = remaining_size + inserted_size;
                                    $('#remaining_size').val(new_remaining_size);
                                    $('#curr_size').val('0');
                                },
                                error: function (data) {
                                    $('#loader-modal').modal('hide');
                                    console.log('Error:', data);
                                }
                            });
                        }
                        if (action_button == 'approve') {
                            var company_id = $('#company_id').val();
                            var eventId = $('#event_id').val();
                            $('#loader-modal').modal('show');
                            $.ajax({
                                type: "get",
                                url: "../companyAdminController/sendApproval/" + company_id + "/" + eventId,
                                success: function (data) {
                                    $('#loader-modal').modal('hide');
                                    var oTable = $('#laravel_datatable').dataTable();
                                    $('#send-approval-request').hide();
                                    $('#add-new-post').hide();
                                    oTable.fnDraw(false);
                                },
                                error: function (data) {
                                    $('#loader-modal').modal('hide');
                                    console.log('Error:', data);
                                }
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
