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
                        <div class="card-title pull-left">Countries</div>
                        <a href="{{ route('countries.country.create') }}">
                            <button class="btn btn-labeled btn-green mb-2  pull-right" type="button">
                           <span class="btn-label"><i class="fa fa-plus"></i>
                           </span>Add New User</button>
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped " id="datatable-countriesObjects">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Code</th>
                                <th>Published</th>
                                <th>Sort</th>

                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($countriesObjects))
                                @foreach($countriesObjects as $countries)
                                    <tr>
                                        <td>{{ $countries->title }}</td>
                                        <td>{{ $countries->code }}</td>
                                        <td>{{ ($countries->published) ? 'False' : 'True' }}</td>
                                        <td>{{ $countries->sort }}</td>

                                        <td>

                                            <form method="POST" action="{!! route('countries.country.destroy', $countries->id) !!}" accept-charset="UTF-8">
                                                <input name="_method" value="DELETE" type="hidden">
                                                {{ csrf_field() }}

                                                <div class="btn-group btn-group-xs pull-right" role="group">
                                                    <a href="{{ route('countries.country.show', $countries->id ) }}" class="btn btn-info" title="Show Countries">
                                                        <span class="fa fa-eye" aria-hidden="true"></span>
                                                    </a>
                                                    <a href="{{ route('countries.country.edit', $countries->id ) }}" class="btn btn-primary" title="Edit Countries">
                                                        <span class="fa fa-pencil" aria-hidden="true"></span>
                                                    </a>

                                                    <button type="submit" class="btn btn-danger" title="Delete Countries" onclick="return confirm(&quot;Delete Countries?&quot;)">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <!-- Datatables-->
    <link rel="stylesheet" href="{{url('theme-angle')}}/vendor/datatables.net-bs4/css/dataTables.bootstrap4.css">

@endsection
@section('javascript')
    <script src="{{url('theme-angle')}}/vendor/datatables.net/js/jquery.dataTables.js"></script>
    <script src="{{url('theme-angle')}}/vendor/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>

    <script src="{{url('theme-angle')}}/vendor/datatables.net-buttons/js/dataTables.buttons.js"></script>
    <script src="{{url('theme-angle')}}/vendor/datatables.net-buttons-bs/js/buttons.bootstrap.js"></script>
    <script src="{{url('theme-angle')}}/vendor/datatables.net-buttons/js/buttons.colVis.js"></script>
    <script src="{{url('theme-angle')}}/vendor/datatables.net-buttons/js/buttons.flash.js"></script>
    <script src="{{url('theme-angle')}}/vendor/datatables.net-buttons/js/buttons.html5.js"></script>
    <script src="{{url('theme-angle')}}/vendor/datatables.net-buttons/js/buttons.print.js"></script>
    <script src="{{url('theme-angle')}}/vendor/datatables.net-keytable/js/dataTables.keyTable.js"></script>
    <script src="{{url('theme-angle')}}/vendor/datatables.net-responsive/js/dataTables.responsive.js"></script>
    <script src="{{url('theme-angle')}}/vendor/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="{{url('theme-angle')}}/vendor/jszip/dist/jszip.js"></script>
    <script src="{{url('theme-angle')}}/vendor/pdfmake/build/pdfmake.js"></script>
    <script src="{{url('theme-angle')}}/vendor/pdfmake/build/vfs_fonts.js"></script>

    <script>

        $('#datatable-countriesObjects').DataTable({
            'paging': true, // Table pagination
            'ordering': true, // Column ordering
            'info': true, // Bottom left status text
            responsive: true,
            order: [[3, 'desc']],
            columnDefs: [
                { orderable: false, targets: -1 }
            ],
            // Text translation options
            // Note the required keywords between underscores (e.g _MENU_)
            oLanguage: {
                sSearch: 'Search all columns:',
                sLengthMenu: '_MENU_ records per page',
                info: 'Showing page _PAGE_ of _PAGES_',
                zeroRecords: 'Nothing found - sorry',
                infoEmpty: 'No records available',
                infoFiltered: '(filtered from _MAX_ total records)',
                oPaginate: {
                    sNext: '<em class="fa fa-caret-right"></em>',
                    sPrevious: '<em class="fa fa-caret-left"></em>'
                }
            },
            // Datatable Buttons setup
            dom: 'Bfrtip',
            buttons: [
                { extend: 'copy', className: 'btn-green' },
                { extend: 'csv', className: 'btn-green' },
                { extend: 'excel', className: 'btn-green', title: 'XLS-File' },
                { extend: 'pdf', className: 'btn-green', title: $('title').text() },
                { extend: 'print', className: 'btn-green' }
            ]
        });

    </script>
@endsection