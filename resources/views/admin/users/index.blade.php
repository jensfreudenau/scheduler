@extends('admin.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="page-title">@lang('quickadmin.users.title')</h3>
            @can('user-create')
                <p>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
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
                    <table class="table {{ count($users) > 0 ? 'datatable' : '' }} @can('user_delete') dt-select @endcan">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>@lang('quickadmin.users.fields.name')</th>
                            <th>@lang('quickadmin.users.fields.email')</th>
                            <th>@lang('quickadmin.users.fields.role')</th>
                            <th>@lang('quickadmin.users.fields.group')</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($users) > 0)
                            @foreach ($users as $user)
                                <tr data-entry-id="{{ $user->id }}">
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td> @if(!empty($user->getRoleNames()))
                                            @foreach($user->getRoleNames() as $v)
                                                <label class="badge badge-success">{{ $v }}</label>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($user->group->name))
                                            <label class="badge badge-info">{{ $user->group->name }}</label>
                                        @endif
                                    </td>

                                    <td>
                                        @can('user-list')
                                            <a href="{{ route('admin.users.show',[$user->id]) }}"
                                               class="btn btn-sm btn-primary">@lang('quickadmin.qa_view')</a>
                                        @endcan
                                        @can('user-edit')
                                            <a href="{{ route('admin.users.edit',[$user->id]) }}"
                                               class="btn btn-sm btn-info">@lang('quickadmin.qa_edit')</a>
                                        @endcan
                                        @can('user-delete')
                                            {!! Form::open(array(
                                                'style' => 'display: inline-block;',
                                                'method' => 'DELETE',
                                                'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                                'route' => ['admin.users.destroy', $user->id])) !!}
                                            {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-sm btn-danger')) !!}
                                            {!! Form::close() !!}
                                        @endcan

                                    </td>
                                </tr>
                            @endforeach
                            {{ $users->links() }}
                        @else
                            <tr>
                                <td colspan="9">@lang('quickadmin.qa_no_entries_in_table')</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

@stop
