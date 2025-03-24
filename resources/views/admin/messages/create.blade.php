@extends('admin.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="page-title">@lang('quickadmin.messages.name')</h3>
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
                {!! Form::open(['method' => 'POST', 'route' => ['admin.messages.store']]) !!}
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 form-message">
                            {!! Form::label('text', 'Text*', ['class' => 'control-label']) !!}

                            {!! Form::textarea('text', old('text'), array('class' => 'text')); !!}
                            <p class="help-block"></p>
                            @if($errors->has('text'))
                                <p class="help-block">
                                    {{ $errors->first('text') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    {!! Form::hidden('guard_name', 'web') !!}
                    {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                    <a href="{{ route('admin.messages.index') }}"
                       class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
                </div>
            </div>
        </div>
    </div>


@stop

