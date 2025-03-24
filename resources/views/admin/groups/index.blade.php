@extends('admin.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="page-title">@lang('quickadmin.groups.name')</h3>
            @can('group-create')
                <p>
                    <a href="{{ route('admin.groups.create') }}"
                       class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
                </p>
            @endcan
            <div class="card card-default">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                @if ($message = Session::get('errors'))
                    <div class="alert alert-danger">
                        <p>@lang($message)</p>
                    </div>
                @endif
                <div class="card-body table-responsive">
                    <table
                        class="table {{ count($groups) > 0 ? 'datatable' : '' }} @can('group-delete') dt-select @endcan">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>@lang('quickadmin.groups.fields.name')</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @if (count($groups) > 0)
                            @foreach ($groups as $group)
                                <tr data-entry-id="{{ $group->id }}">
                                    <td></td>
                                    <td>{{ $group->name }}</td>
                                    <td>
                                        <a href="{{ route('admin.groups.show',[$group->id]) }}"
                                           class="btn btn-sm btn-primary">@lang('quickadmin.qa_view')</a>
                                        @can('group-edit')
                                            <a href="{{ route('admin.groups.edit',[$group->id]) }}"
                                               class="btn btn-sm btn-info">@lang('quickadmin.qa_edit')</a>
                                        @endcan
                                        @can('group-delete')
                                            {!! Form::open(array(
                                                'style' => 'display: inline-block;',
                                                'method' => 'DELETE',
                                                'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                                'route' => ['admin.groups.destroy', $group->id])) !!}
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
