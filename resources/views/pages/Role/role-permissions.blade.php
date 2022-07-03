@extends('main')
@section('subtitle',' Role Permissions')
@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ URL::asset('css/dataTable.css') }}">

    <script src="{{ URL::asset('js/dataTable.js') }}"></script>

    <style>

    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <br>
        <br>
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card" style="border-radius: 20px">
                    <div class="card-body">
                        <h4 class="card-title">
                            <a class="url-nav" href="{{route('roles')}}">
                                <span>Roles:</span>
                            </a>
                            / Permissions
                        </h4>
                        <form class="form-horizontal" id="postForm" name="postForm">
                            <input style="visibility: hidden" name="event_id" id="event_id" value="{{$role_id}}">
                            <table style="border: #e3342f">
                                <tr>
                                    <th>Event</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Label text</label>
                                    </td>
                                    <td>
                                        <input type="checkbox" />
                                    </td>
                                </tr>
                            </table>
                            <br>
                        <div class="col-sm-offset-2 col-sm-2">
                            <button id="btn-save" value="create">Save
                            </button>
                        </div>
                    </div>
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
                        <div class="col-sm-8">
                            <button type="button" class="btn-cancel" data-dismiss="modal" id="btn-cancel">No, Manage
                                them myself
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
    <div class="modal fade" id="add-focal-point-modal" tabindex="-1"  data-backdrop="static" data-keyboard="false"
         role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >Add New Focal Point</h5>
                </div>
                <div class="modal-body">
                    <form class="form-sample" id="focaPointForm" name="focaPointForm">
                        <input type="hidden" id="entry_type" name="entry_type" value="instant" />
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group col">
                                        <label>Name</label>
                                        <div class="col-sm-12">
                                            <input type="text" id="name" name="name" placeholder="enter name"
                                                   minlength="1" maxlength="50" required=""/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group col">
                                        <label>Last Name</label>
                                        <div class="col-sm-12">
                                            <input type="text" id="last_name" name="last_name"
                                                   placeholder="enter last name" minlength="1" maxlength="50" required=""/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group col">
                                        <label>Telephone</label>
                                        <div class="col-sm-12">
                                            <input type="number" id="telephone" name="telephone"
                                                   placeholder="enter telephone" required=""/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group col">
                                        <label>Mobile</label>
                                        <div class="col-sm-12">
                                            <input type="number" id="mobile" name="mobile" placeholder="enter mobile"
                                                    required=""/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group col">
                                        <label>Account Name</label>
                                        <div class="col-sm-12">
                                            <input type="text" id="account_name" name="account_name"
                                                   placeholder="enter account name" minlength="1" maxlength="50" required=""/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group col">
                                        <label>Account Email</label>
                                        <div class="col-sm-12">
                                            <input type="email" id="account_email" name="account_email"
                                                   placeholder="enter account email" minlength="1" maxlength="50" required=""/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group col">
                                        <label>Account Password</label>
                                        <div class="row">
                                            <div class="col-sm-11">
                                                <input style="margin-left: 16px; width: 103%" type="password"
                                                       id="password" name="password" placeholder="enter password"
                                                       required=""/>
                                            </div>
                                            <div class="col-sm-1" id="eye">
                                                <i class="fa fa-eye-slash" id="togglePassword"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group col">
                                        <label>Status</label>
                                        <div class="col-sm-12">
                                            <select id="status" name="status" required="">
                                                <option value="default">Please select status</option>
                                                <option value="0">InActive</option>
                                                <option value="1">Active</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <button type="submit" style="width:200px" class="btn-cancel" data-dismiss="modal" id="btn-cancel"> cancel
                                </button>
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" id="btn-add-focal">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="event-organizer-copy-confirm-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="focalentryconfirmTitle"></h5>
                </div>
                <div class="modal-body">
                    <div>
                        <label class="col-sm-12 confirm-text" id="focalentryconfirmText"></label>
                        <input type="hidden" id="focal_point_name" value=""/>
                        <input type="hidden" id="focal_point_id" value=""/>
                    </div>
                    <div class="row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4">
                            <button type="button" class="btn-cancel" data-dismiss="modal" id="btn-gone">Cancel
                            </button>
                        </div>
                        <div class="col-sm-4">
                            <button type="button" data-dismiss="modal" id="btn-confirm">Yes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
        $('#btn-save').click(function () {
            $('#confirmTitle').html('Add Company');
            $('#curr_element_id').val(post_id);
            $('#action_button').val('approve');
            var confirmText = "Give permission to company admin to manage accreditation categories sizes?";
            $('#confirmText').html(confirmText);
            $('#delete-element-confirm-modal').modal('show');
        });

        $('#delete-element-confirm-modal button').on('click', function (event) {
            var $button = $(event.target);
            $(this).closest('.modal').one('hidden.bs.modal', function () {
                $('#need_management').val('0');
                if ($button[0].id === 'btn-yes') {
                    $('#need_management').val('1');
                }
                $("#postForm").submit();
            });
        });


        if ($("#postForm").length > 0) {
            $("#postForm").validate({
                rules: {
                    company_status: {valueNotEquals: "default"},
                    category: {valueNotEquals: "default"},
                    city: {valueNotEquals: "default"},
                    country: {valueNotEquals: "default"},
                    focal_point: {valueNotEquals: "default"}
                	//website: {urlValid: ""}
                },
                submitHandler: function (form) {
                	$('#loader-modal').modal('show');
                	$('#btn-save').prop('disabled', true);
                    $('#post_id').val('');
                    //var $eventid = $('#event_id').val();
                    var actionType = $('#btn-save').val();
                    $(":input,:hidden").serialize();
                    $.ajax({
                        data: $('#postForm').serialize(),
                        url: "{{ route('companyController.store') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                            $('#postForm').trigger("reset");
                            $('#ajax-crud-modal').modal('hide');
                            $('#btn-save').html('Done');
							$('#loader-modal').modal('hide');

                        },
                        error: function (data) {
                        	$('#loader-modal').modal('hide');
                            //console.log('Error:', data);
                            $('#btn-save').html('Save Changes');
                        }
                    });
                }
            })
        }

    	jQuery.validator.addMethod("urlValid",
            function (value, element, params) {
                var res = value.match(/^((http|https):\/\/)?www\.([A-z]+)\.([A-z]{2,})/);
                return res != null;
            }, " Please enter a valid URL");
    </script>
@endsection
