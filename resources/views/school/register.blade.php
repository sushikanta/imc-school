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
            @if(Session::has('success_message'))
                <div class="row">
                    <div class="col-sm-8 offset-2 text-center">
                        <div class="alert alert-success" role="alert">
                            {!! session('success_message') !!}
                            </div>
                    </div>
                </div>
              @endif


            <!-- Register Start -->
            <div class="login-wrap ">
                <div class="contact-info login_box">
                    <div class="contact-form loginWrp registerWrp">
                        <div class="required-tag-line">Fields with <span class="required-tag">*</span> are required.</div>
                            <form method="POST" action="{!! route('register') !!}" class="form-horizontal form-label-left" enctype="multipart/form-data">
                                {{csrf_field()}}


                            {{-- INITIAL SECTION STARTS HERE --}}
<div class="col-md-12 p- 0 row">
    <div class="col-md-9 p- 0">
        <div class="form-group row">
            <label for="fullname" class=" col-sm-4 col-form-label {{ $errors->has('full_name') ? 'text-danger' : '' }} ">Full Name <span class="required-tag">*</span>:</label>
            <div class="col-sm-7">
                <input  name="full_name" type="text" class="form-control  {{ $errors->has('full_name') ? 'is-invalid' : '' }}"
                        id="full_name"
                        value="{{ old('full_name') }}" required minlength="1" maxlength="255">
                {!! $errors->first('full_name', '<small  class="text-danger error-hint">:message</small>') !!}

            </div>
        </div>
        <div class="form-group row">
            <label for="dob" class=" col-sm-4 col-form-label {{ $errors->has('dob') ? 'text-danger' : '' }}">Date of Birth <span class="required-tag">*</span>:
                <span class="sub-label"> (as per HSLC/CBSE exam) </span>
            </label>
            <div class="col-sm-5">
                <input name="dob" type="date" class="form-control {{ $errors->has('dob') ? 'is-invalid' : '' }}" id="dob" value="{{ old('dob') }}" required>
                {!! $errors->first('dob', '<small  class="text-danger error-hint">:message</small>') !!}
            </div>
        </div>

        <div class="form-group row">
            <label for="gender" class="col-sm-4 col-form-label align-start {{ $errors->has('gender') ? 'text-danger' : '' }}">Gender <span class="required-tag">*</span>:
            </label>
            <div class="col-sm-5">
                <div class="checkbox {{ $errors->has('gender') ? 'is-invalid' : '' }}">
                    <label><input name="gender"  {{ old('gender') && old('gender')== 'male'?'checked':'' }} {{ !old('gender')?'checked':'' }}  type="radio" value="male">Male</label>

                    <label><input name="gender"  {{ old('gender') && old('gender')== 'female'?'checked':'' }}  type="radio" value="female">Female</label>

                    <label><input name="gender"  {{ old('gender') && old('gender')== 'transgender'?'checked':'' }}  type="radio" value="transgender" >Transgender</label>
                    {!! $errors->first('gender', '<small  class="text-danger error-hint">:message</small>') !!}
                </div>

            </div>
        </div>
        <div class="form-group row">
            <label for="category" class=" col-sm-4 col-form-label {{ $errors->has('category') ? 'text-danger' : '' }}">Category:</label>
            <div class="col-sm-7">
                <input name="category" type="text" class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}" id="category" value="{{ old('category') }}">
                {!! $errors->first('category', '<small  class="text-danger error-hint">:message</small>') !!}
            </div>
        </div>

        <div class="form-group row">
            <label for="aadhar" class=" col-sm-4 col-form-label  {{ $errors->has('aadhar') ? 'text-danger' : '' }}">Aadhaar No <span class="required-tag">*</span>:
                <span class="sub-label"> (Select Aadhaar to upload)</span>
            </label>
            <div class="col-sm-7">

                <input name="aadhar" type="text" required class="form-control {{ $errors->has('aadhaar') ? 'is-invalid' : '' }}" id="aadhar" value="{{ old('aadhar') }}">

            </div>
        </div>

        <div class="form-group row">
            <label for="aadhar" class=" col-sm-4 col-form-label "></label>
            <div class="col-sm-7 file-container" style="display: flex;">
                <input name="aadhar-file" type="file" class="form-control file {{ $errors->has('aadhar-file') ? 'is-invalid' : '' }}" >
                <button type="button" class="browse btn btn-primary btn-small" style="min-width: 122px;"><i class="fas fa-file-import"></i> Select Aadhar</button><span class="required-tag">*</span>
                <label class="file-lbl"></label>
                {!! $errors->first('file_aadhaar_path', '<small  class="file-lbl text-danger error-hint">:message</small>') !!}
            </div>
        </div>

    </div>
    <div class="col-md-3 mt-2 file-container" style="display: flex; justify-content: space-around; align-content: flex-start;flex-wrap: wrap;">

        <div id="msg"></div>

        <input type="file" name="photo-file" data-type="image" class="file" accept="image/*">
        <div class="input-group   text-center" style="width: 100%;margin-top: 10px;     align-content: center;
    justify-content: center;">
           {{-- <input type="text" class="form-control" disabled="" placeholder="Upload File" id="file" style="width: 57%;">--}}

            <button type="button" class="browse btn btn-primary btn-small">Select Photo</button><span class="required-tag">*</span>
        </div>

        <div class="row text-center" style="margin-top: 15px;    justify-content: space-around;">

            <div class="img-wrapper">
                <div class="img-container photo-preview" id="preview" style=" background: url('{{ asset('theme-school') }}/images/001/profile_photo.jpg');"></div>
            </div>
            <label class="file-lbl"></label>
            {!! $errors->first('file_photo_path', '<small  class="file-lbl text-danger error-hint">:message</small>') !!}
        </div>

    </div>

