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
            Баллы указаны в форме за: научно-исследовательскую и инновационную/образовательную/организационно-воспитательную и иную деятельность
        </div>

        <div class="card">
            <div class="card-header" style="display: flex">
                <h3 class="card-title">Все пользователи данного критерия</h3>
                <a href="{{ route('admin.criteria.export', ['criteria' => $criteria->id]) }}" style="margin-left: auto">Скачать Excel <i class="nav-icon fas fa-sharp fa-solid fa-file-excel"></i></a>
            </div>
            
            <div class="card-body">
                <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
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
                                                    // $all = $user->questions;
                                                    // $type1 = $all->where('type', 1)->all();
                                                    // $type2 = $all->where('type', 2)->all();
                                                    // $type3 = $all->where('type', 3)->all();
                                                    // $ball1 = $user_answers->where('user_id', $user->id)->first();

                                                    // if($ball1) {
                                                    //     $ball1->filter(function (int $value, int $key) {
                                                    //         return $value > 2;
                                                    //     });
                                                    // }

                                                    $b1 = $type1->where('user_id', $user->id)->sum('points');
                                                    $b2 = $type2->where('user_id', $user->id)->sum('points');
                                                    $b3 = $type3->where('user_id', $user->id)->sum('points');

                                                    $points = "$b1/$b2/$b3"; 
                                                    // dd($points);
                                                    // dump($b2);
                                                @endphp
                                                <td>{{ $points ? $points : '0/0/0' }}</td>
                                                
                                                <td>
                                                    <div class="table-action">
                                                        <a href="{{ route('admin.criteria.user', ['user' => $user->id]) }}" target="_blank" class="btn btn-block btn-outline-primary table-action__btn-edit"><i class="nav-icon fas fa-eye"></i></a>
                                                        @if (auth()->user()->is_admin)
                                                            <form action="{{ route('admin.criteria.destroy') }}" class="delete-route" method="POST">
                                                                @CSRF
                                                                <input type="hidden" name="id" value="{{ $user->id }}">
                                                                <button disabled type="submit" class="delete-btn btn btn-block btn-outline-danger table-action__btn-delete"><i class="nav-icon far fa-trash-alt"></i></button>
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