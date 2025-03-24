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
                                    <th>@lang('quickadmin.groups.fields.name')</th>
                                    <td><h3><label class="badge badge-success">{{ $group->name }}</label></h3></td>
                                </tr>
                                <tr>
                                    <th>@lang('quickadmin.groups.fields.groupmembers')</th>
                                    <td>
                                        @if(!empty($users))
                                            @foreach($users as $user)

                                                <a href="{{ route('admin.users.show',[$user->id]) }}">{{ $user->name }}</a><br>
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <a href="{{ route('admin.groups.index') }}"
                       class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
                </div>
            </div>
        </div>
    </div>
@stop
