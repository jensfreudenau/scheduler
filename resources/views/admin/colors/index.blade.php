@extends('admin.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="page-title">@lang('quickadmin.colors.name')</h3>
            @can('color-create')
                <p>
                    <a href="{{ route('admin.colors.create') }}"
                       class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
                </p>
            @endcan
            <div class="card card-default">
                @if ($color = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $color }}</p>
                    </div>
                @endif
                <div class="card-body table-responsive">
                    <table
                        class="table table-striped {{ count($colors) > 0 ? 'datatable' : '' }} @can('color-delete') dt-select @endcan">
                        <thead>
                        <tr>
                            <th>@lang('quickadmin.users.fields.color')</th>
                            <th>@lang('quickadmin.colors.fields.name')</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($colors) > 0)
                            @foreach ($colors as $color)
                                <tr data-entry-id="{{ $color->id }}">
                                    <td><span style="font-size: 1.5em; color: {{ $color->text }};">
                                          <i class="fas fa-user"></i>
                                        </span></td>
                                    <td>{{ $color->description }}</td>
                                    <td>
                                        <a href="{{ route('admin.colors.show',[$color->id]) }}"
                                           class="btn btn-sm btn-primary">@lang('quickadmin.qa_view')</a>
                                        @can('color-edit')
                                            <a href="{{ route('admin.colors.edit',[$color->id]) }}"
                                               class="btn btn-sm btn-info">@lang('quickadmin.qa_edit')</a>
                                        @endcan
                                        @can('color-delete')
                                            {!! Form::open(array(
                                                'style' => 'display: inline-block;',
                                                'method' => 'DELETE',
                                                'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                                'route' => ['admin.colors.destroy', $color->id])) !!}
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
