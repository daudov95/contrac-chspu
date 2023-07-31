@extends('admin.layouts.app')


@section('page_title') Создание куратора @endsection


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
            <h3 class="card-title">Создание куратора</h3>
            </div>

            
            <form method="POST" action="{{ route('admin.curator.store') }}" enctype="multipart/form-data">
                @CSRF
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Имя</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Введите имя">
                    </div>

                    <div class="form-group">
                        <label for="user">Пользователь</label>

                        <select name="user_id" id="user" class="form-control select-2">
                            <option value>Выберите пользователя</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
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
        $('.select-2').select2({});
    </script>
@endsection