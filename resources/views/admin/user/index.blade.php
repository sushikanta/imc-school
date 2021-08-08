@extends('layouts.app')
@section('content')
    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <span class="fa fa-check"></span>
            {!! session('success_message') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
@endif
    <div class="panel panel-default">
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title pull-left">Client List</div>
                        <!--<a href="{{ url('admin/users/index') }}">
                            <button class="btn btn-labeled btn-green mb-2  pull-right" type="button">
                           <span class="btn-label"><i class="fa fa-plus"></i>
                           </span>Add New Client</button>
                        </a>-->
                    </div>

                    <form method="get" action="{{url('admin/users/index')}}" id="edit_countries_form"  accept-charset="UTF-8" class="">
                        <section class="card-header ">
                            <div class="row">
                                <div class="col-md-12">

                                        <div class="form-group row">
                                            <div class="col-md-10">
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <input class="form-control" id="search"
                                                               value="{{ request('search') }}"
                                                               placeholder="Enter Search Keyword" name="search"
                                                               type="text" id="search"/>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <select class="form-control" id="published" name="status">
                                                            <option value="">Please select </option>
                                                            @foreach (\App\User::$status_lbl as $key => $text)
                                                                <option value="{{ $key }}"  {{request('status')==$key?'selected':''}}  >
                                                                    {{ $text }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    <div class="form-group row">
                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <button type="submit" class="btn btn-warning" >  Search </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <input type="hidden" value="{{request('field')}}" name="field"/>
                        <input type="hidden" value="{{request('sort')}}" name="sort"/>
                    </form>



                    <div class="card-body">
                        <table class="table table-striped " id="datatable-countriesObjects">
                            <thead>
                            <tr>
                                <th><a href="{{url('admin/users/index')}}?search={{request('search')}}&field=users.id&sort={{request('sort','asc')=='asc'?'desc':'asc'}}" class="text-white">
                                        ID  
                                    </a>{!! request('field')=='users.id'?(request('sort','asc')=='asc'?'&#9652;':'&#9662;'):'' !!}
                                </th>
                                <th>  <a href="{{url('admin/users/index')}}?search={{request('search')}}&field=users.email&sort={{request('sort','asc')=='asc'?'desc':'asc'}}"  class="text-white">
                                        Email    </a> {!! request('field')=='users.email'?(request('sort','asc')=='asc'?'&#9652;':'&#9662;'):'' !!}</th>
                                <th><a href="{{url('admin/users/index')}}?search={{request('search')}}&field=users.firstname&sort={{request('sort','asc')=='asc'?'desc':'asc'}}"  class="text-white">
                                        First Name    
                                    </a> {!! request('field')=='users.firstname'?(request('sort','asc')=='asc'?'&#9652;':'&#9662;'):'' !!}</th>
                                <th><a href="{{url('admin/users/index')}}?search={{request('search')}}&field=users.lastname&sort={{request('sort','asc')=='asc'?'desc':'asc'}}"  class="text-white">
                                        Last Name 
                                    </a> {!! request('field')=='users.lastname'?(request('sort','asc')=='asc'?'&#9652;':'&#9662;'):'' !!}</th>
								 <th><a href="{{url('admin/users/index')}}?search={{request('search')}}&field=users.status&sort={{request('sort','asc')=='asc'?'desc':'asc'}}"  class="text-white">
                                        Status
                                    </a> {!! request('field')=='users.status'?(request('sort','asc')=='asc'?'&#9652;':'&#9662;'):'' !!}</th>	
									
                                <th><a href="{{url('admin/users/index')}}?search={{request('search')}}&field=users.created_at&sort={{request('sort','asc')=='asc'?'desc':'asc'}}"  class="text-white">
                                        Registered Date 
                                    </a>{!! request('field')=='users.created_at'?(request('sort','asc')=='asc'?'&#9652;':'&#9662;'):'' !!} </th>

                                <th class="text-right">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($users))
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ ($user->firstname)}}</td>
                                        <td>{{ $user->lastname }}</td>
										 <td>{{ ucfirst($user->status) }}</td>
                                        <td>{{ date("F j, Y, g:i A", strtotime($user->created_at))   }}</td>
                                        <td>

                                            <form method="POST" action="{!! route('users.user.destroy', $user->id) !!}" accept-charset="UTF-8">
											   <input name="type" value="client" type="hidden">
                                                <input name="_method" value="DELETE" type="hidden">
                                                {{ csrf_field() }}
												<div class="btn-group btn-group-xs pull-right" role="group">
													<button value="{{$user->id}}" class="btn  ajaxpopup btn-info  btn-xs" type="button" data-toggle="modal" data-target="#myModalLarge"><span class="fa fa-eye" aria-hidden="true"></span></button>

													<a href="{{ route('users.user.edit', $user->id ) }}" class="btn btn-primary  btn-xs" title="Edit Users">
                                                        <span class="fa fa-pencil" aria-hidden="true"></span>
                                                    </a>

                                                    <button type="submit" class="btn btn-danger  btn-xs" title="Delete User" onclick="return confirm(&quot;Are you sure? all associated record will be deleted permanently&quot;)">
                                                        <span class="fa fa-trash" aria-hidden="true"></span>
                                                    </button>
                                                </div>

                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <ul class="pagination justify-content-end">
                            {{ $users->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
	

@endsection


@section('popup')

<div class="modal fade" id="myModalLarge" tabindex="-1" role="dialog" aria-labelledby="myModalLabelLarge" aria-hidden="true">
<div class="modal-dialog modal-lg" style="min-width:900px;">
 <div class="modal-content">
	<div class="modal-header">
	   <h4 class="modal-title" id="myModalLabelLarge">Client Detail</h4>
	   <button class="close" type="button" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
	   </button>
	</div>
	<div class="modal-body" id="displaycontent" >Please wait...</div>
	<div class="modal-footer">
	   <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
	</div>
 </div>
</div>
</div>

@endsection

@section('javascript')
<script type="text/javascript">
 $(function() {
//twitter bootstrap script
 $(".ajaxpopup").click(function(){
	 
	 $("#displaycontent").html('');
		id=  $(this).val();
		$.ajax({
			url: "{{url('admin/users/clientdetails')}}",
			type: "post",
			data: {id: id ,"_token": "{{ csrf_token() }}" },
			success: function(result) {
				$("#displaycontent").html(result);
			}
		});	
 });
 });
</script>

@endsection