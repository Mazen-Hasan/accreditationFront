@extends('main')
@section('subtitle',' Template badge fields')
@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ URL::asset('css/dataTable.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/designer/custom.css') }}">


    <script src="{{ URL::asset('js/designer/konva.js') }}"></script>

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
                            <div class="col-md-9">
                                <p class="card-title">
                                    <a class="url-nav" href="{{route('templateBadge')}}">
                                        <span>Badges:</span>
                                    </a>
                                    / Fields
                                </p>
                            </div>

                        </div>
                        <div class="table-responsive">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="card">
                                            <div class="card-header">
                                                Badge design
                                            </div>
                                            <div class="card-body">
                                                <div id="div-badge" style="width: 400px;height: 600px">
                                                    <div id="menu">
                                                        <div>
                                                            <button id="pulse-button">Pulse</button>
                                                            <button id="delete-button">Delete</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div  class="col-sm-2">
                                        <div class="card">
                                            <div class="card-header">
                                                Badge fields
                                            </div>
                                            <div class="card-body">
                                                <div id="div-badge-elem">
                                                    <span><label>Personal</label><button data-id="personal" data-type="rec" id="personal" class="personal_img_add">add</button></span>
                                                    <span><label>Full Name</label><button data-id="full_name" data-type="text" id="full_name" class="personal_img_add">add</button></span>
                                                    <span><label>Category</label><button data-id="category" data-type="text" id="category" class="personal_img_add">add</button></span>
                                                    <span><label>Company</label><button data-id="company" data-type="text" id="company" class="personal_img_add">add</button></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        Properties
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="properties">
                                                            <form class="form-group">
                                                                <div class="form-group row">
                                                                    <label class="control-label col-sm-4" for="field-name">Field Name:</label>
                                                                    <input class="col-sm-7" id="field-name" readonly type="text">
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="control-label col-sm-4" for="position-x">Position(X):</label>
                                                                    <input class="col-sm-7" id="position-x" type="number">
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="control-label col-sm-4" for="position-y">Position(Y):</label>
                                                                    <input class="col-sm-7" id="position-y" type="number">
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="control-label col-sm-4" for="item-width">Width:</label>
                                                                    <input class="col-sm-7" id="item-width" type="number">
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="control-label col-sm-4" for="item-height">Height:</label>
                                                                    <input class="col-sm-7" id="item-height" type="number">
                                                                </div>
                                                                <div class="form-group row" id="font-size-container">
                                                                    <label class="control-label col-sm-4" for="item-font-size">Font Size:</label>
                                                                    <input class="col-sm-7" id="item-font-size" type="number">
                                                                </div>
                                                                <div class="form-group row" id="font-container">
                                                                    <label class="control-label col-sm-4" for="item-font-family">Font Family:</label>
                                                                    <input class="col-sm-5" id="item-font-family" type="text"><button type="button" id="update_font">Change</button>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="control-label col-sm-4" for="item-font-color">Color:</label>
                                                                    <input class="col-sm-5" id="item-font-color" type="text"><button type="button" id="update_color">Change</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        Size
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="size-options">
                                                            <form class="form-group">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="radio-size" id="size-1" value="0" checked/>
                                                                    <label class="form-check-label" for="size-1"> Credit Card Size(53,98 * 85,60 mm)</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="radio-size" id="size-2"  value="1"/>
                                                                    <label class="form-check-label" for="size-2"> Oversize (9 * 14 Cm) </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="radio-size" id="size-3"  value="2"/>
                                                                    <label class="form-check-label" for="size-3"> Concert Size (70 * 100 mm) </label>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
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
        <script src="js/designer/designer.js"></script>
@endsection
