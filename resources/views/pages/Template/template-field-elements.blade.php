@extends('main')
@section('subtitle',' Template field elements')
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
                                    <a class="url-nav" href="{{route('templateFields',$template->template_id)}}">
                                        <span>{{$template->template_name}}</span>
                                    </a>
                                    / {{$template->field_name}} / Elements
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
                                    <a href="javascript:void(0)" id="add-new-element" class="add-hbtn" title="Add">
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
                                    <th>Value (Arabic)</th>
                                    <th>Value (English)</th>
                                    <th>order</th>
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

    <div class="modal fade" id="element-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalTitle"></h4>
                </div>
                <div class="modal-body">
                    <form id="elementForm" name="elementForm" class="form-horizontal">
                        <input style="visibility: hidden" type="text" name="field_id" id="field_id"
                               value="{{$template->field_id}}">
                        <input type="hidden" name="element_id" id="element_id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group col">
                                    <label>Value (Arabic)</label>
                                    <div class="col-sm-12">
                                        <input type="text" id="value_ar" name="value_ar"
                                               placeholder="enter arabic value" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group col">
                                    <label>Value (English)</label>
                                    <div class="col-sm-12">
                                        <input type="text" id="value_en" name="value_en"
                                               placeholder="enter english value" required="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group col">
                                    <label>Order</label>
                                    <div class="col-sm-12">
                                        <input type="number" id="order" min="1" max="20" name="order"
                                               placeholder="enter order" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!--                                 <div class="form-group col">
                                                                    <label>Value (ID)</label>
                                                                    <div class="col-sm-12">
                                                                        <input type="number" id="value_id" min="1" max="20" name="value_id"
                                                                               placeholder="enter value ID" required="">
                                                                    </div>
                                                                </div> -->
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

    <!-- Delete confirm modal -->
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

            var fieldId = $('#field_id').val();

            var url = "{{ route('templateFieldElements', ":id") }}";
            url = url.replace(':id', fieldId);

            $('#laravel_datatable').DataTable({

                dom: 'lBrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    title: 'Templates',
                    exportOptions: {
                        columns: [1, 2, 3]
                    }
                }],

                processing: true,
                serverSide: true,
                ajax: {
                    url: url,
                    type: 'GET',
                },
                columns: [
                    {data: 'element_id', name: 'element_id', 'visible': false},
                    {data: 'value_ar', name: 'value_ar'},
                    {data: 'value_en', name: 'value_en'},
                    {data: 'order', name: 'order'},
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

            $('#add-new-element').click(function () {
                $('#btn-save').val("create-element");

                $('#element_id').val('');
                $('#elementForm').trigger("reset");
                $('#modalTitle').html("New Element");
                $('#element-modal').modal('show');
            });

            $('body').on('click', '#edit-element', function () {

                var field_id = $(this).data('id');
                $('#loader-modal').modal('show');

                var url = "{{ route('templateFieldElementGetById', ":id") }}";
                url = url.replace(':id', field_id);

                $.get(url, function (data) {
                })
                    .done(function (data) {
                        $('#loader-modal').modal('hide');
                        $('#elementForm').trigger("reset");
                        if (data['errCode'] == '1') {
                            $('#modalTitle').html("Edit element");
                            $('#element-modal').modal('show');
                            $('#element_id').val(data['data']['element_id']);
                            $('#value_ar').val(data['data']['value_ar']);
                            $('#value_en').val(data['data']['value_en']);
                            $('#order').val(data['data']['order']);
                        } else {
                            $('#errorText').html(data['errMsg']);
                            $('#error-pop-up-modal').modal('show');
                        }
                    })
                    .fail(function (data) {
                        $('#element-modal').modal('hide');
                        $('#loader-modal').modal('hide');
                        $('#btn-save').html('Save Changes');
                    });
                $('#btn-save').html('Save');
            });
        });


        $('body').on('click', '#delete-element', function () {
            var element_id = $(this).data("id");
            $('#confirmTitle').html('Delete element');
            $('#curr_element_id').val(element_id);
            var confirmText = 'Are you sure you want to delete this element?';
            $('#confirmText').html(confirmText);
            $('#delete-element-confirm-modal').modal('show');
        });

        $('#delete-element-confirm-modal button').on('click', function (event) {
            var $button = $(event.target);

            $(this).closest('.modal').one('hidden.bs.modal', function () {
                if ($button[0].id === 'btn-yes') {

                    $('#btn-save').html('Sending..');
                    $('#loader-modal').modal('show');
                    var element_id = $('#curr_element_id').val();

                    var url = "{{ route('templateFieldElementDelete', ":id") }}";
                    url = url.replace(':id', element_id);

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


        if ($("#elementForm").length > 0) {
            $("#elementForm").validate({
                submitHandler: function (form) {
                    $('#btn-save').html('Sending..');
                    $('#loader-modal').modal('show');
                    $.ajax({
                        data: $('#elementForm').serialize(),
                        url: "{{ route('templateFieldElementController.store') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                            $('#loader-modal').modal('hide');
                            $("#element-modal").modal('hide');
                            $('#elementForm').trigger("reset");
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
                            $("#element-modal").modal('hide');
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
