@extends('admin.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="page-title">@lang('quickadmin.roles.show')</h3>
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>@lang('quickadmin.roles.fields.name')</th>
                                    <td>{{ $role->name }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('quickadmin.roles.fields.permissions')</th>
                                    <td>
                                        @if(!empty($rolePermissions))
                                            @foreach($rolePermissions as $v)
                                                <label class="badge badge-success">{{ $v->name }}</label>
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <a href="{{ route('admin.roles.index') }}"
                       class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
                </div>
            </div>
        </div>
    </div>
@stop
