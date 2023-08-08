@extends('admin.layouts.app')

@section('page_title') Все пользователи данного критерия @endsection

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

        <div class="alert alert-primary" role="alert">
            Баллы указаны в форме за: научно-исследовательскую работу/учебную и учебно-метадическую работу/воспитательную и иную работу
        </div>

        <div class="card">
            <div class="card-header" style="display: flex">
                <h3 class="card-title">Все пользователи данного критерия</h3>
                @if (auth()->user()->is_admin)
                <div style="margin-left: auto">
                    {{-- <a href="{{ route('admin.table.users.add', ['table' => $table->id]) }}" style="margin-left: auto; margin-right: 20px;">Добавить пользователей</a> --}}
                    <a href="{{ route('admin.table.export', ['table' => $table->id]) }}" style="margin-left: auto">Скачать Excel <i class="nav-icon fas fa-sharp fa-solid fa-file-excel"></i></a>
                </div>
                @endif
            </div>
            
            <div class="card-body">
                <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 table-scroll">
                            <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
                                <thead>
                                    <tr>
                                        <th class="sorting sorting_desc">ФИО</th>
                                        <th class="sorting" width="600">Должность</th>
                                        <th class="sorting" width="200">Баллы</th>
                                        <th class="sorting" width="200">Действие</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($users)
                                        @foreach ($users as $user)
                                            <tr class="{{ $loop->odd ? 'odd' : 'even' }}">
                                                <td class="dtr-control sorting_1">
                                                    {{ $user->name }}
                                                </td>
                                                <td>{{ $user->rank }}</td>

                                                @php
                                                    $b1 = $type1->where('user_id', $user->id)->sum('points');
                                                    $b2 = $type2->where('user_id', $user->id)->sum('points');
                                                    $b3 = $type3->where('user_id', $user->id)->sum('points');

                                                    $points = "$b1/$b2/$b3"; 
                                                @endphp
                                                <td>{{ $points ? $points : '0/0/0' }}</td>
                                                
                                                <td>
                                                    <div class="table-action">
                                                        <a href="{{ route('admin.table.user', ['user' => $user->id]) }}" target="_blank" class="btn btn-block btn-outline-primary table-action__btn-edit"><i class="nav-icon fas fa-eye"></i></a>
                                                        @if (auth()->user()->is_admin)
                                                            <form action="{{ route('admin.table.users.destroy', ['table' => $table->id]) }}" class="delete-route" method="POST">
                                                                @CSRF
                                                                <input type="hidden" name="id" value="{{ $user->id }}">
                                                                <button type="submit" class="delete-btn btn btn-block btn-outline-danger table-action__btn-delete"><i class="nav-icon far fa-trash-alt"></i></button>
                                                            </form>
                                                        @endif
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
    </div>
</div>    

@endsection

@section('custom_script')
    <script src="{{ asset("assets/js/admin.js") }}"></script>
@endsection