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
                            <input style="visibility: hidden" name="event_id" id="event_id" value="5">
                            <div class="card" style="border-radius: 20px; margin-top:20px" id="event-type-container">
                                <div class="card-body">
                                <h4 class="card-title"><i data-id="event-type" data-action="min" class="fas fa-minus hi" style="padding-right: 20px ;"></i>    Event Types</h4>
                                    <div class="row event-type-content">
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="event_type_view" name="event_type_view"
                                                             >
                                                    <span style="padding: 13px;">View</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="event_type_add" name="event_type_add"
                                                             >
                                                    <span style="padding: 13px;">Create</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="event_type_edit" name="event_type_edit"
                                                             >
                                                    <span style="padding: 13px;">Edit</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="event_type_enable" name="event_type_enable"
                                                            >
                                                    <span style="padding: 13px;">Enable</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="event_type_disable" name="event_type_disable"
                                                            >
                                                    <span style="padding: 13px;">Disable</sapn>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card" style="border-radius: 20px; margin-top:20px" id="user-container">
                                <div class="card-body">
                                <h4 class="card-title"><i data-id="user" data-action="min" class="fas fa-minus hi" style="padding-right: 20px ;"></i>    System Users</h4>
                                    <div class="row user-content">
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="user-get-all" name="user-get-all"
                                                             >
                                                    <span style="padding: 13px;">View</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="user-add" name="user-add"
                                                             >
                                                    <span style="padding: 13px;">Create</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="user-edit" name="user-edit"
                                                             >
                                                    <span style="padding: 13px;">Edit</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="user-enable" name="user-enable"
                                                            >
                                                    <span style="padding: 13px;">Enable</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="user-disable" name="user-disable"
                                                            >
                                                    <span style="padding: 13px;">Disable</sapn>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card" style="border-radius: 20px; margin-top:20px" id="accreditation-category-container">
                                <div class="card-body">
                                <h4 class="card-title"><i data-id="accreditation-category" data-action="min" class="fas fa-minus hi" style="padding-right: 20px ;"></i>    Accreditation Category</h4>
                                    <div class="row accreditation-category-content">
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="accreditation_category_view" name="accreditation_category_view"
                                                             >
                                                    <span style="padding: 13px;">View</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="accreditation_category_add" name="accreditation_category_add"
                                                             >
                                                    <span style="padding: 13px;">Create</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="accreditation_category_edit" name="accreditation_category_edit"
                                                             >
                                                    <span style="padding: 13px;">Edit</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="accreditation_category_enable" name="accreditation_category_enable"
                                                            >
                                                    <span style="padding: 13px;">Enable</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="accreditation_category_disable" name="accreditation_category_disable"
                                                            >
                                                    <span style="padding: 13px;">Disable</sapn>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card" style="border-radius: 20px; margin-top:20px" id="company-type-container">
                                <div class="card-body">
                                <h4 class="card-title"><i data-id="company-type" data-action="min" class="fas fa-minus hi" style="padding-right: 20px ;"></i>    Company Types</h4>
                                    <div class="row company-type-content">
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="company-category-view" name="company-category-view">
                                                    <span style="padding: 13px;">View</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="company_category_add" name="company_category_add">
                                                    <span style="padding: 13px;">Create</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="company_category_edit" name="company_category_edit">
                                                    <span style="padding: 13px;">Edit</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="company_category_enable" name="company_category_enable"
                                                            >
                                                    <span style="padding: 13px;">Enable</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="company_category_disable" name="company_category_disable"
                                                            >
                                                    <span style="padding: 13px;">Disable</sapn>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card" style="border-radius: 20px; margin-top:20px" id="security-group-container">
                                <div class="card-body">
                                <h4 class="card-title"><i data-id="security-group" data-action="min" class="fas fa-minus hi" style="padding-right: 20px ;"></i>    Security Group</h4>
                                    <div class="row security-group-content">
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="security_categories_view" name="security_categories_view"
                                                             >
                                                    <span style="padding: 13px;">View</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="security_categories_add" name="security_categories_add"
                                                             >
                                                    <span style="padding: 13px;">Create</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="security_categories_edit" name="security_categories_edit"
                                                             >
                                                    <span style="padding: 13px;">Edit</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="security_category_enable" name="security_category_enable"
                                                            >
                                                    <span style="padding: 13px;">Enable</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="security_category_disable" name="security_category_disable"
                                                            >
                                                    <span style="padding: 13px;">Disable</sapn>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card" style="border-radius: 20px; margin-top:20px" id="registraion-form-container">
                                <div class="card-body">
                                <h4 class="card-title"><i data-id="registraion-form" data-action="min" class="fas fa-minus hi" style="padding-right: 20px ;"></i>    Registeration Form</h4>
                                    <div class="row registraion-form-content">
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="registraion-form-get-all" name="registraion-form-get-all"
                                                             >
                                                    <span style="padding: 13px;">View</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="registraion-form-create" name="registraion-form-create"
                                                             >
                                                    <span style="padding: 13px;">Create</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="registraion-form-edit" name="registraion-form-edit"
                                                             >
                                                    <span style="padding: 13px;">Edit</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="registraion-form-enable" name="registraion-form-enable"
                                                            >
                                                    <span style="padding: 13px;">Enable</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="registraion-form-disable" name="registraion-form-disable"
                                                            >
                                                    <span style="padding: 13px;">Disable</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="registraion-form-lock" name="registraion-form-lock"
                                                            >
                                                    <span style="padding: 13px;">Lock</sapn>
                                        </div>
                                    </div>
                                    <div class="row registraion-form-content">
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="registraion-form-lock" name="registraion-form-unlock"
                                                            >
                                                    <span style="padding: 13px;">un-Lock</sapn>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card" style="border-radius: 20px; margin-top:20px" id="email-template-container">
                                <div class="card-body">
                                <h4 class="card-title"><i data-id="email-template" data-action="min" class="fas fa-minus hi" style="padding-right: 20px ;"></i>    Email template</h4>
                                    <div class="row email-template-content">
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="email-templates-get-all" name="email-templates-get-all"
                                                             >
                                                    <span style="padding: 13px;">View</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="email-template-edit" name="email-template-edit"
                                                             >
                                                    <span style="padding: 13px;">Edit</sapn>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card" style="border-radius: 20px; margin-top:20px" id="event-container">
                                <div class="card-body">
                                <h4 class="card-title"><i data-id="event" data-action="min" class="fas fa-minus hi" style="padding-right: 20px ;"></i>    Event</h4>
                                    <div class="row event-content">
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="event-view" name="event-view">
                                                    <span style="padding: 13px;">View</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="event-add" name="event-add">
                                                    <span style="padding: 13px;">Create</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="event-edit" name="event-edit">
                                                    <span style="padding: 13px;">Edit</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="event-complate" name="event-complate">
                                                    <span style="padding: 13px;">Finish Event</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="event-view-archived" name="event-view-archived">
                                                    <span style="padding: 13px;">View Archived</sapn>
                                        </div>
                                    </div>
                                    <div class="row event-content">
                                        <div class="col-md-4" style="display:inherit">
                                            <input type="checkbox" id="event-accreditation-category-list" name="event-accreditation-category-list">
                                                    <span style="padding: 13px;">Accreditation Category List</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="event-get-by-id" name="event-get-by-id">
                                                    <span style="padding: 13px;">Details</sapn>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" id="event-admin-list" name="event-admin-list">
                                                    <span style="padding: 13px;">Admin List</sapn>
                                        </div>
                                        <div class="col-md-3" style="display:inherit">
                                            <input type="checkbox" id="event-security-officer-list" name="event-security-officer-list">
                                                    <span style="padding: 13px;">Security Officer List</sapn>
                                        </div>
                                    </div>
                                    <div class="row event-content">
                                        <div class="col-md-4" style="display:inherit">
                                            <input type="checkbox" id="event-security-group-list" name="event-security-group-list">
                                                    <span style="padding: 13px;">Security Group List</sapn>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-offset-2 col-sm-2" style="margin-top: 30px;">
                                <button type="button" id="btn-save" value="create">Save
                                </button>
                            </div>
                        </form>
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
        var perm_array = [];
        var myJSON = '[{"id":"1", "slug":"event-add", "pre":0},{"id":"2", "slug":"event-edit", "pre":1},{"id":"3", "slug":"event-view", "pre":1},{"id":"4", "slug":"event-complete", "pre":1},{"id":"5", "slug":"event-admin-list", "pre":0}]';
        var permissions_list = JSON.parse(myJSON);
        $(document).ready(function () {
            var len = permissions_list.length;
            var counter = 0;
            while(counter < len){
                var slug = permissions_list[counter].slug;
                $('#'+slug).prop('checked', true);
                if(permissions_list[counter].pre != 0){
                    $('#'+slug).attr("disabled", true);
                }
                counter++;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
        $('.hi').click(function () {
            action = $(this).data('action');
            if(action == 'min'){
                data_id = $(this).data('id');
                id = '#'+ data_id + '-container';
                $('.'+ data_id + '-content').hide();
                $(id).css({'height':'10%'});
                $(this).data('action','max');
                $(this).removeClass('fas fa-minus');
                $(this).addClass('fas fa-plus');
            }else{
                data_id = $(this).data('id');
                id = '#'+ data_id + '-container';
                $('.'+ data_id + '-content').show();
                $(id).css({'height':'100%'});
                $(this).data('action','min');
                $(this).removeClass('fas fa-plus');
                $(this).addClass('fas fa-minus');
            }
            //alert(action);
        });


        $('#btn-save').click(function () {
            perm_array = [];
            $('input[type=checkbox]:checked').each(function(index){
            //part where the magic happens
            perm_array.push($(this).attr("name"));
            console.log($(this).attr("name"));
            });
        });

        // $('#delete-element-confirm-modal button').on('click', function (event) {
        //     var $button = $(event.target);
        //     $(this).closest('.modal').one('hidden.bs.modal', function () {
        //         $('#need_management').val('0');
        //         if ($button[0].id === 'btn-yes') {
        //             $('#need_management').val('1');
        //         }
        //         $("#postForm").submit();
        //     });
        // });


        // if ($("#postForm").length > 0) {
        //     $("#postForm").validate({
        //         rules: {
        //             company_status: {valueNotEquals: "default"},
        //             category: {valueNotEquals: "default"},
        //             city: {valueNotEquals: "default"},
        //             country: {valueNotEquals: "default"},
        //             focal_point: {valueNotEquals: "default"}
        //         	//website: {urlValid: ""}
        //         },
        //         submitHandler: function (form) {
        //         	$('#loader-modal').modal('show');
        //         	$('#btn-save').prop('disabled', true);
        //             $('#post_id').val('');
        //             //var $eventid = $('#event_id').val();
        //             var actionType = $('#btn-save').val();
        //             $(":input,:hidden").serialize();
        //             $.ajax({
        //                 data: $('#postForm').serialize(),
        //                 url: "{{ route('companyController.store') }}",
        //                 type: "POST",
        //                 dataType: 'json',
        //                 success: function (data) {
        //                     $('#postForm').trigger("reset");
        //                     $('#ajax-crud-modal').modal('hide');
        //                     $('#btn-save').html('Done');
		// 					$('#loader-modal').modal('hide');

        //                 },
        //                 error: function (data) {
        //                 	$('#loader-modal').modal('hide');
        //                     //console.log('Error:', data);
        //                     $('#btn-save').html('Save Changes');
        //                 }
        //             });
        //         }
        //     })
        // }

    	// jQuery.validator.addMethod("urlValid",
        //     function (value, element, params) {
        //         var res = value.match(/^((http|https):\/\/)?www\.([A-z]+)\.([A-z]{2,})/);
        //         return res != null;
        //     }, " Please enter a valid URL");
    </script>
@endsection
