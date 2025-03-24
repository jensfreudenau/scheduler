@extends('admin.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="page-title">@lang('quickadmin.roles.name')</h3>
            @can('role-create')
                <p>
                    <a href="{{ route('admin.roles.create') }}"
                       class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
                </p>
            @endcan
            <div class="card card-default">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div class="card-body table-responsive">
                    <table class="table {{ count($roles) > 0 ? 'datatable' : '' }} @can('role_delete') dt-select @endcan">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>@lang('quickadmin.roles.fields.name')</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($roles) > 0)
                            @foreach ($roles as $role)
                                <tr data-entry-id="{{ $role->id }}">
                                    <td></td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        <a href="{{ route('admin.roles.show',[$role->id]) }}"
                                           class="btn btn-sm btn-primary">@lang('quickadmin.qa_view')</a>
                                        @can('role-edit')
                                            <a href="{{ route('admin.roles.edit',[$role->id]) }}"
                                               class="btn btn-sm btn-info">@lang('quickadmin.qa_edit')</a>
                                        @endcan
                                        @can('role-delete')
                                            {!! Form::open(array(
                                                'style' => 'display: inline-block;',
                                                'method' => 'DELETE',
                                                'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                                'route' => ['admin.roles.destroy', $role->id])) !!}
                                            {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-sm btn-danger')) !!}
                                            {!! Form::close() !!}
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">@lang('quickadmin.qa_no_entries_in_table')</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
