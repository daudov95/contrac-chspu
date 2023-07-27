@extends('admin.layouts.app')

@section('page_title') Критерия: {{ $table->name }} @endsection

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
            <div class="card-header" style="display: flex">
                <h3 class="card-title">Показатели</h3>
                @if (auth()->user()->is_admin)
                <a href="{{ route('admin.table.question.create', ['table' => $table]) }}" style="margin-left: auto">Новый показатель</a>
                @endif
            </div>
            
            <div class="card-body">
                <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
                                <thead>
                                    <tr>
                                        <th class="sorting sorting_desc">Показатель</th>
                                        <th class="sorting" width="300">Варианты</th>
                                        <th class="sorting" width="300">Вид деятельности</th>
                                        <th class="sorting" width="300">Ответственные</th>
                                        @if (auth()->user()->is_admin)
                                            <th class="sorting" width="200">Действие</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($table)
                                        @foreach ($table->questions as $question)
                                            <tr class="{{ $loop->odd ? 'odd' : 'even' }}">
                                                <td class="dtr-control sorting_1">
                                                    {{ $question->text }}
                                                </td>
                                                <td>{{ $question->options }}</td>
                                                <td>{{ $question->typeLabel }}</td>
                                                <td>{{ $question->curator->name }}</td>

                                                @if (auth()->user()->is_admin)
                                                <td>
                                                    <div class="table-action"><i class="fa-sharp fa-regular "></i>
                                                        
                                                            <a href="{{ route('admin.table.question.edit', ['tableQuestion' => $question->id]) }}"  class="btn btn-block btn-outline-primary table-action__btn-edit"><i class="nav-icon fas fa-edit"></i></a>
                                                            <form action="{{ route('admin.table.question.destroy') }}" class="delete-route" method="POST">
                                                                @CSRF
                                                                <input type="hidden" name="id" value="{{ $question->id }}">
                                                                <button type="submit" class="delete-btn btn btn-block btn-outline-danger table-action__btn-delete"><i class="nav-icon far fa-trash-alt"></i></button>
                                                            </form>
                                                        
                                                    </div>
                                                </td>
                                                @endif
                                            </tr>
                                            @endforeach
                                    @endif
                                </tbody>
                                
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            {{-- {{ $questions->links() }} --}}
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