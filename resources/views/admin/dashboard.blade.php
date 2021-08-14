@extends('layouts.app')
@section('content')
        <!-- Page content-->
        <div class="content-wrapper">
            <div class="content-heading">
                <div>Dashboard
                    <small data-localize="dashboard.WELCOME"></small>
                </div>
                <!-- END Language list-->
            </div>
			
			
			<div class="row">
               <div class="col-xl-3 col-md-6">
                  <!-- START card-->
                   <a href="{{route('registrations.registrations.index')}}">
                  <div class="card flex-row align-items-center align-items-stretch border-0">
                     <div class="col-3 d-flex align-items-center bg-primary-dark justify-content-center rounded-left">
                        <em class="icon-briefcase fa-3x"></em>
                     </div>
                     <div class="col-9 py-3 bg-primary rounded-right">
                        <div class="h2 mt-0">{{$registrationCount}}</div>
                        <div class="text-uppercase">Total Registrations (Class XI)</div>
                     </div>
                  </div>
                   </a>
               </div>
            </div>
        </div>
@endsection


