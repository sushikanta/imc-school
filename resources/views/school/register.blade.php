@extends('school.layouts.default')
@section('content')


    <!-- Inner Heading Start -->
    <div class="innerHeading-wrap">
        <div class="container">
            <h1>Register</h1>
        </div>
    </div>
    <!-- Inner Heading End -->

    <!-- Inner Content Start -->
    <div class="innerContent-wrap ">
        <div class="container">

            <h4 class="text-center">
                Registration form for Class XI - Science/Arts<br> for the academic session 2021-22
            </h4>
            <!-- Register Start -->
            <div class="login-wrap ">
                <div class="contact-info login_box">
                    <div class="contact-form loginWrp registerWrp">
                            <form method="POST" action="{!! route('register') !!}" class="form-horizontal form-label-left" enctype="multipart/form-data">
                                {{csrf_field()}}


                            {{-- INITIAL SECTION STARTS HERE --}}

                            <div class="form-group row">
                                <label for="fullname" class="text-right col-sm-3 col-form-label {{ $errors->has('full_name') ? 'text-danger' : '' }} ">Full Name :</label>
                                <div class="col-sm-8">
                                    <input  name="full_name" type="text" class="form-control  {{ $errors->has('full_name') ? 'is-invalid' : '' }}"
                                            id="full_name"
                                            value="{{ old('full_name') }}" required minlength="1" maxlength="255">
                                    {!! $errors->first('full_name', '<small  class="text-danger error-hint">:message</small>') !!}

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="dob" class="text-right col-sm-3 col-form-label {{ $errors->has('dob') ? 'text-danger' : '' }}">Date of Birth :
                                <span class="sub-label"> (as per HSLC/CBSE exam) </span>
                                </label>
                                <div class="col-sm-3">
                                    <input name="dob" type="date" class="form-control {{ $errors->has('dob') ? 'is-invalid' : '' }}" id="dob" value="{{ old('dob') }}" required>
                                    {!! $errors->first('dob', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="gender" class="text-right col-sm-3 col-form-label align-start {{ $errors->has('gender') ? 'text-danger' : '' }}">Gender :
                                </label>
                                <div class="col-sm-3">
                                    <div class="checkbox {{ $errors->has('gender') ? 'is-invalid' : '' }}">
                                        <label><input name="gender"  {{ old('gender') && old('gender')== 'male'?'checked':'' }} {{ !old('gender')?'checked':'' }}  type="radio" value="male">Male</label>

                                        <label><input name="gender"  {{ old('gender') && old('gender')== 'female'?'checked':'' }}  type="radio" value="female">Female</label>

                                        <label><input name="gender"  {{ old('gender') && old('gender')== 'transgender'?'checked':'' }}  type="radio" value="transgender" >Transgender</label>
                                        {!! $errors->first('gender', '<small  class="text-danger error-hint">:message</small>') !!}
                                    </div>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="category" class="text-right col-sm-3 col-form-label {{ $errors->has('category') ? 'text-danger' : '' }}">Category:</label>
                                <div class="col-sm-8">
                                    <input name="category" type="text" class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}" id="category" value="{{ old('category') }}">
                                    {!! $errors->first('category', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="aadhar" class="text-right col-sm-3 col-form-label  {{ $errors->has('aadhar') ? 'text-danger' : '' }}">Aadhaar No:
                                    <span class="sub-label"> (enclose copy of Aadhaar Card)</span>
                                    </label>
                                <div class="col-sm-8">
                                    <input name="aadhar" type="text" class="form-control {{ $errors->has('aadhaar') ? 'is-invalid' : '' }}" id="aadhar" value="{{ old('aadhar') }}">
                                    {!! $errors->first('aadhaar', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>
                            </div>


                            {{-- INITIAL SECTION ENDS HERE --}}

                            <div class="form-group row">
                                <label for="contact" class="text-right col-sm-3 col-form-label {{ $errors->has('contact_no') ? 'text-danger' : '' }}">Contact No.:</label>
                                <div class="col-sm-3">
                                    <input name="contact_no" type="text" class="form-control {{ $errors->has('contact_no') ? 'is-invalid' : '' }}" id="contact" value="{{ old('contact_no') }}">
                                    {!! $errors->first('contact_no', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>
                                <label for="whatsapp" class="text-right col-sm-2 col-form-label {{ $errors->has('whatsapp_no') ? 'text-danger' : '' }}">Whatsapp No.:</label>
                                <div class="col-sm-3">
                                    <input name="whatsapp_no" type="text" class="form-control" id="whatsapp" value="{{ old('whatsapp_no') }}">
                                    {!! $errors->first('whatsapp_no', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="lastschool" class="text-right col-sm-3 col-form-label {{ $errors->has('last_school') ? 'text-danger' : '' }}">Last School Attended:</label>
                                <div class="col-sm-8">
                                    <input name="last_school" type="text" class="form-control {{ $errors->has('last_school') ? 'is-invalid' : '' }}" id="lastschool" value="{{ old('last_school') }}">
                                    {!! $errors->first('last_school', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="hslc_result" class="text-right col-sm-3 col-form-label {{ $errors->has('hslc_result') ? 'text-danger' : '' }}">Result of HSLC Exam:
                                    <span class="sub-label"> (enclose copy of Marksheet and Admit Card)</span></label>
                                <div class="col-sm-8">
                                    <input name="hslc_result" type="text" class="form-control {{ $errors->has('hslc_result') ? 'is-invalid' : '' }}" id="hslc_result" value="{{ old('hslc_result') }}">
                                    {!! $errors->first('hslc_result', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="father" class="text-right col-sm-3 col-form-label {{ $errors->has('father_name') ? 'text-danger' : '' }}">Father's name:</label>
                                <div class="col-sm-3">
                                    <input name="father_name" type="text" class="form-control {{ $errors->has('father_name') ? 'is-invalid' : '' }}" id="father" value="{{ old('father_name') }}">
                                    {!! $errors->first('father_name', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>
                                <label for="father_occupation" class="text-right col-sm-2 col-form-label {{ $errors->has('father_occupation') ? 'text-danger' : '' }}">Occupation:</label>
                                <div class="col-sm-3">
                                    <input name="father_occupation" type="text" class="form-control {{ $errors->has('father_occupation') ? 'is-invalid' : '' }}" id="father_occupation" value="{{ old('father_occupation') }}">
                                    {!! $errors->first('father_occupation', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mother" class="text-right col-sm-3 col-form-label {{ $errors->has('mother_name') ? 'text-danger' : '' }}">Mother's name:</label>
                                <div class="col-sm-3">
                                    <input name="mother_name" type="text" class="form-control {{ $errors->has('mother_name') ? 'is-invalid' : '' }}" id="mother" value="{{ old('mother_name') }}">
                                    {!! $errors->first('mother_name', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>

                                <label for="mother_occupation" class="text-right col-sm-2 col-form-label {{ $errors->has('mother_occupation') ? 'text-danger' : '' }}">Occupation:</label>
                                <div class="col-sm-3">
                                    <input name="mother_occupation" type="text" class="form-control {{ $errors->has('mother_occupation') ? 'is-invalid' : '' }}" id="mother_occupation" value="{{ old('mother_occupation') }}">
                                    {!! $errors->first('mother_occupation', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="present_address" class="text-right col-sm-3 col-form-label {{ $errors->has('present_address') ? 'text-danger' : '' }}">Present Address:</label>
                                <div class="col-sm-8">
                                    <textarea id="present_address"  class="form-control {{ $errors->has('present_address') ? 'is-invalid' : '' }}" name="present_address">{{ old('present_address') }}</textarea>
                                    {!! $errors->first('present_address', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="permanent_address" class="text-right col-sm-3 col-form-label {{ $errors->has('permanent_address') ? 'text-danger' : '' }}">Permanent Address:</label>
                                <div class="col-sm-8">
                                    <textarea  id="permanent_address" class="form-control {{ $errors->has('permanent_address') ? 'is-invalid' : '' }}" name="permanent_address">{{ old('permanent_address') }}</textarea>
                                    {!! $errors->first('permanent_address', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="town" class="text-right col-sm-3 col-form-label {{ $errors->has('village_town') ? 'text-danger' : '' }}">Village/Town:</label>
                                <div class="col-sm-3">
                                    <input name="village_town" type="text" class="form-control {{ $errors->has('village_town') ? 'is-invalid' : '' }}" id="town" value="{{ old('village_town') }}">
                                    {!! $errors->first('village_town', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>

                                <label for="district" class="text-right col-sm-2 col-form-label {{ $errors->has('district') ? 'text-danger' : '' }}">District:</label>
                                <div class="col-sm-3">
                                    <input name="district" type="text" class="form-control {{ $errors->has('district') ? 'is-invalid' : '' }}" id="district" value="{{ old('district') }}">
                                    {!! $errors->first('district', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>

                            </div>
                            <div class="form-group row">

                            </div>
                            <div class="form-group row">
                                <label for="state" class="text-right col-sm-3 col-form-label {{ $errors->has('state') ? 'text-danger' : '' }}">State:</label>
                                <div class="col-sm-3">
                                    <input name="state" type="text" class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" id="state" value="{{ old('state') }}">
                                    {!! $errors->first('state', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>

                                <label for="pin" class="text-right col-sm-2 col-form-label {{ $errors->has('pin') ? 'text-danger' : '' }}">Pin Code:</label>
                                <div class="col-sm-3">
                                    <input name="pin" type="text" class="form-control {{ $errors->has('pin') ? 'is-invalid' : '' }}" id="pin" value="{{ old('pin') }}">
                                    {!! $errors->first('pin', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="email" class="text-right col-sm-3 col-form-label {{ $errors->has('email') ? 'text-danger' : '' }}">Email:</label>
                                <div class="col-sm-8">
                                    <input name="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" value="{{ old('email') }}">
                                    {!! $errors->first('email', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-9 offset-sm-2">
                                <div class="checkbox">
                                    <label style="align-items: unset"><input name="is_declared" required type="checkbox" value="true" style="position: relative;top: 5px;">
                                        I declare that the information provided above is true to the best of my knowledge and I shall be responsible for any misinformation and shall readily accept any form of penalty given to me by the Directorate for providing misinformation.</label>
                                    {!! $errors->first('is_declared', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-sm-12 text-center  pb-3 pt-4">
                                    {!! $errors->first('main_error', '<small  class="text-danger error-hint pb-3">:message</small>') !!}
                                    <button type="reset" class="btn btn-warning">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>

                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Register End -->

        </div>
    </div>
    <!-- Inner Content Start -->


@endsection