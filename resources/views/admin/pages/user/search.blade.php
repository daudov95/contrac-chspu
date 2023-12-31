@extends('admin.layouts.app')


@section('page_title') Поиск пользователя @endsection


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

            
            <form method="GET" action="{{ route('admin.user.search') }}" enctype="multipart/form-data">
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

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Найденные пользователи</h3>
    </div>
    
    <div class="card-body">
        <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <div class="row">
                <div class="col-sm-12 table-scroll">
                    <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
                        <thead>
                            <tr>
                                <th class="sorting sorting_desc">ФИО</th>
                                <th class="sorting" width="200">Роль</th>
                                <th class="sorting" width="200">Действие</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($users))
                                @foreach ($users as $user)
                                    <tr class="{{ $loop->odd ? 'odd' : 'even' }}">
                                        <td class="dtr-control sorting_1">
                                            {{ $user->name }}
                                        </td>
                                        <td>{{ $user->role }}</td>
                                        
                                        <td>
                                            <div class="table-action">
                                                <a href="{{ route('admin.user.edit', ['user' => $user->id]) }}"  class="btn btn-block btn-outline-primary table-action__btn-edit"><i class="nav-icon fas fa-edit"></i></a>
                                                <form action="{{ route('admin.user.destroy') }}" class="delete-route" method="POST">
                                                    @CSRF
                                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                                    <button type="submit" class="delete-btn btn btn-block btn-outline-danger table-action__btn-delete"><i class="nav-icon far fa-trash-alt"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                            @endif
                        </tbody>
                        
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 col-md-12">
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('custom_script')
    <script>
        const reset = document.querySelector('.reset-form');

        reset.addEventListener('click', e => {
            e.preventDefault();
            console.log('test');

            window.location = "{{ route('admin.user.search') }}";
        })

    </script>
@endsection