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
                     <div class="card-title pull-left">Sys Settings</div>
                        <a href="{{ route('sys_settings.sys_setting.create') }}">
                        <button class="btn btn-labeled btn-green mb-2  pull-right" type="button">
                           <span class="btn-label"><i class="fa fa-plus"></i>
                           </span>Add New</button>
                        </a>
                    </div>
                    <div class="card-body">
                <table class="table table-striped " id="datatable-sysSettings">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Key</th>
                            <th>Value</th>
                            <th>Published</th>

                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($sysSettings))
                    @foreach($sysSettings as $sysSetting)
                        <tr>
                            <td>{{ ucfirst($sysSetting->type) }}</td>
                            <td>{{ $sysSetting->key }}</td>
                            <td>{{ $sysSetting->type == 'policy'? 'HTML CONTENT...' : $sysSetting->value }}</td>
                            <td>{{ ($sysSetting->published) ? 'No' : 'Yes' }}</td>

                            <td>

                                <form method="POST" action="{!! route('sys_settings.sys_setting.destroy', $sysSetting->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('sys_settings.sys_setting.show', $sysSetting->id ) }}" class="btn btn-info  btn-sm" title="Show Sys Setting">
                                            <span class="fa fa-eye" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('sys_settings.sys_setting.edit', $sysSetting->id ) }}" class="btn btn-primary  btn-sm" title="Edit Sys Setting">
                                            <span class="fa fa-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete Sys Setting" onclick="return confirm(&quot;Delete Sys Setting?&quot;)">
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

    $('#datatable-sysSettings').DataTable({
        'paging': true, // Table pagination
        'ordering': true, // Column ordering
        'info': true, // Bottom left status text
        responsive: true,
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