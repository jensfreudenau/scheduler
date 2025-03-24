@extends('admin.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="page-title">@lang('quickadmin.messages.name')</h3>
            @can('message_create')
                <p>
                    <a href="{{ route('admin.messages.create') }}"
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
                    <table
                        class="table table-striped {{ count($messages) > 0 ? 'datatable' : '' }} @can('message_delete') dt-select @endcan">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>@lang('quickadmin.messages.fields.name')</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @if (count($messages) > 0)

                            @foreach ($messages as $message)
                                <tr data-entry-id="{{ $message->id }}">
                                    <td></td>
                                    <td>{{ $message->text }}</td>
                                    <td>
                                        <a href="{{ route('admin.messages.show',[$message->id]) }}"
                                           class="btn btn-sm btn-primary">@lang('quickadmin.qa_view')</a>
                                        @can('message_edit')
                                            <a href="{{ route('admin.messages.edit',[$message->id]) }}"
                                               class="btn btn-sm btn-info">@lang('quickadmin.qa_edit')</a>
                                        @endcan
                                        @can('message_delete')
                                            {!! Form::open(array(
                                                'style' => 'display: inline-block;',
                                                'method' => 'DELETE',
                                                'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                                'route' => ['admin.messages.destroy', $message->id])) !!}
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
