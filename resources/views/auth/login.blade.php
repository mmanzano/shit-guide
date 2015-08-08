@extends('layout.layout_without_call_to_action')

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="forms">
        <form method="POST" action="{{ route('login') }}">
            {!! csrf_field() !!}

            <div>
                <label class="input-label" for="email">
                    {{ ucfirst(trans('gottashit.form.email')) }}
                </label>
                <input class="input" type="email" name="email" value="{{ old('email') }}" id="email">
            </div>

            <div>
                <label class="input-label" for="password">
                    {{ ucfirst(trans('gottashit.form.password')) }}
                </label>
                <input class="input" type="password" name="password" id="password">
            </div>

            <div class="checkbox-margin-top">
                <input class="input checkbox" type="checkbox" name="remember" id="remember"> <label class="checkbox-label" for="remember">{{ ucfirst(trans('gottashit.form.remember_me')) }}</label>
            </div>

            <div>
                <button class="button" type="submit">{{ ucfirst(trans('gottashit.form.login')) }}</button>
            </div>

            <div>
                <a class="forgot-password" href="{{ route('password_email') }}">{{ ucfirst(trans('gottashit.form.forgot_password')) }}</a>
            </div>
        </form>
    </div>
@endsection

