@extends('admin.layouts.app')


@section('page_title') Изменение критерии @endsection


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
            <h3 class="card-title">Изменение критерии</h3>
            </div>

            
            <form method="POST" action="{{ route('admin.criteria.update') }}" enctype="multipart/form-data">
                @CSRF
                <input type="hidden" name="id" value="{{ $criteria->id }}">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Наименование</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $criteria->name }}" placeholder="Введите наименование">
                    </div>

                    <div class="form-group">
                        <label for="short_name">Короткое наименование</label>
                        <input type="text" class="form-control" id="short_name" name="short_name" value="{{ $criteria->short_name }}" placeholder="Введите наименование">
                    </div>

                    <div class="form-group">
                        <label for="semester">Семестр</label>
                        <select name="semester_id" id="semester" class="form-control">
                            <option value>Выберите семестр</option>
                            @foreach ($semesters as $semester)
                                <option value="{{ $semester->id }}" {{ $criteria->semester_id == $semester->id ? "selected" : "" }}>{{ $semester->year .'/'. $semester->semester }}</option>
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