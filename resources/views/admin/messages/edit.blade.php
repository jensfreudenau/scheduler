@extends('admin.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="page-title">@lang('quickadmin.messages.name')</h3>

            {!! Form::model($message, ['method' => 'PUT', 'route' => ['admin.messages.update', $message->id]]) !!}

            <div class="card card-default">
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
                    {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                    <a href="{{ route('admin.messages.index') }}"
                       class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
                </div>
            </div>
        </div>
    </div>


@stop

