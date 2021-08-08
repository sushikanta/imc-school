

<input class="form-control" name="id" type="hidden" id="title" value="{{ old('title', optional($user)->id) }}" minlength="1" maxlength="255" placeholder="Enter title here...">


<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    <label for="email" class="col-md-2 control-label">Email</label>
    <div class="col-md-10">
        <input class="form-control" name="email" type="email" id="email" value="{{ old('email', optional($user)->email) }}" minlength="1" placeholder="Enter Email here...">
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>



<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
    <label for="email" class="col-md-2 control-label">Password</label>
    <div class="col-md-10">
        <input class="form-control" name="password" type="text" id="password" value="" minlength="1" placeholder="Leave it if you do not want to change...">
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('firstname') ? 'has-error' : '' }}">
    <label for="published" class="col-md-2 control-label">First Name</label>
    <div class="col-md-10">
<input name="firstname"  class="form-control" value="{{old('firstname',optional($user)->firstname)}}" minlength="1" placeholder="Enter First Name here...">
        {!! $errors->first('published', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('lastname') ? 'has-error' : '' }}">
    <label for="lastname" class="col-md-2 control-label">Last Name</label>
    <div class="col-md-10">
        <input class="form-control" name="lastname" type="text" id="lastname" value="{{ old('lastname', optional($user)->lastname) }}" minlength="1" placeholder="Enter Last Name here...">
        {!! $errors->first('lastname', '<p class="help-block">:message</p>') !!}
    </div>

    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
        <label for="published" class="col-md-2 control-label">Status</label>
        <div class="col-md-10">
            <select class="form-control" id="published" name="status">
                <option value="" style="display: none;" {{ old('status', optional($user)->status ?: '') == '' ? 'selected' : '' }} disabled selected>Enter Status here...</option>
                @foreach (\App\User::$status_lbl as $key => $text)
                    <option value="{{ $key }}" {{ old('status', optional($user)->status ?: '1') == $key ? 'selected' : '' }}>
                        {{ $text }}
                    </option>
                @endforeach
            </select>

            {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>

