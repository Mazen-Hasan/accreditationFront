@extends('main')
@section('subtitle',' Edit User')
@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ URL::asset('css/dataTable.css') }}">

    <script src="{{ URL::asset('js/dataTable.js') }}"></script>
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
                            <a class="url-nav" href="{{route('users')}}">
                                <span>Users:</span>
                            </a>
                            {{$user['user_name']}} / Edit
                        </h4>
                        <form class="form-sample" id="edit-user-form" name="edit-user-form">
                            <input type="hidden" name="user_id" id="user_id" value="{{$user['user_id']}}">
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group col">
                                        <label>Name</label>
                                        <div class="col-sm-12">
                                            <input type="text" id="user_name" name="user_name" placeholder="enter name"
                                                   required="" value="{{$user['user_name']}}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group col">
                                        <label>Email</label>
                                        <div class="col-sm-12">
                                            <input type="email" id="email" name="email" placeholder="enter email"
                                                   required="" value="{{$user['email']}}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group col">
                                        <label>Role</label>
                                        <div class="col-sm-12">
                                            <select id="role_id" name="role_id" required="">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role['id'] }}"
                                                            @if ($role['id'] == $user['role_id'])
                                                            selected="selected"
                                                        @endif
                                                    >{{ $role['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                            </div>
                            <div class="col-sm-offset-2 col-sm-2">
                                <button type="submit" id="btn-save" value="create">Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="loader-modal" tabindex="-1" data-backdrop="static" data-keyboard="false"
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

        if ($("#edit-user-form").length > 0) {
            $("#edit-user-form").validate({
                submitHandler: function (form) {
                    $('#btn-save').html('Sending..');
                    $('#loader-modal').modal('show');
                    var url = "{{ route('userUpdate') }}";

                    $.ajax({
                        data: $('#edit-user-form').serialize(),
                        url: url,
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                            $('#loader-modal').modal('hide');
                            if(data['errCode']==1){
                                $('#edit-user-form').trigger("reset");
                                $('#loader-modal').modal('hide');
                                window.location.href = "{{ route('users')}}";
                            }
                            else{
                                $('#loader-modal').modal('hide');
                                $('#errorText').html(data['errMsg']);
                                $('#error-pop-up-modal').modal('show');
                            }
                        },
                        error: function (data) {
                            $('#edit-user-form').trigger("reset");
                            $('#loader-modal').modal('hide');
                            $('#errorText').html(data['errMsg']);
                            $('#error-pop-up-modal').modal('show');
                        }
                    });
                    $('#btn-save').html('Save');
                }
            })
        }
    </script>
@endsection
