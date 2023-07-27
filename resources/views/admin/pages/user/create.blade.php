@extends('admin.layouts.app')


@section('page_title') Создание пользователя @endsection


@section('content')

<style>
    .table-action {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .table-action__btn-edit {
        width: 50px;
    }
    .table-action__btn-delete {
        width: 50px;
        margin-top: 0 !important;
        margin-left: 10px;
    }
</style>

    
<div class="row">
    <div class="col-12">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin-bottom: 0px">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card card-primary">
            <div class="card-header">
            <h3 class="card-title">Создание пользователя</h3>
            </div>

            
            <form method="POST" action="{{ route('admin.user.store') }}" enctype="multipart/form-data">
                @CSRF
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">ФИО</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Введите имя">
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Введите E-mail">
                    </div>

                    <style>
                        #password_generate {
                            position: absolute;
                            top: 0;
                            right: 0;
                            cursor: pointer;
                            font-weight: bold;
                        }
                    </style>

                    <div class="form-group" style="position: relative">
                        <label for="password">Пароль</label>
                        <span id="password_generate">Генерировать</span>
                        <input type="text" class="form-control" id="password" name="password" value="{{ old('password') }}" placeholder="Введите пароль">
                    </div>

                    <div class="form-group">
                        <label for="rank">Должность</label>
                        <input type="text" class="form-control" id="rank" name="rank" value="{{ old('rank') }}" placeholder="Введите должность">
                    </div>


                    <div class="form-group">
                        <label for="table_id">Категория</label>
                        <select name="table_id" id="table_id" class="form-control">
                            <option value>Выберите категорию</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name . ' ('.$category->semester->semester. '/'.$category->semester->year. ')' }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_curator" name="is_curator">
                            <label class="custom-control-label" for="is_curator">Куртор</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_admin" name="is_admin">
                            <label class="custom-control-label" for="is_admin">Админ</label>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Создать</button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection

@section('custom_script')
    <script>
        const password_generate = document.querySelector('#password_generate');
        const password = document.querySelector('#password');
        password_generate.addEventListener('click', function(e) {
            const newPass = gen_password(10);
            password.value = newPass;
        });


        function gen_password(len){
            let password = "";
            let symbols = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!_";
            for (let i = 0; i < len; i++){
                password += symbols.charAt(Math.floor(Math.random() * symbols.length));     
            }
            return password;
        }

    </script>
@endsection