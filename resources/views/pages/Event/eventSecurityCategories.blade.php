@extends('main')
@section('subtitle',' Events')
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
        <br> <br>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-content-md-center" style="height: 80px">
                            <div class="col-md-10">
                                <h4 class="card-title">
                                    <a class="url-nav" href="{{route('events')}}">
                                        <span>Events:</span>
                                    </a>
                                    <a class="url-nav" href="{{route('EventController.show',[$event->event_id])}}">
                                        {{$event->event_name}}
                                    </a> /
                                    Security Categories
                                </h4>
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
                                @role('super-admin')
                                @if($event->can_edit == 1)
                                <a href="javascript:void(0)" id="add-event-security-category" class="add-hbtn" title="Add">
                                    <i>
                                        <img src="{{ asset('images/add.png') }}" alt="Add">
                                    </i>
                                </a>
                                @endif
                                @endrole
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover" id="laravel_datatable" style="text-align: center">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Security Category</th>
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

    <!-- add new security officer modal-->
    <div class="modal fade" id="event-security-category-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalTitle"></h4>
                </div>
                <div class="modal-body">
                    <form id="eventSecurityCategoryForm" name="eventSecurityCategoryForm" class="form-horizontal">
                        <input style="visibility: hidden" type="text" name="event_id" id="event_id"
                               value="{{$event->event_id}}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group col">
                                    <label>Event Security Category</label>
                                    <div class="col-sm-12">
                                        <select id="security_category_id" name="security_category_id" required="">
                                            <option value="default">Please select Security Category</option>
                                            @foreach ($security_categories as $security_category)
                                                <option value="{{ $security_category->security_category_id }}"
                                                >{{ $security_category->security_category_name }}</option>
                                            @endforeach
                                        </select>
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
    <div class="modal fade" id="delete-event-security-category-confirm-modal" tabindex="-1" data-bs-backdrop="static"
         data-bs-keyboard="false" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmTitle"></h5>
                </div>
                <div class="modal-body">
                    <div>
                        <input type="hidden" id="curr_security_category_id">
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
                    title: 'Event-Security-Categories',
                    exportOptions: {
                        columns: [ 1]
                    }
                }],

                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('eventSecurityCategories',[$event->event_id]) }}",
                    type: 'GET',
                },
                columns: [
                    {data: 'security_category_id', name: 'security_category_id', 'visible': false},
                    {data: 'security_category_name', name: 'security_category_name'},
                    {data: 'action', name: 'action', orderable: false},
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

            $('#add-event-security-category').click(function () {
                $('#btn-save').val("add-event-security-officer");
                $('#event-security-category-modal').trigger("reset");
                $('#modalTitle').html("Add Security Category");
                $('#event-security-category-modal').modal('show');
            });

            $('body').on('click', '#delete-event-security-category', function () {
                var security_category_id = $(this).data("id");
                $('#confirmTitle').html('Remove security category');
                $('#curr_security_category_id').val(security_category_id);
                var confirmText = 'Are you sure you want to remove this event security category?';
                $('#confirmText').html(confirmText);
                $('#delete-event-security-category-confirm-modal').modal('show');
            });

            $('#delete-event-security-category-confirm-modal button').on('click', function (event) {
                var $button = $(event.target);

                $(this).closest('.modal').one('hidden.bs.modal', function () {
                    if ($button[0].id === 'btn-yes') {
                        $('#btn-save').html('Sending..');
                        $('#loader-modal').modal('show');
                        var event_id = $('#event_id').val();
                        var security_category_id = $('#curr_security_category_id').val();

                        var url = "{{ route('eventSecurityCategoryRemove', [":event_id",":security_category_id"]) }}";
                        url = url.replace(':event_id', event_id);
                        url = url.replace(':security_category_id', security_category_id);

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
        });

        if ($("#eventSecurityCategoryForm").length > 0) {
            $("#eventSecurityCategoryForm").validate({
                rules: {
                    security_category_id: {valueNotEquals: "default"}
                },

                submitHandler: function (form) {
                    $('#btn-save').html('Sending..');
                    $('#loader-modal').modal('show');
                    $.ajax({
                        data: $('#eventSecurityCategoryForm').serialize(),
                        url: "{{ route('eventSecurityCategoryAdd') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                            $('#loader-modal').modal('hide');
                            $('#eventSecurityCategoryForm').trigger("reset");
                            $('#event-security-category-modal').modal('hide');
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
                            $('#event-security-category-modal').modal('hide');
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
