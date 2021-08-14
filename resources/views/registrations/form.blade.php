
<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    <label for="email" class="col-md-2 control-label">Email</label>
    <div class="col-md-10">
        <input class="form-control" name="email" type="email" id="email" value="{{ old('email', optional($registrations)->email) }}" placeholder="Enter email here...">
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('full_name') ? 'has-error' : '' }}">
    <label for="full_name" class="col-md-2 control-label">Full Name</label>
    <div class="col-md-10">
        <input class="form-control" name="full_name" type="text" id="full_name" value="{{ old('full_name', optional($registrations)->full_name) }}" minlength="1" placeholder="Enter full name here...">
        {!! $errors->first('full_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('dob') ? 'has-error' : '' }}">
    <label for="dob" class="col-md-2 control-label">Dob</label>
    <div class="col-md-10">
        <input class="form-control" name="dob" type="text" id="dob" value="{{ old('dob', optional($registrations)->dob) }}" minlength="1" placeholder="Enter dob here...">
        {!! $errors->first('dob', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
    <label for="gender" class="col-md-2 control-label">Gender</label>
    <div class="col-md-10">
        <input class="form-control" name="gender" type="text" id="gender" value="{{ old('gender', optional($registrations)->gender) }}" minlength="1" placeholder="Enter gender here...">
        {!! $errors->first('gender', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
    <label for="category" class="col-md-2 control-label">Category</label>
    <div class="col-md-10">
        <input class="form-control" name="category" type="text" id="category" value="{{ old('category', optional($registrations)->category) }}" minlength="1" placeholder="Enter category here...">
        {!! $errors->first('category', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('aadhar') ? 'has-error' : '' }}">
    <label for="aadhar" class="col-md-2 control-label">Aadhar</label>
    <div class="col-md-10">
        <input class="form-control" name="aadhar" type="text" id="aadhar" value="{{ old('aadhar', optional($registrations)->aadhar) }}" minlength="1" placeholder="Enter aadhar here...">
        {!! $errors->first('aadhar', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('contact_no') ? 'has-error' : '' }}">
    <label for="contact_no" class="col-md-2 control-label">Contact No</label>
    <div class="col-md-10">
        <input class="form-control" name="contact_no" type="text" id="contact_no" value="{{ old('contact_no', optional($registrations)->contact_no) }}" minlength="1" placeholder="Enter contact no here...">
        {!! $errors->first('contact_no', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('whatsapp_no') ? 'has-error' : '' }}">
    <label for="whatsapp_no" class="col-md-2 control-label">Whatsapp No</label>
    <div class="col-md-10">
        <input class="form-control" name="whatsapp_no" type="text" id="whatsapp_no" value="{{ old('whatsapp_no', optional($registrations)->whatsapp_no) }}" minlength="1" placeholder="Enter whatsapp no here...">
        {!! $errors->first('whatsapp_no', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('last_school') ? 'has-error' : '' }}">
    <label for="last_school" class="col-md-2 control-label">Last School</label>
    <div class="col-md-10">
        <input class="form-control" name="last_school" type="text" id="last_school" value="{{ old('last_school', optional($registrations)->last_school) }}" minlength="1" placeholder="Enter last school here...">
        {!! $errors->first('last_school', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('hslc_result') ? 'has-error' : '' }}">
    <label for="hslc_result" class="col-md-2 control-label">Hslc Result</label>
    <div class="col-md-10">
        <input class="form-control" name="hslc_result" type="text" id="hslc_result" value="{{ old('hslc_result', optional($registrations)->hslc_result) }}" minlength="1" placeholder="Enter hslc result here...">
        {!! $errors->first('hslc_result', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('father_name') ? 'has-error' : '' }}">
    <label for="father_name" class="col-md-2 control-label">Father Name</label>
    <div class="col-md-10">
        <input class="form-control" name="father_name" type="text" id="father_name" value="{{ old('father_name', optional($registrations)->father_name) }}" minlength="1" placeholder="Enter father name here...">
        {!! $errors->first('father_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('father_occupation') ? 'has-error' : '' }}">
    <label for="father_occupation" class="col-md-2 control-label">Father Occupation</label>
    <div class="col-md-10">
        <input class="form-control" name="father_occupation" type="text" id="father_occupation" value="{{ old('father_occupation', optional($registrations)->father_occupation) }}" minlength="1" placeholder="Enter father occupation here...">
        {!! $errors->first('father_occupation', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('mother_name') ? 'has-error' : '' }}">
    <label for="mother_name" class="col-md-2 control-label">Mother Name</label>
    <div class="col-md-10">
        <input class="form-control" name="mother_name" type="text" id="mother_name" value="{{ old('mother_name', optional($registrations)->mother_name) }}" minlength="1" placeholder="Enter mother name here...">
        {!! $errors->first('mother_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('mother_occupation') ? 'has-error' : '' }}">
    <label for="mother_occupation" class="col-md-2 control-label">Mother Occupation</label>
    <div class="col-md-10">
        <input class="form-control" name="mother_occupation" type="text" id="mother_occupation" value="{{ old('mother_occupation', optional($registrations)->mother_occupation) }}" minlength="1" placeholder="Enter mother occupation here...">
        {!! $errors->first('mother_occupation', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('present_address') ? 'has-error' : '' }}">
    <label for="present_address" class="col-md-2 control-label">Present Address</label>
    <div class="col-md-10">
        <input class="form-control" name="present_address" type="text" id="present_address" value="{{ old('present_address', optional($registrations)->present_address) }}" minlength="1" placeholder="Enter present address here...">
        {!! $errors->first('present_address', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('permanent_address') ? 'has-error' : '' }}">
    <label for="permanent_address" class="col-md-2 control-label">Permanent Address</label>
    <div class="col-md-10">
        <input class="form-control" name="permanent_address" type="text" id="permanent_address" value="{{ old('permanent_address', optional($registrations)->permanent_address) }}" minlength="1" placeholder="Enter permanent address here...">
        {!! $errors->first('permanent_address', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('village_town') ? 'has-error' : '' }}">
    <label for="village_town" class="col-md-2 control-label">Village Town</label>
    <div class="col-md-10">
        <input class="form-control" name="village_town" type="number" id="village_town" value="{{ old('village_town', optional($registrations)->village_town) }}" placeholder="Enter village town here...">
        {!! $errors->first('village_town', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('district') ? 'has-error' : '' }}">
    <label for="district" class="col-md-2 control-label">District</label>
    <div class="col-md-10">
        <input class="form-control" name="district" type="text" id="district" value="{{ old('district', optional($registrations)->district) }}" minlength="1" placeholder="Enter district here...">
        {!! $errors->first('district', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('state') ? 'has-error' : '' }}">
    <label for="state" class="col-md-2 control-label">State</label>
    <div class="col-md-10">
        <input class="form-control" name="state" type="text" id="state" value="{{ old('state', optional($registrations)->state) }}" minlength="1" placeholder="Enter state here...">
        {!! $errors->first('state', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('pin') ? 'has-error' : '' }}">
    <label for="pin" class="col-md-2 control-label">Pin</label>
    <div class="col-md-10">
        <input class="form-control" name="pin" type="text" id="pin" value="{{ old('pin', optional($registrations)->pin) }}" minlength="1" placeholder="Enter pin here...">
        {!! $errors->first('pin', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('file_photo_path') ? 'has-error' : '' }}">
    <label for="file_photo_path" class="col-md-2 control-label">File Photo Path</label>
    <div class="col-md-10">
        <input class="form-control" name="file_photo_path" type="text" id="file_photo_path" value="{{ old('file_photo_path', optional($registrations)->file_photo_path) }}" minlength="1" placeholder="Enter file photo path here...">
        {!! $errors->first('file_photo_path', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('file_hslc_admitcard_path') ? 'has-error' : '' }}">
    <label for="file_hslc_admitcard_path" class="col-md-2 control-label">File Hslc Admitcard Path</label>
    <div class="col-md-10">
        <input class="form-control" name="file_hslc_admitcard_path" type="text" id="file_hslc_admitcard_path" value="{{ old('file_hslc_admitcard_path', optional($registrations)->file_hslc_admitcard_path) }}" minlength="1" placeholder="Enter file hslc admitcard path here...">
        {!! $errors->first('file_hslc_admitcard_path', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('file_hslc_marksheet_path') ? 'has-error' : '' }}">
    <label for="file_hslc_marksheet_path" class="col-md-2 control-label">File Hslc Marksheet Path</label>
    <div class="col-md-10">
        <input class="form-control" name="file_hslc_marksheet_path" type="text" id="file_hslc_marksheet_path" value="{{ old('file_hslc_marksheet_path', optional($registrations)->file_hslc_marksheet_path) }}" minlength="1" placeholder="Enter file hslc marksheet path here...">
        {!! $errors->first('file_hslc_marksheet_path', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('file_aadhaar_path') ? 'has-error' : '' }}">
    <label for="file_aadhaar_path" class="col-md-2 control-label">File Aadhaar Path</label>
    <div class="col-md-10">
        <input class="form-control" name="file_aadhaar_path" type="text" id="file_aadhaar_path" value="{{ old('file_aadhaar_path', optional($registrations)->file_aadhaar_path) }}" minlength="1" placeholder="Enter file aadhaar path here...">
        {!! $errors->first('file_aadhaar_path', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('stream') ? 'has-error' : '' }}">
    <label for="stream" class="col-md-2 control-label">Stream</label>
    <div class="col-md-10">
        <input class="form-control" name="stream" type="text" id="stream" value="{{ old('stream', optional($registrations)->stream) }}" minlength="1" placeholder="Enter stream here...">
        {!! $errors->first('stream', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('selected_subject') ? 'has-error' : '' }}">
    <label for="selected_subject" class="col-md-2 control-label">Selected Subject</label>
    <div class="col-md-10">
        <input class="form-control" name="selected_subject" type="text" id="selected_subject" value="{{ old('selected_subject', optional($registrations)->selected_subject) }}" minlength="1" placeholder="Enter selected subject here...">
        {!! $errors->first('selected_subject', '<p class="help-block">:message</p>') !!}
    </div>
</div>

