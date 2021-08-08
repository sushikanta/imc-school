
<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
    <label for="title" class="col-md-2 control-label">Title</label>
    <div class="col-md-10">
        <input class="form-control js-title" name="title" type="text" id="title" value="{{ old('title', optional($category)->title) }}" minlength="1" maxlength="255" placeholder="Enter title here...">
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
    <label for="title" class="col-md-2 control-label">Slug</label>
    <div class="col-md-10">
        <input class="form-control js-slug" name="slug" type="text" id="slug" value="{{ old('slug', optional($category)->slug) }}" minlength="1" maxlength="255" placeholder="Slug will be generated here">
        {!! $errors->first('slug', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('meta_description') ? 'has-error' : '' }}">
    <label for="title" class="col-md-2 control-label">Meta Description</label>
    <div class="col-md-10">
        <input class="form-control" name="meta_description" type="text"value="{{ old('meta_description', optional($category)->meta_description) }}" minlength="1" maxlength="160" placeholder="Enter meta description for SEO purpose">
        {!! $errors->first('meta_description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('meta_keywords') ? 'has-error' : '' }}">
    <label for="title" class="col-md-2 control-label">Meta Keywords</label>
    <div class="col-md-10">
        <input class="form-control" name="meta_keywords" type="text" value="{{ old('meta_keywords', optional($category)->meta_keywords) }}" minlength="1"  placeholder="Enter keywords for SEO purpose">
        {!! $errors->first('meta_keywords', '<p class="help-block">:message</p>') !!}
    </div>
</div>



<div class="form-group {{ $errors->has('published') ? 'has-error' : '' }}">
    <label for="published" class="col-md-2 control-label">Published</label>
    <div class="col-md-10">
        <select class="form-control" id="published" name="published">
        	    <option value="" style="display: none;" {{ old('published', optional($category)->published ?: '') == '' ? 'selected' : '' }} disabled selected>Select published</option>
        	@foreach (['1' => 'True',
'0' => 'False'] as $key => $text)
			    <option value="{{ $key }}" {{ old('published', optional($category)->published) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('published', '<p class="help-block">:message</p>') !!}
    </div>
</div>

