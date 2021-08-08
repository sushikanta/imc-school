
<div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
    <label for="type" class="col-md-2 control-label">Type</label>
    <div class="col-md-10">
        <select class="form-control" id="type" name="type">
        	    <option value="" style="display: none;" {{ old('type', optional($sysSetting)->type ?: '') == '' ? 'selected' : '' }} disabled selected>Enter type here...</option>
        	@foreach (['site' => 'Site',
'policy' => 'Policy',
'contact' => 'Contact'] as $key => $text)
			    <option value="{{ $key }}" {{ old('type', optional($sysSetting)->type) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('key') ? 'has-error' : '' }}">
    <label for="key" class="col-md-2 control-label">Key</label>
    <div class="col-md-10">
        <input class="form-control" name="key" type="text" id="key" value="{{ old('key', optional($sysSetting)->key) }}" minlength="1" placeholder="Enter key here...">
        {!! $errors->first('key', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('value') ? 'has-error' : '' }}">
    <label for="value" class="col-md-2 control-label">Value</label>
    <div class="col-md-10">
        <textarea   class="form-control <?php  echo $sysSetting->type == 'policy'?'tinymce':'' ?>" name="value" cols="50" rows="10" id="value" minlength="1" placeholder="Enter value here...">{{ old('value', optional($sysSetting)->value) }}</textarea>
        {!! $errors->first('value', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description" class="col-md-2 control-label">Description</label>
    <div class="col-md-10">
        <input class="form-control" name="description" type="text" id="description" value="{{ old('description', optional($sysSetting)->description) }}" minlength="1" maxlength="1000">
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('published') ? 'has-error' : '' }}">
    <label for="published" class="col-md-2 control-label">Published</label>
    <div class="col-md-10">
        <select class="form-control" id="published" name="published">
        	    <option value="" style="display: none;" {{ old('published', optional($sysSetting)->published ?: '') == '' ? 'selected' : '' }} disabled selected>Enter published here...</option>
        	@foreach (['1' => 'Yes',
'0' => 'No'] as $key => $text)
			    <option value="{{ $key }}" {{ old('published', optional($sysSetting)->published) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('published', '<p class="help-block">:message</p>') !!}
    </div>
</div>

@section('styles')
    <!-- WYSIWYG-->
    <link rel="stylesheet" href="{{ asset('theme-angle')}}/vendor/bootstrap-wysiwyg/css/style.css">
@endsection
@section('javascript')
    <script src='{{ asset('theme-angle')}}/vendor/tinymce/tinymce.min.js'></script>
    <script>
        tinymce.init({
            selector: '.tinymce',
            menubar:false,
            theme: 'modern',
            plugins: 'code fullscreen image link media  hr pagebreak nonbreaking anchor  insertdatetime advlist lists textcolor wordcount   imagetools     colorpicker textpattern',
            toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat code',
            image_advtab: true,
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'
            ]
        });
    </script>
@endsection