@extends('admin.layouts.app')

@section('page_title') Все критерии @endsection

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

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Все критерии</h3>
            </div>
            
            <div class="card-body">
                <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
                                <thead>
                                    <tr>
                                        <th class="sorting sorting_desc">Критерия</th>
                                        <th class="sorting" width="200">Год/Семестер</th>
                                        <th class="sorting" width="200">Действие</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($criterias)
                                        @foreach ($criterias as $criteria)
                                            <tr class="{{ $loop->odd ? 'odd' : 'even' }}">
                                                <td class="dtr-control sorting_1">
                                                    {{ $criteria->name }}
                                                </td>
                                                <td>{{ $criteria->semester->year .'/'.$criteria->semester->semester }}</td>
                                                
                                                <td>
                                                    <div class="table-action"><i class="fa-sharp fa-regular "></i>
                                                        @if (auth()->user()->is_admin || auth()->user()->is_curator)
                                                            <a href="{{ route('admin.criteria.questions', ['criteria' => $criteria->id]) }}"  class="btn btn-block btn-outline-primary table-action__btn-edit criteria__users"><i class="nav-icon fas fa-list-alt"></i></a>
                                                        @endif
                                                        @if (auth()->user()->is_admin || auth()->user()->is_curator)
                                                            <a href="{{ route('admin.criteria.users', ['criteria' => $criteria->id]) }}"  class="btn btn-block btn-outline-primary table-action__btn-edit criteria__users"><i class="nav-icon fas fa-users"></i></a>
                                                        @endif

                                                        @if (auth()->user()->is_admin)
                                                            <a href="{{ route('admin.criteria.edit', ['criteria' => $criteria->id]) }}"  class="btn btn-block btn-outline-primary table-action__btn-edit"><i class="nav-icon fas fa-edit"></i></a>
                                                            <form action="{{ route('admin.criteria.destroy') }}" class="delete-route" method="POST">
                                                                @CSRF
                                                                <input type="hidden" name="id" value="{{ $criteria->id }}">
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
                            {{ $criterias->links() }}
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