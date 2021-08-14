@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <div class="pull-right">

            <a href="{{route('registrations.registrations.index')}}">
                <button class="btn btn-labeled btn-green mb-2  pull-right" type="button">
                           <span class="btn-label"><i class="fa fa-list"></i>
                           </span>Back to List</button>
            </a>

        </div>

    </div>

    <div class="panel-body form-horizontal form-label-left">
        <div class="card">
            <div class="card-header"><h4>Registration Details for #{{$registrations->id}} </h4></div>
            <div class="card-body ">
                <div class="form-group">
                    <div class="col-md-12 p-0 row pb-1">
                        <div class="col-md-4 p-0 flex">
                            <label for="email" class="p-0 col-md-3 control-label">Email: </label>
                            <div class="col-md-9">
                                <input readonly class="form-control" name="email"  value="{{ $registrations->email }}">
                            </div>
                        </div>
                        <div class="col-md-4 p-0 flex">
                            <label for="email" class="p-0 col-md-3 control-label">Name: </label>
                            <div class="col-md-9">
                                <input readonly class="form-control" name="email"  value="{{ $registrations->full_name }}">
                            </div>
                        </div>
                        <div class="col-md-4 p-0 flex">
                            <label for="email" class="p-0 col-md-3 control-label">DOB: </label>
                            <div class="col-md-9">
                                <input readonly class="form-control" name="email"  value="{{ $registrations->dob }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 p-0 row pb-1">
                        <div class="col-md-4 p-0 flex">
                            <label for="email" class="p-0 col-md-3 control-label">Gender: </label>
                            <div class="col-md-9">
                                <input readonly class="form-control" name="email"  value="{{ $registrations->gender }}">
                            </div>
                        </div>
                        <div class="col-md-4 p-0 flex">
                            <label for="email" class="p-0 col-md-3 control-label">Category: </label>
                            <div class="col-md-9">
                                <input readonly class="form-control" name="email"  value="{{ $registrations->category }}">
                            </div>
                        </div>
                        <div class="col-md-4 p-0 flex">
                            <label for="email" class="p-0 col-md-3 control-label">Aadhar: </label>
                            <div class="col-md-9">
                                <input readonly class="form-control" name="email"  value="{{ $registrations->aadhar }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 p-0 row pb-1">
                        <div class="col-md-4 p-0 flex">
                            <label for="email" class="p-0 col-md-3 control-label">Contact No: </label>
                            <div class="col-md-9">
                                <input readonly class="form-control" name="email"  value="{{ $registrations->contact_no }}">
                            </div>
                        </div>
                        <div class="col-md-4 p-0 flex">
                            <label for="email" class="p-0 col-md-3 control-label">Whatsapp No: </label>
                            <div class="col-md-9">
                                <input readonly class="form-control" name="email"  value="{{ $registrations->whatsapp_no }}">
                            </div>
                        </div>
                        <div class="col-md-4 p-0 flex">
                            <label for="email" class="p-0 col-md-3 control-label">Last School: </label>
                            <div class="col-md-9">
                                <input readonly class="form-control" name="email"  value="{{ $registrations->last_school }}">
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12 p-0 row pb-1">
                        <div class="col-md-4 p-0 flex">
                            <label for="email" class="p-0 col-md-3 control-label">Hslc Result: </label>
                            <div class="col-md-9">
                                <input readonly class="form-control" name="email"  value="{{ $registrations->hslc_result }}">
                            </div>
                        </div>
                        <div class="col-md-4 p-0 flex">
                            <label for="email" class="p-0 col-md-3 control-label">Father: </label>
                            <div class="col-md-9">
                                <input readonly class="form-control" name="email"  value="{{ $registrations->father_name }}">
                            </div>
                        </div>
                        <div class="col-md-4 p-0 flex">
                            <label for="email" class="p-0 col-md-3 control-label">Occupation: </label>
                            <div class="col-md-9">
                                <input readonly class="form-control" name="email"  value="{{ $registrations->father_occupation }}">
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12 p-0 row pb-1">
                        <div class="col-md-4 p-0 flex">
                            <label for="email" class="p-0 col-md-3 control-label">Mother: </label>
                            <div class="col-md-9">
                                <input readonly class="form-control" name="email"  value="{{ $registrations->mother_name }}">
                            </div>
                        </div>
                        <div class="col-md-4 p-0 flex">
                            <label for="email" class="p-0 col-md-3 control-label">Occupation: </label>
                            <div class="col-md-9">
                                <input readonly class="form-control" name="email"  value="{{ $registrations->mother_occupation }}">
                            </div>
                        </div>
                        <div class="col-md-4 p-0 flex">
                            <label for="email" class="p-0 col-md-3 control-label">Village/Town: </label>
                            <div class="col-md-9">
                                <input readonly class="form-control" name="email"  value="{{ $registrations->village_town }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 p-0 row pb-1">

                        <div class="col-md-4 p-0 flex">
                            <label for="email" class="p-0 col-md-3 control-label">Stream: </label>
                            <div class="col-md-9">
                                <input readonly class="form-control" name="email"  value="{{ $registrations->stream }}">
                            </div>
                        </div>
                        <div class="col-md-4 p-0 flex">
                            <label for="email" class="p-0 col-md-3 control-label">Subject Type: </label>
                            <div class="col-md-9">
                                <input readonly class="form-control" name="email"  value="{{ $registrations->selected_subject }}">
                            </div>
                        </div>

                    </div>


                    <div class="col-md-12 p-0 row pb-1">
                        <div class="col-md-4 p-0 flex">
                            <label for="email" class="p-0 col-md-3 control-label">District: </label>
                            <div class="col-md-9">
                                <input readonly class="form-control" name="email"  value="{{ $registrations->district }}">
                            </div>
                        </div>
                        <div class="col-md-4 p-0 flex">
                            <label for="email" class="p-0 col-md-3 control-label">State: </label>
                            <div class="col-md-9">
                                <input readonly class="form-control" name="email"  value="{{ $registrations->state }}">
                            </div>
                        </div>
                        <div class="col-md-4 p-0 flex">
                            <label for="email" class="p-0 col-md-3 control-label">Pin: </label>
                            <div class="col-md-9">
                                <input readonly class="form-control" name="email"  value="{{ $registrations->pin }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 p-0 row pb-1">
                        <div class="col-md-6 p-0 flex">
                            <label for="email" class="p-0 col-md-2 control-label">Present Add.: </label>
                            <div class="col-md-9">
                                <input readonly class="form-control" name="email"  value="{{ $registrations->present_address }}">
                            </div>
                        </div>
                        <div class="col-md-6 p-0 flex">
                            <label for="email" class="p-0 col-md-2 control-label">Permanent Add.: </label>
                            <div class="col-md-9">
                                <input readonly class="form-control" name="email"  value="{{ $registrations->permanent_address }}">
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12 p-0 row pb-1">
                        <div class="col-md-4 p-0 flex">
                            <label for="email" class="p-0 col-md-3 control-label">Photo: </label>
                            <div class="col-md-9">
                                <div class="img-wrapper">
                                    <div class="img-container photo-preview"  style=" background: url('{{ asset('uploads/registrations').'/'.$registrations->file_photo_path }}');"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 p-0 row pb-1">
                        <div class="col-md-4 p-0 flex">
                            <label for="email" class="p-0 col-md-3 control-label">Aadhar: </label>
                            <div class="col-md-9">
                                <a target="_blank" href="{{asset('uploads/registrations').'/'.$registrations->file_aadhaar_path}}">{{$registrations->file_aadhaar_path}}</a>
                            </div>
                        </div>
                        <div class="col-md-4 p-0 flex">
                            <label for="email" class="p-0 col-md-3 control-label">HSLC Marksheet: </label>
                            <div class="col-md-9">
                                <a target="_blank" href="{{asset('uploads/registrations').'/'.$registrations->file_hslc_marksheet_path}}">{{$registrations->file_hslc_marksheet_path}}</a>
                            </div>
                        </div>
                        <div class="col-md-4 p-0 flex">
                            <label for="email" class="p-0 col-md-3 control-label">HSLC Admit Card: </label>
                            <div class="col-md-9">
                                <a target="_blank" href="{{asset('uploads/registrations').'/'.$registrations->file_hslc_admitcard_path}}">{{$registrations->file_hslc_admitcard_path}}</a>
                            </div>
                        </div>
                    </div>

                    <a href="{{route('registrations.registrations.index')}}">
                    <button class="btn btn-labeled btn-green mb-2  pull-right" type="button">
                           <span class="btn-label"><i class="fa fa-list"></i>
                           </span>Back to List</button>
                    </a>


                </div>
            </div>
        </div>

    </div>
</div>

@endsection