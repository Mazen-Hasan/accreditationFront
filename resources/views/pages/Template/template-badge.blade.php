@extends('main')
@section('subtitle',' Template badge')
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
                                <p class="card-title">Badges</p>
                            </div>
                         	<div class="col-md-1">
                                <div class="search-container">
                                    <input class="search expandright" id="search" type="text" placeholder="Search">
                                    <label class="search-button search-button-icon" for="search">
                                        <i class="icon-search"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <a href="javascript:void(0)" class="add-hbtn export-to-excel" title="Export to excel">
                                    <i>
                                        <img src="{{ asset('images/excel.png') }}" alt="Export to excel">
                                    </i>
                                </a>
                                <a href="javascript:void(0)" id="add-new-badge" class="add-hbtn" title="Add">
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
                                    <th>Template ID</th>
                                    <th>Registration Form</th>
                                    <th>Width (mm)</th>
                                    <th>Height (mm)</th>
                                    <th>Default Background</th>
                                    <th>Locked</th>
                                    <th>Action</th>
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

    <!-- add new badge modal-->
    <div class="modal fade" id="new-badge-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalTitle"></h4>
                </div>
                <div class="modal-body">
                    <form id="bg_imgForm" name="badgeForm" class="form-horizontal  img-upload"
                          enctype="multipart/form-data" action="javascript:void(0)">
                        <div class="row">
                            <div class="col-md-5">
                                <label>Default Background</label>
                            </div>

                            <div class="col-md-4">
                                <div class="col-sm-12">
                                    <input type="file" id="file" name="file">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <button type="submit" id="btn-upload" value="Upload">Upload
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group col">
                                    <label id="file_type_error"></label>
                                    <div style="background-color: #ffffff00!important;" class="progress">
                                        <div id="file-progress-bar" class="progress-bar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <form id="badgeForm" name="badgeForm" class="form-horizontal">
                        <div class="row" style="margin-left: 25%;justify-content: center; max-height: 100%; max-width: 50%; object-fit: fill">
                        <img id="badge_bg" src="" alt="im"
                             style="width:200px;height:200px;">
                        </div>
                        <input type="hidden" name="badge_id" id="badge_id">
                        <input style="visibility: hidden" type="text" name="h_template_id" id="h_template_id">
                        <input style="visibility: hidden" type="text" name="bg_image" id="bg_image">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group col">
                                    <label>Width</label>
                                    <div class="col-sm-12">
                                        <input type="number" id="width" min="20" max="100" name="width"
                                               placeholder="enter width (mm)"
                                               required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group col">
                                    <label>Height</label>
                                    <div class="col-sm-12">
                                        <input type="number" id="high" name="high" min="20" max="100"
                                               placeholder="enter high (mm)"
                                               required="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group col">
                                    <label>Registration form</label>
                                    <div class="col-sm-12">
                                        <select id="template_id" name="template_id" required="">
                                            <option value="default">Please select Registration form</option>
                                            @foreach ($templates as $template)
                                                <option value="{{ $template->id }}" data-slug="{{$template->name}}"
                                                        @if ($template->id == 1)
                                                        selected="selected"
                                                    @endif
                                                >{{ $template->name }}</option>
                                            @endforeach
                                        </select>
                                        <input id="lbl_template_id" disabled/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group col">
                                    <label id="add-new-badge-error" class="error" style="display: inline !important;"></label>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div class="col-sm-12">
                                <button type="submit" id="btn-save" value="create">Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
         role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmTitle"></h5>
                </div>
                <div class="modal-body">
                    <div>
                        <input type="hidden" id="curr_badge_id">
                        <input type="hidden" id="mode_id">
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

    <div class="modal fade" id="badge-modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
         role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="badgeTitle">Badge preview</h5>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin-left: 25%; max-height: 100%; max-width: 50%; object-fit: fill">
                        <img id="badge" src="" alt="Badge">
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

            var templateId = $('#template_id').val();

            $('#laravel_datatable').DataTable({

                dom: 'lBrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    title: 'Badge',
                    exportOptions: {
                        columns: [2, 3, 4, 6]
                    }
                }],

                processing: true,
                serverSide: true,
                ajax: {
                    url: 'template-badge',
                    type: 'GET',
                },
                columns: [
                    {data: 'id', name: 'id', 'visible': false},
                    {data: 'template_id', name: 'template_id', 'visible': false},
                    {data: 'name', name: 'name'},
                    {
                        "data": "width",
                        "render": function (val) {
                            return Math.round(val * 0.2645833333);
                        }
                    },
                    // {data: 'width', name: 'width'},
                    {
                        "data": "high",
                        "render": function (val) {
                            return Math.round(val * 0.2645833333);
                        }
                    },
                    // {data: 'high', name: 'high'},
                    // {
                    //     "data": "bg_color",
                    //     "render": function (val) {
                    //         return "<div class='div-color' style='background-color: " + val + "'></div>";
                    //     }
                    // },

                    {data: 'bg_image', name: 'bg_image'},
                    {
                        "data": "is_locked",
                        "render": function (val) {
                            return val == 1 ? "Yes" : "No";
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

            $('#add-new-badge').click(function () {
                $('#btn-save').val("create-field");
                $('#badge_id').val('');
                $('#file').val('');
                $('#template_id').removeAttr('hidden');
                $('#lbl_template_id').attr('hidden', 'true');
                $("#file_type_error").html('');
                $("#file-progress-bar").width('0%');
                $('#badgeForm').trigger("reset");
                $('#modalTitle').html("New Badge");
                $("#add-new-badge-error").html('');
                $('#badge_bg').attr('src', '');
                $('#badge_bg').hide();


                $('#new-badge-modal').modal('show');
            });

            $('body').on('click', '#edit-badge', function () {
                var badge_id = $(this).data('id');
                $('#loader-modal').modal('show');
                $.get('templateBadgeController/' + badge_id + '/edit', function (data) {
                    $('#loader-modal').modal('hide');
                    $('#name-error').hide();
                    $('#modalTitle').html("Edit Badge");
                    $('#btn-save').html("Save");
                    $('#badge_id').val(data.id);
                	$('#width').val(Math.round(data.width * 0.2645833333));
                    $('#high').val(Math.round(data.high * 0.2645833333));
                    $('#bg_color').val(data.bg_color);
                    $('#new-badge-modal').modal('show');

                    $('#template_id').val(data.template_id);
                    $('#template_id').attr('hidden', 'true');

                    $('#lbl_template_id').removeAttr('hidden');
                    $('#lbl_template_id').val(data.name);

                    $("#file-progress-bar").width('0%');
                    $("#file_type_error").html('');

                    $("#bg_image").val(data.bg_image);

                    var imag = data.bg_image;
                    // server
                    {{--var image_path = "{{URL::asset('storage/badges/')}}/";--}}
                    // local
                    var image_path = "{{URL::asset('badges/')}}/";

                    $('#badge_bg').attr('src', image_path + imag);
                    $('#badge_bg').show();
                });
            });
        });

        $('body').on('click', '#lock-badge', function () {
            var template_id = $(this).data("id");
            $('#confirmTitle').html('Lock badge');
            $('#curr_badge_id').val(template_id);
            $('#mode_id').val('1');
            var confirmText = 'Are you sure you want to lock this badge?';
            $('#confirmText').html(confirmText);
            $('#confirmModal').modal('show');
        });

        $('body').on('click', '#unLock-badge', function () {
            var template_id = $(this).data("id");
            $('#confirmTitle').html('Un-Lock badge');
            $('#curr_badge_id').val(template_id);
            $('#mode_id').val('0');
            var confirmText = 'Are you sure you want to unLock this badge?';
            $('#confirmText').html(confirmText);
            $('#confirmModal').modal('show');
        });

        $('#confirmModal button').on('click', function (event) {
            var $button = $(event.target);

            $(this).closest('.modal').one('hidden.bs.modal', function () {
                if ($button[0].id === 'btn-yes') {
                    var badge_id = $('#curr_badge_id').val();
                    var mode_id = $('#mode_id').val();
                    $('#loader-modal').modal('show');
                    $.ajax({
                        type: "get",
                        url: "templateBadgeController/changeLock/" + badge_id + "/" + mode_id,
                        success: function (data) {
                            $('#loader-modal').modal('hide');
                            var oTable = $('#laravel_datatable').dataTable();
                            oTable.fnDraw(false);
                        },
                        error: function (data) {
                            $('#loader-modal').modal('hide');
                            console.log('Error:', data);
                        }
                    });
                }
            });
        });

        $('body').on('click', '#preview-badge', function () {
            var badge_id = $(this).data("id");
            $('#loader-modal').modal('show');
            $.ajax({
                type: "get",
                url: "badge-design-generate/" + badge_id,
                success: function (data) {
                    $('#loader-modal').modal('hide');
                    $('#badge-modal').modal('show');

                    var imag = data;
                    var image_path = "{{URL::asset('preview/')}}/";

                    $('#badge').attr('src', image_path + imag);
                },
                error: function (data) {
                    $('#loader-modal').modal('hide');
                    console.log('Error:', data);
                }
            });
        });

        $("#file").change(function () {
            let allowedTypes = ['image/png','image/jpeg'];
            let file = this.files[0];
            let fileType = file.type;
            if (!allowedTypes.includes(fileType)) {
                $("#file-progress-bar").width('0%');
                $('#file_type_error').removeClass('info').addClass('error');
                $("#file_type_error").html('Please choose a valid file (jpeg, png)');
                $("#file").val('');
                $("#btn-upload").attr('disabled', true);
                return false;
            } else {
                $("button").removeAttr('disabled');
                $("#file_type_error").html('');
                $("#file-progress-bar").width('0%');
            }
        });

        if ($("#badgeForm").length > 0) {
            $("#badgeForm").validate({

                rules: {
                    template_id: {valueNotEquals: "default"}
                },

                submitHandler: function (form) {

                    let chosen_file = $('#file').val();
                    let badge_bg_file = $('#badge_bg').attr('src');
                    if(chosen_file == '' && badge_bg_file =='')
                    {
                        $('#file_type_error').removeClass('info').addClass('error');
                        $("#file_type_error").html('Please choose badge background');
                        return false;
                    }

                    if(badge_bg_file=='')
                    {
                        $('#file_type_error').removeClass('info').addClass('error');
                        $("#file_type_error").html('Please upload badge background before save the badge');
                        return false;
                    }

                    $('#btn-save').html('Sending..');
                    $('#loader-modal').modal('show');
                    $.ajax({
                        data: $('#badgeForm').serialize(),
                        url: "{{ route('templateBadgeController.store') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                            if(data["code"] == "1"){
                                $('#loader-modal').modal('hide');
                                $('#badgeForm').trigger("reset");
                                $('#new-badge-modal').modal('hide');
                                $('#btn-save').html('Save Changes');
                                var oTable = $('#laravel_datatable').dataTable();
                                oTable.fnDraw(false);
                            }
                            else{
                                $('#loader-modal').modal('hide');
                                $('#btn-save').html('Save Changes');
                                $('#add-new-badge-error').css("display", "block")
                                $("#add-new-badge-error").html(data["message"]);
                                // $('#errorTitle').html('Error:');
                                // $('#errorText').html(data["message"]);
                                // $('#error-pop-up-modal').modal('show');
                            }
                        },
                        error: function (data) {
                            $('#loader-modal').modal('hide');
                            console.log(data);
                            $('#btn-save').html('Save Changes');
                        }
                    });
                }
            })
        }


        $('.img-upload').submit(function (e) {

        	let file = $('#file').val();
            if(file == '')
            {
                $('#file_type_error').removeClass('info').addClass('error');
                $("#file_type_error").html('Please choose badge background');
                return false;
            }

            $('#btn-upload').html('Sending..');
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('template_id', $('#h_template_id').val());
            $.ajax({
                xhr: function () {
                    let xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function (element) {
                        if (element.lengthComputable) {
                            var percentComplete = ((element.loaded / element.total) * 100);
                            $("#file-progress-bar").width(percentComplete + '%');
                            $("#file-progress-bar").html(percentComplete + '%');
                        }
                    }, false);
                    return xhr;
                },

                type: 'POST',
                url: "{{ url('store-file')}}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,

                beforeSend: function () {
                    $("#file-progress-bar").width('0%');
                },

                success: (data) => {
                	$('#file_type_error').removeClass('error').addClass('info');
                    $("#file_type_error").html('File uploaded successfully');
                    $('#btn-upload').html('Upload');
                    $("#bg_image").val(data.fileName);

                    var imag = data.fileName;
                    var image_path = "{{URL::asset('badges/')}}/";

                    $('#badge_bg').attr('src', image_path + imag);
                    $('#badge_bg').show();
                },

                error: function (data) {
                    $("#file_type_error").html('Error uploading file');
                    console.log(data);
                }
            });
        });

        jQuery.validator.addMethod("valueNotEquals",
            function (value, element, params) {
                return params !== value;
            }, " Please select a template");
    </script>
@endsection
