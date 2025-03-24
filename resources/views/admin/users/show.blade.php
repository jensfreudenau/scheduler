@extends('admin.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="page-title">@lang('quickadmin.users.show')</h3>
            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>@lang('quickadmin.users.fields.name')</th>
                                    <td>{{ $user->name }}
                                        </td>
                                </tr>
                                <tr>
                                    <th>@lang('quickadmin.users.fields.email')</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('quickadmin.users.fields.group')</th>
                                    <td>{{ $user->group->name }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('quickadmin.users.fields.role')</th>
                                    <td> @if(!empty($user->getRoleNames()))
                                            @foreach($user->getRoleNames() as $v)
                                                <label class="badge badge-success">{{ $v }}</label>
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                    <a href="{{ route('admin.users.index') }}"
                       class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
                </div>
            </div>
        </div>
    </div>


@stop
