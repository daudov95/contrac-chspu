@extends('admin.layouts.app')


@section('page_title') Создание критерии @endsection


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
        {{-- {{ print_r(explode('.', request()->route()->getName())) }} --}}

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
            <h3 class="card-title">Создание критерии</h3>
            </div>

            
            <form method="POST" action="{{ route('admin.criteria.store') }}" enctype="multipart/form-data">
                @CSRF
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Наименование</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Введите наименование">
                    </div>

                    <div class="form-group">
                        <label for="short_name">Короткое наименование</label>
                        <input type="text" class="form-control" id="short_name" name="short_name" value="{{ old('short_name') }}" placeholder="Введите наименование">
                    </div>

                    <div class="form-group">
                        <label for="semester">Семестр</label>
                        <select name="semester_id" id="semester" class="form-control">
                            <option value>Выберите семестр</option>
                            @foreach ($semesters as $semester)
                                <option value="{{ $semester->id }}">{{ $semester->year .'/'. $semester->semester }}</option>
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