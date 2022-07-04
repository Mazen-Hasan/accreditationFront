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
                            {{$role_name}} / Permissions
                        </h4>
                        <form class="form-horizontal" id="postForm" name="postForm">
                            <input type="hidden" name="role" id="h_role_id" value="{{$role_id}}">
                            <input type="hidden" name="permissions" id="permissions" value="{{$permissions}}">
                            <div class="card" style="border-radius: 20px; margin-top:20px" id="event-type-container">
                                <div class="card-body">
                                <h4 class="card-title"><i data-id="event-type" data-action="min" class="fas fa-minus hi" style="padding-right: 20px ;"></i>    Event Types</h4>
                                    <div class="row event-type-content">
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" data-id="35"  id="event_type_view" name="event_type_view"
                                                             >
                                                    <span style="padding: 13px;">View</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" data-id="36" id="event_type_add" name="event_type_add"
                                                             >
                                                    <span style="padding: 13px;">Create</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox"  data-id="37" id="event_type_edit" name="event_type_edit"
                                                             >
                                                    <span style="padding: 13px;">Edit</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" data-id="38" id="event_type_enable" name="event_type_enable"
                                                            >
                                                    <span style="padding: 13px;">Enable</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" data-id="39" id="event_type_disable" name="event_type_disable"
                                                            >
                                                    <span style="padding: 13px;">Disable</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card" style="border-radius: 20px; margin-top:20px" id="user-container">
                                <div class="card-body">
                                <h4 class="card-title"><i data-id="user" data-action="min" class="fas fa-minus hi" style="padding-right: 20px ;"></i>    System Users</h4>
                                    <div class="row user-content">
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" data-id="22" id="user-get-all" name="user-get-all"
                                                             >
                                                    <span style="padding: 13px;">View</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" data-id="20" id="user-add" name="user-add"
                                                             >
                                                    <span style="padding: 13px;">Create</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" data-id="21" id="user-edit" name="user-edit"
                                                             >
                                                    <span style="padding: 13px;">Edit</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox"  data-id="23" id="user-enable" name="user-enable"
                                                            >
                                                    <span style="padding: 13px;">Enable</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" data-id="24" id="user-disable" name="user-disable"
                                                            >
                                                    <span style="padding: 13px;">Disable</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card" style="border-radius: 20px; margin-top:20px" id="accreditation-category-container">
                                <div class="card-body">
                                <h4 class="card-title"><i data-id="accreditation-category" data-action="min" class="fas fa-minus hi" style="padding-right: 20px ;"></i>    Accreditation Category</h4>
                                    <div class="row accreditation-category-content">
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" data-id="40" id="accreditation_category_view" name="accreditation_category_view"
                                                             >
                                                    <span style="padding: 13px;">View</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" data-id="41" id="accreditation_category_add" name="accreditation_category_add"
                                                             >
                                                    <span style="padding: 13px;">Create</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" data-id="42" id="accreditation_category_edit" name="accreditation_category_edit"
                                                             >
                                                    <span style="padding: 13px;">Edit</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" data-id="43" id="accreditation_category_enable" name="accreditation_category_enable"
                                                            >
                                                    <span style="padding: 13px;">Enable</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" data-id="44" id="accreditation_category_disable" name="accreditation_category_disable"
                                                            >
                                                    <span style="padding: 13px;">Disable</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card" style="border-radius: 20px; margin-top:20px" id="company-type-container">
                                <div class="card-body">
                                <h4 class="card-title"><i data-id="company-type" data-action="min" class="fas fa-minus hi" style="padding-right: 20px ;"></i>    Company Types</h4>
                                    <div class="row company-type-content">
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" data-id="25" id="company-category-view" name="company-category-view">
                                                    <span style="padding: 13px;">View</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" data-id="26" id="company_category_add" name="company_category_add">
                                                    <span style="padding: 13px;">Create</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" data-id="27" id="company_category_edit" name="company_category_edit">
                                                    <span style="padding: 13px;">Edit</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" data-id="28" id="company_category_enable" name="company_category_enable"
                                                            >
                                                    <span style="padding: 13px;">Enable</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" data-id="29" id="company_category_disable" name="company_category_disable"
                                                            >
                                                    <span style="padding: 13px;">Disable</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card" style="border-radius: 20px; margin-top:20px" id="security-group-container">
                                <div class="card-body">
                                <h4 class="card-title"><i data-id="security-group" data-action="min" class="fas fa-minus hi" style="padding-right: 20px ;"></i>    Security Group</h4>
                                    <div class="row security-group-content">
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" data-id="30" id="security_categories_view" name="security_categories_view"
                                                             >
                                                    <span style="padding: 13px;">View</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" data-id="31" id="security_categories_add" name="security_categories_add"
                                                             >
                                                    <span style="padding: 13px;">Create</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox"  data-id="32" id="security_categories_edit" name="security_categories_edit"
                                                             >
                                                    <span style="padding: 13px;">Edit</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox"  data-id="33" id="security_category_enable" name="security_category_enable"
                                                            >
                                                    <span style="padding: 13px;">Enable</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox" data-id="34" id="security_category_disable" name="security_category_disable"
                                                            >
                                                    <span style="padding: 13px;">Disable</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card" style="border-radius: 20px; margin-top:20px" id="registraion-form-container">
                                <div class="card-body">
                                <h4 class="card-title">
                                    <i data-id="registraion-form" data-action="min" class="fas fa-minus hi" style="padding-right: 20px ;"></i>    Registration Form

                                </h4>
                                    <div class="row registraion-form-content">
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox"  data-id="47" id="registraion-form-get-all" name="registraion-form-get-all"
                                                             >
                                                    <span style="padding: 13px;">View</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox"  data-id="45"  id="registraion-form-create" name="registraion-form-create"
                                                             >
                                                    <span style="padding: 13px;">Create</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox"  data-id="46" id="registraion-form-edit" name="registraion-form-edit"
                                                             >
                                                    <span style="padding: 13px;">Edit</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox"  data-id="48" id="registraion-form-enable" name="registraion-form-enable"
                                                            >
                                                    <span style="padding: 13px;">Enable</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox"  data-id="49" id="registraion-form-disable" name="registraion-form-disable"
                                                            >
                                                    <span style="padding: 13px;">Disable</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox"  data-id="50" id="registraion-form-lock" name="registraion-form-lock"
                                                            >
                                                    <span style="padding: 13px;">Lock</span>
                                        </div>
                                    </div>
                                    <div class="row registraion-form-content">
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox"  data-id="51" id="registraion-form-unlock" name="registraion-form-unlock"
                                                            >
                                                    <span style="padding: 13px;">un-Lock</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card" style="border-radius: 20px; margin-top:20px" id="email-template-container">
                                <div class="card-body">
                                <h4 class="card-title"><i data-id="email-template" data-action="min" class="fas fa-minus hi" style="padding-right: 20px ;"></i>    Email template</h4>
                                    <div class="row email-template-content">
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox"  data-id="57" id="email-templates-get-all" name="email-templates-get-all"
                                                             >
                                                    <span style="padding: 13px;">View</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox"  data-id="59" id="email-template-edit" name="email-template-edit"
                                                             >
                                                    <span style="padding: 13px;">Edit</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card" style="border-radius: 20px; margin-top:20px" id="event-container">
                                <div class="card-body">
                                <h4 class="card-title"><i data-id="event" data-action="min" class="fas fa-minus hi" style="padding-right: 20px ;"></i>    Event</h4>
                                    <div class="row event-content">
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox"  data-id="4" id="event-view" name="event-view">
                                                    <span style="padding: 13px;">View</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox"  data-id="1" id="event-add" name="event-add">
                                                    <span style="padding: 13px;">Create</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox"  data-id="2" id="event-edit" name="event-edit">
                                                    <span style="padding: 13px;">Edit</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox"  data-id="3" id="event-complate" name="event-complate">
                                                    <span style="padding: 13px;">Finish Event</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox"  data-id="5" id="event-view-archived" name="event-view-archived">
                                                    <span style="padding: 13px;">View Archived</span>
                                        </div>
                                    </div>
                                    <div class="row event-content">
                                        <div class="col-md-4" style="display:inherit">
                                            <input type="checkbox" data-id="8" id="event-accreditation-category-list" name="event-accreditation-category-list">
                                                    <span style="padding: 13px;">Accreditation Category List</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox"  data-id="10" id="event-get-by-id" name="event-get-by-id">
                                                    <span style="padding: 13px;">Details</span>
                                        </div>
                                        <div class="col-md-2" style="display:inherit">
                                            <input type="checkbox"  data-id="6" id="event-admin-list" name="event-admin-list">
                                                    <span style="padding: 13px;">Admin List</span>
                                        </div>
                                        <div class="col-md-3" style="display:inherit">
                                            <input type="checkbox"  data-id="7" id="event-security-officer-list" name="event-security-officer-list">
                                                    <span style="padding: 13px;">Security Officer List</span>
                                        </div>
                                    </div>
                                    <div class="row event-content">
                                        <div class="col-md-4" style="display:inherit">
                                            <input type="checkbox"  data-id="9" id="event-security-group-list" name="event-security-group-list">
                                                    <span style="padding: 13px;">Security Group List</span>
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
        var perm_array = [];
        // var myJSON = '[{"id":"1", "slug":"event-add", "pre":0},{"id":"2", "slug":"event-edit", "pre":1},{"id":"3", "slug":"event-view", "pre":1},{"id":"4", "slug":"event-complete", "pre":1},{"id":"5", "slug":"event-admin-list", "pre":0}]';
        var myJSON = $('#permissions').val();
        var permissions_list = JSON.parse(myJSON);
        $(document).ready(function () {
            var len = permissions_list.length;
            var counter = 0;
            while(counter < len){
                var slug = permissions_list[counter].slug;
                $('#'+slug).prop('checked', true);
                if(permissions_list[counter].can_delete != 1){
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
            $('#loader-modal').modal('show');
            permission_ids = '';
            $('input[type=checkbox]:checked').each(function(index){
                permission_ids += ($(this).data("id")) + ',';
            });

            permission_ids = permission_ids.substring(0, permission_ids.length-1);

            var formData = new FormData();
            formData.append('role_id', $('#h_role_id').val());
            formData.append('permission_ids', permission_ids);

            $.ajax({
                url: "{{ route('updateRolePermissions') }}",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if(data['errCode']==1){
                        $('#postForm').trigger("reset");
                        $('#loader-modal').modal('hide');
                        $('#btn-save').html('Done');
                        window.location.href = "{{ route('roles')}}";
                    }
                    else{
                        $('#loader-modal').modal('hide');
                        $('#errorTitle').html('Error');
                        $('#errorText').html(data['errMsg']);
                        $('#error-pop-up-modal').modal('show');
                    }
                },
                error: function (data) {
                    $('#loader-modal').modal('hide');
                    $('#errorTitle').html('Error');
                    $('#errorText').html(data['errMsg']);
                    $('#error-pop-up-modal').modal('show');
                }
            });
        });

    </script>
@endsection