</div>



                            {{-- INITIAL SECTION ENDS HERE --}}

                            <div class="form-group row">
                                <label for="contact" class="col-sm-3 col-form-label {{ $errors->has('contact_no') ? 'text-danger' : '' }}">Contact No. <span class="required-tag">*</span>:</label>
                                <div class="col-sm-3">
                                    <input name="contact_no" type="text" class="form-control {{ $errors->has('contact_no') ? 'is-invalid' : '' }}" id="contact" value="{{ old('contact_no') }}">
                                    {!! $errors->first('contact_no', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>
                                <label for="whatsapp" class="col-sm-2 col-form-label {{ $errors->has('whatsapp_no') ? 'text-danger' : '' }}">Whatsapp No. <span class="required-tag">*</span>:</label>
                                <div class="col-sm-3">
                                    <input name="whatsapp_no" type="text" class="form-control" id="whatsapp" value="{{ old('whatsapp_no') }}">
                                    {!! $errors->first('whatsapp_no', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="lastschool" class="col-sm-3 col-form-label {{ $errors->has('last_school') ? 'text-danger' : '' }}">Last School Attended <span class="required-tag">*</span>:</label>
                                <div class="col-sm-8">
                                    <input name="last_school" type="text" class="form-control {{ $errors->has('last_school') ? 'is-invalid' : '' }}" id="lastschool" value="{{ old('last_school') }}">
                                    {!! $errors->first('last_school', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="hslc_result" class="col-sm-3 col-form-label {{ $errors->has('hslc_result') ? 'text-danger' : '' }}">Result of HSLC Exam <span class="required-tag">*</span>:
                                    <span class="sub-label"> (enclose copy of Marksheet and Admit Card)</span></label>
                                <div class="col-sm-8">
                                    <input name="hslc_result" type="text" class="form-control {{ $errors->has('hslc_result') ? 'is-invalid' : '' }}" id="hslc_result" value="{{ old('hslc_result') }}">
                                    {!! $errors->first('hslc_result', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>
                            </div>
                                <div class="form-group row">
                                    <label for="marksheet-file" class=" col-sm-3 col-form-label "></label>
                                    <div class="col-sm-7 file-container" style="display: flex;">
                                        <input name="marksheet-file" type="file" class="form-control file {{ $errors->has('marksheet-file') ? 'is-invalid' : '' }}" >
                                        <button type="button"  style="min-width: 148px;" class="browse btn btn-primary btn-small"><i class="fas fa-file-import"></i> Select Marksheet</button><span class="required-tag">*</span>
                                        <label class="file-lbl"></label>
                                        {!! $errors->first('file_hslc_marksheet_path', '<small  class="file-lbl text-danger error-hint">:message</small>') !!}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="admitcard-file" class=" col-sm-3 col-form-label "></label>
                                    <div class="col-sm-7 file-container" style="display: flex;">
                                        <input name="admitcard-file" type="file" class="form-control file {{ $errors->has('admitcard-file') ? 'is-invalid' : '' }}" >
                                        <button type="button" style="min-width: 148px;" class="browse btn btn-primary btn-small"><i class="fas fa-file-import"></i> Select Admit Card</button><span class="required-tag">*</span>
                                        <label class="file-lbl"></label>
                                        {!! $errors->first('file_hslc_admitcard_path', '<small  class="file-lbl text-danger error-hint">:message</small>') !!}
                                    </div>
                                </div>


                                <div class="form-group row">
                                <label for="father" class="col-sm-3 col-form-label {{ $errors->has('father_name') ? 'text-danger' : '' }}">Father's name <span class="required-tag">*</span>:</label>
                                <div class="col-sm-3">
                                    <input name="father_name" type="text" class="form-control {{ $errors->has('father_name') ? 'is-invalid' : '' }}" id="father" value="{{ old('father_name') }}">
                                    {!! $errors->first('father_name', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>
                                <label for="father_occupation" class="col-sm-2 col-form-label {{ $errors->has('father_occupation') ? 'text-danger' : '' }}">Occupation <span class="required-tag">*</span>:</label>
                                <div class="col-sm-3">
                                    <input name="father_occupation" type="text" class="form-control {{ $errors->has('father_occupation') ? 'is-invalid' : '' }}" id="father_occupation" value="{{ old('father_occupation') }}">
                                    {!! $errors->first('father_occupation', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mother" class=" col-sm-3 col-form-label {{ $errors->has('mother_name') ? 'text-danger' : '' }}">Mother's name <span class="required-tag">*</span>:</label>
                                <div class="col-sm-3">
                                    <input name="mother_name" type="text" class="form-control {{ $errors->has('mother_name') ? 'is-invalid' : '' }}" id="mother" value="{{ old('mother_name') }}">
                                    {!! $errors->first('mother_name', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>

                                <label for="mother_occupation" class=" col-sm-2 col-form-label {{ $errors->has('mother_occupation') ? 'text-danger' : '' }}">Occupation <span class="required-tag">*</span>:</label>
                                <div class="col-sm-3">
                                    <input name="mother_occupation" type="text" class="form-control {{ $errors->has('mother_occupation') ? 'is-invalid' : '' }}" id="mother_occupation" value="{{ old('mother_occupation') }}">
                                    {!! $errors->first('mother_occupation', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="present_address" class="col-sm-3 col-form-label {{ $errors->has('present_address') ? 'text-danger' : '' }}">Present Address <span class="required-tag">*</span>:</label>
                                <div class="col-sm-8">
                                    <textarea id="present_address"  class="form-control {{ $errors->has('present_address') ? 'is-invalid' : '' }}" name="present_address">{{ old('present_address') }}</textarea>
                                    {!! $errors->first('present_address', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="permanent_address" class="col-sm-3 col-form-label {{ $errors->has('permanent_address') ? 'text-danger' : '' }}">Permanent Address <span class="required-tag">*</span>:</label>
                                <div class="col-sm-8">
                                    <textarea  id="permanent_address" class="form-control {{ $errors->has('permanent_address') ? 'is-invalid' : '' }}" name="permanent_address">{{ old('permanent_address') }}</textarea>
                                    {!! $errors->first('permanent_address', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="town" class=" col-sm-3 col-form-label {{ $errors->has('village_town') ? 'text-danger' : '' }}">Village/Town <span class="required-tag">*</span>:</label>
                                <div class="col-sm-3">
                                    <input name="village_town" type="text" class="form-control {{ $errors->has('village_town') ? 'is-invalid' : '' }}" id="town" value="{{ old('village_town') }}">
                                    {!! $errors->first('village_town', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>

                                <label for="district" class="col-sm-2 col-form-label {{ $errors->has('district') ? 'text-danger' : '' }}">District <span class="required-tag">*</span>:</label>
                                <div class="col-sm-3">
                                    <input name="district" type="text" class="form-control {{ $errors->has('district') ? 'is-invalid' : '' }}" id="district" value="{{ old('district') }}">
                                    {!! $errors->first('district', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>

                            </div>
                            <div class="form-group row">

                            </div>
                            <div class="form-group row">
                                <label for="state" class="col-sm-3 col-form-label {{ $errors->has('state') ? 'text-danger' : '' }}">State <span class="required-tag">*</span>:</label>
                                <div class="col-sm-3">
                                    <input name="state" type="text" class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" id="state" value="{{ old('state') }}">
                                    {!! $errors->first('state', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>

                                <label for="pin" class="col-sm-2 col-form-label {{ $errors->has('pin') ? 'text-danger' : '' }}">Pin Code <span class="required-tag">*</span>:</label>
                                <div class="col-sm-3">
                                    <input name="pin" type="text" class="form-control {{ $errors->has('pin') ? 'is-invalid' : '' }}" id="pin" value="{{ old('pin') }}">
                                    {!! $errors->first('pin', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="email" class=" col-sm-3 col-form-label {{ $errors->has('email') ? 'text-danger' : '' }}">Email <span class="required-tag">*</span>:</label>
                                <div class="col-sm-8">
                                    <input name="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email" value="{{ old('email') }}">
                                    {!! $errors->first('email', '<small  class="text-danger error-hint">:message</small>') !!}
                                </div>
                            </div>


                                <div class="form-group row">
                                    <label for="stream" class="col-sm-3 col-form-label align-start {{ $errors->has('stream') ? 'text-danger' : '' }}">Apply For <span class="required-tag">*</span>:
                                    </label>
                                    <div class="col-sm-5">
                                        <div class="checkbox {{ $errors->has('stream') ? 'is-invalid' : '' }}">
                                            <label><input onchange="changeStream('science')" name="stream"  {{ old('stream') && old('stream')== 'science'?'checked':'' }} {{ !old('science')?'checked':'' }}  type="radio" value="science">Science</label>
                                            <label><input onchange="changeStream('arts')" name="stream"  {{ old('stream') && old('stream')== 'arts'?'checked':'' }}  type="radio" value="arts">Arts</label>
                                            {!! $errors->first('stream', '<small  class="text-danger error-hint">:message</small>') !!}
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group row subject-options stream-section stream-science">
                                    <label for="suboffered" class=" col-sm-3 col-form-label {{ $errors->has('selected_subject') ? 'text-danger' : '' }}">Subjects offered <span class="required-tag">*</span>:</label>
                                    <div class="col-sm-9 row">
                                        <div class="col-sm-4 ">
                                            <label class="col-form-label align-start"><input name="selected_subject"  {{ old('selected_subject') && old('selected_subject')== 'sc-a'?'checked':'' }} {{ !old('selected_subject')?'checked':'' }}  type="radio" value="sc-a">
                                           Science Stream (A)</label>
                                            <ul class="subject-list">
                                                <li>English</li>
                                                <li>MIL/Alt. English</li>
                                                <li>Physics</li>
                                                <li>Chemistry</li>
                                                <li>Biology</li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-4 ">
                                            <label class="col-form-label align-start"><input name="selected_subject"  {{ old('selected_subject') && old('selected_subject')== 'sc-b'?'checked':'' }}  type="radio" value="sc-b">
                                                Science Stream (B)</label>
                                            <ul class="subject-list">
                                                <li>English</li>
                                                <li>MIL/Alt. English</li>
                                                <li>Physics</li>
                                                <li>Chemistry</li>
                                                <li>Maths</li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-4 ">
                                            <label class="col-form-label align-start"><input name="selected_subject"  {{ old('selected_subject') && old('selected_subject')== 'sc-c'?'checked':'' }} type="radio" value="sc-c">
                                                Science Stream (C)</label>
                                            <ul class="subject-list">
                                                <li>English</li>
                                                <li>MIL/Alt. English</li>
                                                <li>Physics</li>
                                                <li>Chemistry</li>
                                                <li>Biology	/ Computer Science / Maths  / Home Science</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row subject-options stream-section stream-arts" style="display: none">
                                    <label for="email" class=" col-sm-3 col-form-label {{ $errors->has('selected_subject') ? 'text-danger' : '' }}">Subjects offered <span class="required-tag">*</span>:</label>
                                    <div class="col-sm-9 row">
                                        <div class="col-sm-4 ">
                                            <label class="col-form-label align-start"><input name="selected_subject"  {{ old('selected_subject') && old('selected_subject')== 'arts-a'?'checked':'' }}    type="radio" value="arts-a">
                                                Arts Stream (A)</label>
                                            <ul class="subject-list">
                                                <li>English</li>
                                                <li>MIL/Alt. English</li>
                                                <li>Pol. Science</li>
                                                <li>History</li>
                                                <li>Economy</li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-4 ">
                                            <label class="col-form-label align-start"><input name="selected_subject"  {{ old('selected_subject') && old('selected_subject')== 'arts-b'?'checked':'' }}  type="radio" value="arts-b">
                                                Arts Stream (B)</label>
                                            <ul class="subject-list">
                                                <li>English</li>
                                                <li>MIL/Alt. English</li>
                                                <li>Pol. Science</li>
                                                <li>History</li>
                                                <li>Education/Geography</li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-4 ">
                                            <label class="col-form-label align-start"><input name="selected_subject"  {{ old('selected_subject') && old('selected_subject')== 'arts-c'?'checked':'' }}  type="radio" value="arts-c">
                                                Arts Stream (C)</label>
                                            <ul class="subject-list">
                                                <li>English</li>
                                                <li>MIL/Alt. English</li>
                                                <li>Pol. Science</li>
                                                <li>History</li>
                                                <li>Sociology/ Anthropology</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group row">
                                <div class="col-sm-9 offset-sm-2">
                                <div class="checkbox">
                                    <label style="align-items: unset"><input name="is_declared" required type="checkbox" value="true" style="position: relative;top: 5px;"><span class="required-tag">*</span>
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

@section('scripts')
    <script type="application/javascript">

        $(".browse").on('click', function() {
            var _this = $(this);
            var container = _this.closest(".file-container");
            container.find(".file").trigger("click");
        })

        $('input[type="file"]').change(function(e) {
            var _this = $(this);
            var fileName = e.target.files[0].name;
            var container = _this.closest(".file-container");
            var fileLbl = container.find('.file-lbl');
            if(fileLbl.length){
                fileLbl.text(fileName)
            }

            if(_this.attr('data-type')== 'image'){
                var reader = new FileReader();
                reader.onload = function(e) {
                    var previewElem = container.find('.photo-preview');
                    if(previewElem.length){
                        // get loaded data and render thumbnail.
                        previewElem.css("background-image", "url(" + e.target.result + ")");
                    }
                };
                // read the image file as a data URL.
                reader.readAsDataURL(this.files[0]);
            }

        });
        $(".stream-arts").hide();
        function changeStream(type){
            $(".stream-section").hide();
            if(type=='science'){
                $(".stream-science").show();
                $("input[name=selected_subject][value=sc-a]").prop('checked', true);
            }else{
                $(".stream-arts").show();
                $("input[name=selected_subject][value=arts-a]").prop('checked', true);
            }
        }

    </script>
@endsection