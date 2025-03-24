@extends('admin.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="page-title">@lang('quickadmin.roles.edit')</h3>

    {!! Form::model($role, ['method' => 'PUT', 'route' => ['admin.roles.update', $role->id]]) !!}

    <div class="card card-default">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 form-group">
                    {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
                    {!! Form::text('name', old('Name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '', 'readonly'=>'readonly']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
                <div class="col-sm-12 form-group">
                    {!! Form::label('permission', 'Permission*', ['class' => 'control-label']) !!}
                    <br />
                    @foreach($permission as $value)
                        <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                            {{ $value->name }}</label>
                        <br/>
                    @endforeach
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
            </div>
            {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
            <a href="{{ route('admin.roles.index') }}"
               class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
    </div>
    </div>


@stop

