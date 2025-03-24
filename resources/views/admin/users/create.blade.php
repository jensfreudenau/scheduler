@extends('admin.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="page-title">@lang('quickadmin.users.new')</h3>
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
            {!! Form::open(['method' => 'POST', 'route' => ['admin.users.store']]) !!}

            <div class="card card-default">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            {!! Form::label('name', 'Name*', ['class' => 'control-label']) !!}
                            {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('name'))
                                <p class="help-block">
                                    {{ $errors->first('name') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            {!! Form::label('email', 'Email*', ['class' => 'control-label']) !!}
                            {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('email'))
                                <p class="help-block">
                                    {{ $errors->first('email') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            {!! Form::label('password', 'Password*', ['class' => 'control-label']) !!}
                            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('password'))
                                <p class="help-block">
                                    {{ $errors->first('password') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            {!! Form::label('role_id', 'Role*', ['class' => 'control-label']) !!}
                            {!! Form::select('roles', $roles, old('role_id'), ['class' => 'form-control select2', 'required' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('role_id'))
                                <p class="help-block">
                                    {{ $errors->first('role_id') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            {!! Form::label('group_id', 'Group*', ['class' => 'control-label']) !!}
                            {!! Form::select('group_id', $groups, old('group_id'), ['class' => 'form-control select2', 'required' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('group_id'))
                                <p class="help-block">
                                    {{ $errors->first('group_id') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                    <a href="{{ route('admin.users.index') }}"
                       class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/jquery/jquery.min.js') }}{{  "?dt=".time()  }}"></script>
        <script src="{{ asset('js/bootstrap/js/bootstrap.min.js') }}" defer></script>
        <script src="{{ asset('js/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>

    @endpush
@stop

