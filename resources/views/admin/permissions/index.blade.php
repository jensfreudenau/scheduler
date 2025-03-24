@extends('admin.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="page-title">@lang('quickadmin.permissions.name')</h3>

{{--            @can('permission-create')--}}
                <p>
                    <a href="{{ route('admin.permissions.create') }}"
                       class="btn btn-success">@lang('quickadmin.qa_add_new')</a>

                </p>
{{--            @endcan--}}

            <div class="card card-default">
                <div class="card-body table-responsive">
                    <table
                        class="table {{ count($permissions) > 0 ? 'datatable' : '' }} @can('permission-delete') dt-select @endcan">
                        <thead>
                        <tr>
                            <th>@lang('quickadmin.permissions.fields.name')</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>

                        <tbody>
                        @if (count($permissions) > 0)
                            @foreach ($permissions as $permission)
                                <tr data-entry-id="{{ $permission->id }}">
                                    @can('permission-delete')
                                        <td></td>
                                    @endcan

                                    <td>{{ $permission->name }}</td>
                                    <td>
                                        @can('permission-edit')
                                            <a href="{{ route('admin.permissions.edit',[$permission->id]) }}"
                                               class="btn btn-sm btn-info">@lang('quickadmin.qa_edit')</a>
                                        @endcan
                                        @can('permission-delete')
                                            {!! Form::open(array(
                                                'style' => 'display: inline-block;',
                                                'method' => 'DELETE',
                                                'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                                'route' => ['admin.permissions.destroy', $permission->id])) !!}
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
