@extends('layouts.app')

@section('content')

    <div class="panel panel-default">

        <div class="panel-heading clearfix">
            
            <span class="pull-left">
                <h4>Create New Roles</h4>
            </span>

            <div class="btn-group btn-group-sm pull-right" role="group">
            <a href="{{ route('roles.roles.index') }}" title="Show All Roles">
                                <button class="btn btn-labeled btn-green mb-2" type="button">
                                       <span class="btn-label"><i class="fa fa-list"></i>
                                       </span>Show All Roles</button>
                            </a>
            </div>

        </div>

        <div class="panel-body">
        
            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('roles.roles.store') }}" accept-charset="UTF-8" id="create_roles_form" name="create_roles_form" class="form-horizontal">
            {{ csrf_field() }}
            @include ('roles.form', [
                                        'roles' => null,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Add">
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection


