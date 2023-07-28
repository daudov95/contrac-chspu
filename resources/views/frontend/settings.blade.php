@extends('layouts.app')

@section('header')
    @include('frontend.parts.header')
@endsection

@section('content')

<div class="main user-panel">

    <div class="full-container">

        <div class="user-panel__wrap">

            <h1 class="title">Настройки</h1>


            @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success')}}
                </div>
            @endif

            <div class="settings">

                {{-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul style="margin-bottom: 0px">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}

                <div class="settings-fields">
                    <form action="{{ Route('lk.settings.update') }}" method="POST">
                        @CSRF
                        <div class="settings-fields__row">
                            <label for="name" class="settings__label">ФИО</label>
                            <input type="text" id="name" name="name" class="settings__input" value="{{ $user->name }}" placeholder="Ваше ФИО">
                            @error('name')
                                <span class="auth-form-input__invalid" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="settings-fields__row">
                            <label for="email" class="settings__label">E-mail</label>
                            <input type="text" id="email" name="email" class="settings__input" value="{{ $user->email }}" placeholder="Ваш E-mail">
                            @error('email')
                                <span class="auth-form-input__invalid" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="settings-fields__row">
                            <label for="password" class="settings__label">Пароль (Оставить пустым, если пароль не меняется)</label>
                            <input type="text" id="password" name="password" class="settings__input" placeholder="Новый пароль">
                            @error('password')
                                <span class="auth-form-input__invalid" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="settings__btn">Изменить</button>
                    </form>
                </div>
            </div>
        
        </div>
    </div>


    
</div>

@endsection