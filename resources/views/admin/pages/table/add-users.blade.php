@extends('admin.layouts.app')

@section('page_title') Добавление пользователей в таблицу @endsection

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
            <h3 class="card-title">Поиск пользователя</h3>
            </div>

            
            <form method="GET" action="{{ route('admin.table.users.add', ['table' => $table->id]) }}" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">ФИО</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ request()->get('name') }}" placeholder="Введите ФИО">
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Поиск</button>
                    <button type="submit" class="btn btn-danger reset-form">Очистить поиск</button>
                </div>
            </form>
        </div>

    </div>
</div>
    
<div class="row">
    <div class="col-12">

        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success')}}
            </div>
        @endif
        
        <input type="hidden" name="table_id" value="{{ $table->id }}">

        <div class="card">
            <div class="card-header" style="display: flex">
                <h3 class="card-title">Список всех пользователей</h3>
            </div>
            
            <div class="card-body">
                <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                            @if(count($users) > 0)
                                <table class="table table-bordered table-hover dataTable dtr-inline table-add-users">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center; width: 50px"><input type="checkbox"></th>
                                            <th style="text-align:center; width: 50px">ID</th>
                                            <th>ФИО</th>
                                            <th>Должность</th>
                                        </tr>	
                                    </thead>
                                    <tbody>
                                        
                                            @foreach ($users as $user)
                                                <tr class="{{ $loop->odd ? 'odd' : 'even' }}" data-id="{{ $user->id }}">
                                                    <td style="text-align:center;"><input type="checkbox"></td>
                                                    <td>{{ $user->id }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->rank }}</td>
                                                </tr>
                                            @endforeach
                                        
                                    </tbody>
                                </table>
                            @else
                                <span>Нет пользователей для добавления</span>
                            @endif
                        </div>
                    </div>

                    @if(count($users) > 0)
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                {{ $users->links() }}
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            <div class="card-footer">
                @if(count($users) > 0)
                    <button type="submit" class="btn btn-primary add-user__btn">Добавить в таблицу</button>
                @endif
                <a href="{{ route('admin.table.users', ['table' => $table->id]) }}" class="btn btn-info">Назад</a>
            </div>
        </div>
    </div>
</div>    

@endsection

@section('custom_script')
    <script src="{{ asset("assets/js/admin.js") }}"></script>
    <script src="{{ asset("assets/js/tableCheckbox.js") }}"></script>

    <script>
        $('.table').checkboxTable();
    </script>

    <script>
        const reset = document.querySelector('.reset-form');

        reset.addEventListener('click', e => {
            e.preventDefault();

            window.location = "{{ route('admin.table.users.add', ['table' => $table->id]) }}";
        })

    </script>
@endsection

