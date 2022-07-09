@extends('main')
@section('subtitle',' Template fields')
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
                                <p class="card-title">
                                    <a class="url-nav" href="{{route('templates')}}">
                                        <span>Template:</span>
                                    </a>
                                    {{$template->name}} / Fields
                                </p>
                            </div>
                        	<div class="col-md-1 align-content-md-center">
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
                                <span class="dt-hbtn"></span>
                                @if($template->is_locked == 0)
                                    <a href="javascript:void(0)" id="add-new-field" class="add-hbtn" title="Add">
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
                                    <th>Label (Arabic)</th>
                                    <th>Label (English)</th>
                                    <th>Order</th>
                                    <th>Mandatory</th>
                                    <th>Min</th>
                                    <th>Max</th>
                                    <th>Type</th>
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
    <!-- add new field modal-->
    <div class="modal fade" id="field-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalTitle"></h4>
                </div>
                <div class="modal-body">
                    <form id="fieldForm" name="fieldForm" class="form-horizontal">
                        <input style="visibility: hidden" type="text" name="template_id" id="template_id"
                               value="{{$template->id}}">
                            <input type="hidden" name="field_id" id="field_id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group col">
                                    <label>Label (Arabic)</label>
                                    <div class="col-sm-12">
                                        <input type="text" id="label_ar" name="label_ar"
                                               placeholder="enter arabic label" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group col">
                                    <label>Label (English)</label>
                                    <div class="col-sm-12">
                                        <input type="text" id="label_en" name="label_en"
                                               placeholder="enter english label" required="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group col">
                                    <label>Type</label>
                                    <div class="col-sm-12">
                                        <select id="field_type" name="field_type" required="">
                                            @foreach ($fieldTypes as $fieldType)
                                                <option value="{{ $fieldType['id'] }}" data-slug="{{$fieldType['slug']}}"
                                                >{{ $fieldType['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="option">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group col">
                                        <label>Min</label>
                                        <div class="col-sm-12">
                                            <input type="number" id="min_char" min="1" max="500" name="min_char"
                                                   placeholder="enter min">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group col">
                                        <label>Max</label>
                                        <div class="col-sm-12">
                                            <input type="number" id="max_char" min="1" max="500" name="max_char"
                                                   placeholder="enter max">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group col">
                                        <label>Order</label>
                                        <div class="col-sm-12">
                                            <input type="number" id="field_order" name="field_order" min="1" max="500"
                                                   placeholder="enter field order">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group col">
                                        <label>Mandatory</label>
                                        <div class="col-sm-12">
                                            <input type="checkbox" id="mandatory" name="mandatory">
                                        </div>
                                    </div>
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
    <!-- delete confirm modal -->
    <div class="modal fade" id="delete-field-confirm-modal" tabindex="-1" data-bs-backdrop="static"
         data-bs-keyboard="false" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmTitle"></h5>
                </div>
                <div class="modal-body">
                    <div>
                        <input type="hidden" id="curr_field_id">
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

            var templateId = $('#template_id').val();

            var url = "{{ route('templateFields', ":id") }}";
            url = url.replace(':id', templateId);

            $('#laravel_datatable').DataTable({

                dom: 'lBrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    title: 'Template-field',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7]
                    }
                }],

                processing: true,
                serverSide: true,
                ajax: {
                    url: url,
                    type: 'GET',
                },
                columns: [
                    {data: 'field_id', name: 'field_id', 'visible': false},
                    {data: 'label_ar', name: 'label_ar'},
                    {data: 'label_en', name: 'label_en'},
                    {data: 'field_order', name: 'field_order'},
                    {
                        "data": "mandatory",
                        "render": function (val) {
                            return val == 1 ? "Yes" : "No";
                        }
                    },
                    {data: 'min_char', name: 'min_char'},
                    {data: 'max_char', name: 'max_char'},
                    {data: 'type', name: 'type'},
                    {data: 'action', name: 'action', orderable: false}
                ],
                order: [[3, 'asc']]
            });

            $('.export-to-excel').click(function () {
                $('#laravel_datatable').DataTable().button('.buttons-excel').trigger();
            });

        	var oTable = $('#laravel_datatable').DataTable();

            $('#search').on('keyup', function () {
                oTable.search(this.value).draw();
            });

            $('#add-new-field').click(function () {
                $('#field_id').val('');
                $('#fieldForm').trigger("reset");
                $('#modalTitle').html("New Field");
                $('#field-modal').modal('show');
                var selected = $('#field_type').find('option:selected');
                var slug = selected.data('slug');
                if (slug === 'text' || slug === 'number' || slug === 'textarea') {
                    $('#option').show();
                    $('#min_char').prop('disabled', false);
                    $('#max_char').prop('disabled', false);
                } else {
                    $('#option').hide();
                    $('#min_char').prop('disabled', true);
                    $('#max_char').prop('disabled', true);
                }
            });

            $('body').on('click', '#edit-field', function () {
                var field_id = $(this).data('id');
                $('#loader-modal').modal('show');

                var url = "{{ route('templateFieldGetById', ":id") }}";
                url = url.replace(':id', field_id);

                $.get( url, function (data) {
                })
                    .done(function (data) {
                        $('#loader-modal').modal('hide');
                        $('#templateForm').trigger("reset");
                        if (data['errCode'] == '1') {
                            $('#modalTitle').html("Edit Field");
                            $('#field-modal').modal('show');
                            $('#field_id').val(data['data']['field_id']);
                            $('#label_ar').val(data['data']['label_ar']);
                            $('#label_en').val(data['data']['label_en']);
                            $('#min_char').val(data['data']['min_char']);
                            $('#max_char').val(data['data']['max_char']);
                            $('#field_order').val(data['data']['field_order']);
                            if (data['mandatory'] === 1) {
                                $('#mandatory').attr('checked', 'checked');
                            } else {
                                $('#mandatory').removeAttr('checked');
                            }

                            $('#field_type').val(data['data']['field_type_id']);

                            var selected = $('#field_type').find('option:selected');
                            var slug = selected.data('slug');
                            if (slug === 'text' || slug === 'number' || slug === 'textarea') {
                                $('#option').show();
                                $('#min_char').prop('disabled', false);
                                $('#max_char').prop('disabled', false);
                            } else {
                                $('#option').hide();
                                $('#min_char').prop('disabled', true);
                                $('#max_char').prop('disabled', true);
                            }
                        } else {
                            $('#errorText').html(data['errMsg']);
                            $('#error-pop-up-modal').modal('show');
                        }
                    })
                    .fail(function (data) {
                        $('#template-modal').modal('hide');
                        $('#loader-modal').modal('hide');
                        $('#btn-save').html('Save Changes');
                    });
                $('#btn-save').html('Save');
                });
            });

            $('body').on('click', '#delete-field', function () {
                var field_id = $(this).data("id");
                $('#confirmTitle').html('Delete field');
                $('#curr_field_id').val(field_id);
                $('#mode_id').val('1');
                var confirmText = 'Are you sure you want to delete this field?';
                $('#confirmText').html(confirmText);
                $('#delete-field-confirm-modal').modal('show');
            });

            $('#delete-field-confirm-modal button').on('click', function (event) {
                var $button = $(event.target);

                $(this).closest('.modal').one('hidden.bs.modal', function () {
                    if ($button[0].id === 'btn-yes') {
                        $('#btn-save').html('Sending..');
                        $('#loader-modal').modal('show');
                        var field_id = $('#curr_field_id').val();

                        var url = "{{ route('templateFieldDelete', ":id") }}";
                        url = url.replace(':id', field_id);

                        $.ajax({
                            type: "get",
                            url: url,
                            success: function (data) {
                                $('#loader-modal').modal('hide');
                                if (data['errCode'] == '1') {
                                    $('#loader-modal').modal('hide');
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
                        $('#btn-save').html('Save');
                    }
                });
        });

        if ($("#fieldForm").length > 0) {
            $("#fieldForm").validate({
                submitHandler: function (form) {
                    $('#btn-save').html('Sending..');
                    $('#loader-modal').modal('show');
                    $.ajax({
                        data: $('#fieldForm').serialize(),
                        url: "{{ route('templateFieldController.store') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                            $('#loader-modal').modal('hide');
                            $('#templateForm').trigger("reset");
                            $('#field-modal').modal('hide');
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
                            $('#field-modal').modal('hide');
                            $('#errorText').html(data['errMsg']);
                            $('#error-pop-up-modal').modal('show');
                        }
                    });
                    $('#btn-save').html('Save');
                }
            })
        }


        $('select').on('change', function () {
            var selected = $(this).find('option:selected');
            var slug = selected.data('slug');
            if (slug === 'text' || slug === 'number' || slug === 'textarea') {
                $('#option').show();
                $('#min_char').prop('disabled', false);
                $('#max_char').prop('disabled', false);
            } else {
                $('#option').hide();
                $('#min_char').prop('disabled', true);
                $('#max_char').prop('disabled', true);
            }
        });
        $('#label_en').on("cut copy paste",function(e) {
            e.preventDefault();
        });
        $("#label_en").keypress(function(event){
            var ew = event.which;
            //alert(ew);
            if(ew == 32)
                return true;
            if(48 <= ew && ew <= 57)
                return true;
            if(65 <= ew && ew <= 90)
                return true;
            if(97 <= ew && ew <= 122)
                return true;
            return false;
        });
    </script>
@endsection
