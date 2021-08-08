
<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
    <label for="title" class="col-md-2 control-label">Title</label>
    <div class="col-md-10">
        <input class="form-control" name="title" type="text" id="title" value="{{ old('title', optional($businessCategory)->title) }}" minlength="1" maxlength="255" placeholder="Enter title here...">
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
    <label for="parent_id" class="col-md-2 control-label">Parent</label>
    <div class="col-md-10">
        <select class="form-control" id="parent_id" name="parent_id">
        	    <option value="" style="display: none;" {{ old('parent_id', optional($businessCategory)->parent_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select parent</option>
        	@foreach ($parents as $key => $parent)
			    <option value="{{ $key }}" {{ old('parent_id', optional($businessCategory)->parent_id) == $key ? 'selected' : '' }}>
			    	{{ $parent }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('parent_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('published') ? 'has-error' : '' }}">
    <label for="published" class="col-md-2 control-label">Published</label>
    <div class="col-md-10">
        <select class="form-control" id="published" name="published">
        	    <option value="" style="display: none;" {{ old('published', optional($businessCategory)->published ?: '') == '' ? 'selected' : '' }} disabled selected>Enter published here...</option>
        	@foreach (['1' => 'True',
'0' => 'False'] as $key => $text)
			    <option value="{{ $key }}" {{ old('published', optional($businessCategory)->published ?: '1') == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('published', '<p class="help-block">:message</p>') !!}
    </div>
</div>
{{--
<div class="form-group {{ $errors->has('context_id') ? 'has-error' : '' }}">
    <label for="context_id" class="col-md-2 control-label">Context</label>
    <div class="col-md-10">
        <select class="form-control" id="context_id" name="context_id">
        	    <option value="" style="display: none;" {{ old('context_id', optional($businessCategory)->context_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select context</option>
        	@foreach ($contexts as $key => $context)
			    <option value="{{ $key }}" {{ old('context_id', optional($businessCategory)->context_id) == $key ? 'selected' : '' }}>
			    	{{ $context }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('context_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
--}}

<div class="form-group {{ $errors->has('sort') ? 'has-error' : '' }}">
    <label for="sort" class="col-md-2 control-label">Sort</label>
    <div class="col-md-10">
        <input class="form-control" name="sort" type="text" id="sort" value="{{ old('sort', optional($businessCategory)->sort) }}" min="-2147483648" max="2147483647" placeholder="Enter sort here...">
        {!! $errors->first('sort', '<p class="help-block">:message</p>') !!}
    </div>
</div>

