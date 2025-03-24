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
                                    <th>@lang('quickadmin.messages.fields.name')</th>
                                    <td><h3><label class="badge badge-success">{{ $message->text }}</label></h3></td>
                                </tr>

                            </table>
                        </div>
                    </div>
                    <a href="{{ route('admin.messages.index') }}"
                       class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
                </div>
            </div>
        </div>
    </div>
@stop
