@extends('admin.layouts.app')


@section('page_title') Изменение куратора @endsection


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

        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success')}}
            </div>
        @endif

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
            <h3 class="card-title">Изменение куратора</h3>
            </div>

            
            <form method="POST" action="{{ route('admin.curator.update') }}" enctype="multipart/form-data">
                @CSRF
                <input type="hidden" name="id" value="{{ $curator->id }}">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Наименование</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $curator->name }}" placeholder="Введите наименование">
                    </div>


                    <div class="form-group">
                        <label for="user">Пользователь</label>
                        <select name="user_id" id="user" class="form-control">
                            <option value>Выберите пользователя</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $curator->user_id == $user->id ? "selected" : "" }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Обновить</button>
                </div>
            </form>
        </div>

    </div>
</div>
            

@endsection