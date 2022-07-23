@extends('main')
@section('subtitle','Event Details')
@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ URL::asset('css/dataTable.css') }}">

    <script src="{{ URL::asset('js/dataTable.js') }}"></script>
@endsection
@section('content')
    <div class="content-wrapper">
        <br><br>
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card" style="border-radius: 20px">
                    <div class="card-body">
                        <div class="row align-content-md-center" style="height: 80px">
                            <div class="col-md-10">
                                <h4 class="card-title">
                                    <a class="url-nav" href="{{route('events')}}">
                                        <span>Events:</span>
                                    </a>
                                    {{$event['details']['name']}} / Details
                                </h4>
                            </div>
                            <div class="col-md-2 align-content-md-center">
                                @role('super-admin')
                                @if($event['details']['can_edit'] == 1)
                                <a href="{{route('eventEdit', [$event['details']['id']])}}" id="add-new-post" class="add-hbtn">
                                    <i>
                                        <img src="{{ asset('images/edit.png') }}" alt="Add">
                                    </i>
                                    <span class="dt-hbtn">Edit</span>
                                </a>
                                @endif
                                @endrole
                            </div>
                        </div>
                        <br>
                        <input type="hidden" id="logoName" value="{{$event['details']['logo']}}">
                        <div class="row">
                            <div class="form-group col">
                                <img id="logo" src="" alt="Logo" class="event-logo">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group col">
                                    <label>Name</label>
                                    <div class="col-sm-12">
                                        <input type="text" id="name" name="name" value="{{$event['details']['name']}}" disabled/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group col">
                                    <label>Size</label>
                                    <div class="col-sm-12">
                                        <input type="text" id="size" name="size" value="{{$event['details']['size']}}" disabled/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group col">
                                    <label>Event Start Date</label>
                                    <div class="col-sm-12">
                                        <input type="text" id="event_start_date" name="event_start_date"
                                               value="{{$event['details']['event_start_date']}}" disabled/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group col">
                                    <label>Event End Date</label>
                                    <div class="col-sm-12">
                                        <input type="text" id="event_end_date" name="event_end_date"
                                               value="{{$event['details']['event_end_date']}}" disabled/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group col">
                                    <label>Accreditation Start Date</label>
                                    <div class="col-sm-12">
                                        <input type="text" id="accreditation_start_date"
                                               name="accreditation_start_date"
                                               value="{{$event['details']['accreditation_start_date']}}" disabled/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group col">
                                    <label>Accreditation End Date</label>
                                    <div class="col-sm-12">
                                        <input type="text" id="accreditation_end_date" name="accreditation_end_date"
                                               value="{{$event['details']['accreditation_end_date']}}" disabled/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group col">
                                    <label>Owner</label>
                                    <div class="col-sm-12">
                                        <input type="text" id="owner" name="owner" value="{{$event['details']['owner']}}"
                                               disabled/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group col">
                                    <label>Organizer</label>
                                    <div class="col-sm-12">
                                        <input type="text" id="organizer" name="organizer"
                                               value="{{$event['details']['organizer']}}" disabled/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group col">
                                    <label>Event Type</label>
                                    <div class="col-sm-12">
                                        <input type="event_type" id="event_type" name="event_type"
                                               value="{{$event['details']['event_type']}}" disabled/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group col">
                                    <label>Registration Form Template</label>
                                    <div class="col-sm-12">
                                        <input type="event_form" id="event_form" name="event_form"
                                               value="{{$event['details']['registration_form']}}" disabled/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group col">
                                    <label>Location</label>
                                    <div class="col-sm-12">
                                        <input type="text" id="location" name="location"
                                               value="{{$event['details']['location']}}" disabled/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group col">
                                    <label>Status</label>
                                    <div class="col-sm-12">
                                        <input type="text" id="status" name="status" value="{{$event['details']['status']}}"
                                               disabled/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group col">
                                    <label>Event Admin</label>
                                    <div class="col-sm-12">
                                        <select id="event_admins" name="event_admins[]" disabled multiple>
                                            @foreach ($event['event_list']['eventAdmin'] as $eventAdmin)
                                                <option value="{{ $eventAdmin['name'] }}"
                                                >{{ $eventAdmin['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group col">
                                    <label>Security Group</label>
                                    <div class="col-sm-12">
                                        <select id="security_categories" name="security_categories[]" disabled
                                                multiple>
                                            @foreach ($event['event_list']['securityCategory'] as $securityCategory)
                                                <option value="{{ $securityCategory['name'] }}"
                                                >{{ $securityCategory['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group col">
                                    <label>Security Option</label>
                                    <div class="col-sm-12">
                                        <input type="text" id="approval_option" name="approval_option"
                                               value="{{$event['details']['approval_option']}}" disabled/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group col">
                                    <label>Security Officer</label>
                                    <div class="col-sm-12">
                                        <select id="security_officers" name="security_officers[]" disabled multiple>
                                            @foreach ($event['event_list']['securityOfficer'] as $securityOfficer)
                                                <option value="{{ $securityOfficer['name'] }}"
                                                >{{ $securityOfficer['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

{{--                        <div class="row">--}}
{{--                            <div class="col-md-6">--}}
{{--                                <div class="form-group col">--}}
{{--                                    <label>Logo</label>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-6">--}}
{{--                                <div class="form-group col">--}}
{{--                                    <div class="col-sm-12">--}}
{{--                                        <input type="hidden" id="logoName" value="{{$event->logo}}">--}}
{{--                                        <div class="row"--}}
{{--                                             style="margin-left: 25%; max-height: 100%; max-width: 50%; object-fit: fill">--}}
{{--                                            <img id="logo" src="" alt="Logo">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            let imag = $('#logoName').val();
            if (imag) {
                var image_path = "{{URL::asset('logo/')}}/";
                $('#logo').attr('src', image_path + imag);
            }
        });
    </script>
@endsection
