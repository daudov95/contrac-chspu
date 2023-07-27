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
        
        <input type="hidden" name="table_id" value="{{ $table->id }}">

        <div class="card">
            <div class="card-header" style="display: flex">
                <h3 class="card-title">Список всех пользователей</h3>
                {{-- <a href="{{ route('admin.table.export', ['table' => $table->id]) }}" style="margin-left: auto">Скачать Excel <i class="nav-icon fas fa-sharp fa-solid fa-file-excel"></i></a> --}}
            </div>
            
            <div class="card-body">
                <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">

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
                                    @if($users)
                                        @foreach ($users as $user)
                                            <tr class="{{ $loop->odd ? 'odd' : 'even' }}" data-id="{{ $user->id }}">
                                                <td style="text-align:center;"><input type="checkbox"></td>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->rank }}</td>
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

            <div class="card-footer">
                <button type="submit" class="btn btn-primary add-user__btn">Добавить в таблицу</button>
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
@endsection