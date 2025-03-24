@extends('admin.app')
@push('styles')
    <link href="{{ asset('css/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="page-title">@lang('quickadmin.colors.name')</h3>
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
                {!! Form::open(['method' => 'POST', 'route' => ['admin.colors.store']]) !!}
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            {!! Form::label('input-lg', 'Color', ['class' => 'control-label']) !!}
                            <div id="cp4" class="input-group" title="Using input value">
                                {!! Form::text('text', old('text'), ['class' => 'form-control input-lg', 'placeholder' => '', 'required' => '']) !!}
                                <span class="input-group-append">
                                    <span class="input-group-text colorpicker-input-addon"><i></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            {!! Form::label('description', 'Name*', ['class' => 'control-label']) !!}
                            {!! Form::text('description', old('description'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('description'))
                                <p class="help-block">
                                    {{ $errors->first('description') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    {!! Form::hidden('guard_name', 'web') !!}
                    {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                    <a href="{{ route('admin.colors.index') }}"
                       class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/jquery/jquery.min.js') }}{{  "?dt=".time()  }}"></script>
        <script src="{{ asset('js/bootstrap/js/bootstrap.min.js') }}" defer></script>
        <script src="{{ asset('js/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
        <script src="{{ asset('js/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}" defer></script>
        <script>
            $(document).ready(function () {
                $('#my-colorpicker1').colorpicker();
                $('#cp4').colorpicker();
            });
        </script>
    @endpush

@stop

