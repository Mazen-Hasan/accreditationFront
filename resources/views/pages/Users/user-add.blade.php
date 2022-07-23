@extends('main')
@section('subtitle',' Add User')
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
                            / New</h4>
                        <form class="form-sample" id="user-new-form" name="user-new-form">
                            <input type="hidden" name="post_id" id="post_id">
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group col">
                                        <label>Name</label>
                                        <div class="col-sm-12">
                                            <input type="text" id="user_name" name="user_name" placeholder="enter name"
                                                   required=""/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group col">
                                        <label>Email</label>
                                        <div class="col-sm-12">
                                            <input type="email" id="email" name="email" placeholder="enter email"
                                                   required=""/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group col">
                                        <label>Password</label>
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
                                        <label>Confirm Password</label>
                                        <div class="row">
                                            <div class="col-sm-11">
                                                <input style="margin-left: 16px; width: 103%" type="password"
                                                       id="confirm_password" name="confirm_password"
                                                       placeholder="confirm password" required=""/>
                                            </div>
                                            <div class="col-sm-1" id="eye">
                                                <i class="fa fa-eye-slash" id="togglePasswordConfirm"></i>
                                            </div>
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
                                                    >{{ $role['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-12">
                                        </div>
                                    </div>
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

            $('#togglePassword').click(function () {
                var type = $('#password').attr('type') === 'password' ? 'text' : 'password';
                $('#password').attr('type', type);
                if (type === 'text') {
                    $('#togglePassword').removeClass('fa fa-eye-slash');
                    $('#togglePassword').addClass('fa fa-eye');
                } else {
                    $('#togglePassword').removeClass('fa fa-eye');
                    $('#togglePassword').addClass('fa fa-eye-slash');
                }
            });

            $('#togglePasswordConfirm').click(function () {
                var type = $('#confirm_password').attr('type') === 'password' ? 'text' : 'password';
                $('#confirm_password').attr('type', type);
                if (type === 'text') {
                    $('#togglePasswordConfirm').removeClass('fa fa-eye-slash');
                    $('#togglePasswordConfirm').addClass('fa fa-eye');
                } else {
                    $('#togglePasswordConfirm').removeClass('fa fa-eye');
                    $('#togglePasswordConfirm').addClass('fa fa-eye-slash');
                }
            });
        });

        if ($("#user-new-form").length > 0) {
            $("#user-new-form").validate({

                rules: {
                    confirm_password: {
                        equalTo: '#password'
                    }
                },

                messages: {
                    confirm_password: {
                        equalTo: "Please enter the same password"
                    }
                },

                submitHandler: function (form) {
                    $('#btn-save').html('Sending..');
                    $('#loader-modal').modal('show');

                    $.ajax({
                        data: $('#user-new-form').serialize(),
                        url: "{{ route('userSave') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                            $('#event-new-form').trigger("reset");
                            $('#loader-modal').modal('hide');
                            if (data['errCode'] == '1') {
                                window.location.href = "{{ route('users')}}";
                            } else {
                                $('#loader-modal').modal('hide');
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
                    $('#btn-save').html('Save');
                }
            })
        }
    </script>
@endsection
