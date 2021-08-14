@extends('layouts.app')

@section('content')

    <div class="panel panel-default">

        <div class="panel-heading clearfix">
            
            <span class="pull-left">
                <h4>Create New Registrations</h4>
            </span>

            <div class="btn-group btn-group-sm pull-right" role="group">
            <a href="{{ route('registrations.registrations.index') }}" title="Show All Registrations">
                                <button class="btn btn-labeled btn-green mb-2" type="button">
                                       <span class="btn-label"><i class="fa fa-list"></i>
                                       </span>Show All Registrations</button>
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

            <form method="POST" action="{{ route('registrations.registrations.store') }}" accept-charset="UTF-8" id="create_registrations_form" name="create_registrations_form" class="form-horizontal">
            {{ csrf_field() }}
            @include ('registrations.form', [
                                        'registrations' => null,
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


