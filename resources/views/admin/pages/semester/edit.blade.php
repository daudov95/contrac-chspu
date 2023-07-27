@extends('admin.layouts.app')


@section('page_title') Изменение семестра @endsection


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
            <h3 class="card-title">Изменение семестра</h3>
            </div>

            
            <form method="POST" action="{{ route('admin.semester.update') }}" enctype="multipart/form-data">
                @CSRF
                <input type="hidden" name="id" value="{{ $semester->id }}">
                <div class="card-body">

                    <div class="form-group">
                        <label for="semester">Семестр</label>
                        <select name="semester" id="semester" class="form-control">
                            <option value>Выберите семестр</option>
                            <option value="1" {{ $semester->semester == 1 ? "selected" : ""}}>Первый</option>
                            <option value="2" {{ $semester->semester == 2 ? "selected" : "" }}>Второй</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="year">Год</label>
                        <select name="year" id="year" class="form-control">
                            <option value>Выберите год</option>
                            @for ($i = 1; $i < 4; $i++)
                                <option value="{{ (date("Y")-2) +$i }}" {{ $semester->year == ((date("Y")-2) +$i) ? "selected" : "" }}>{{ (date("Y")-2) +$i }}</option>
                            @endfor
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