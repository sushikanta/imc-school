
<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
    <label for="title" class="col-md-2 control-label">Title</label>
    <div class="col-md-10">
        <input class="form-control" name="title" type="text" id="title" value="{{ old('title', optional($roles)->title) }}" minlength="1" maxlength="255" placeholder="Enter title here...">
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('alias') ? 'has-error' : '' }}">
    <label for="alias" class="col-md-2 control-label">Alias</label>
    <div class="col-md-10">
        <input class="form-control" name="alias" type="text" id="alias" value="{{ old('alias', optional($roles)->alias) }}" minlength="1" placeholder="Enter alias here...">
        {!! $errors->first('alias', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('section') ? 'has-error' : '' }}">
    <label for="section" class="col-md-2 control-label">Section</label>
    <div class="col-md-10">
        <select class="form-control" id="section" name="section">
        	    <option value="" style="display: none;" {{ old('section', optional($roles)->section ?: '') == '' ? 'selected' : '' }} disabled selected>-- SELECT SECTION --</option>
        	@foreach (['frontent' => 'Frontend',
'backend' => 'Backend'] as $key => $text)
			    <option value="{{ $key }}" {{ old('section', optional($roles)->section) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('section', '<p class="help-block">:message</p>') !!}
    </div>
</div>

