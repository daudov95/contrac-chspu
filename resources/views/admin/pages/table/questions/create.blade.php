@extends('admin.layouts.app')


@section('page_title') Создание показателя @endsection


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
            <h3 class="card-title">Создание показателя</h3>
            </div>

            
            <form method="POST" action="{{ route('admin.table.question.store') }}" enctype="multipart/form-data">
                @CSRF
                <input type="hidden" name="table_id" value="{{ $table->id }}">
                <div class="card-body">
                    <div class="form-group">
                        <label for="text">Текст</label>
                        <textarea class="form-control" rows="3" id="text" name="text" placeholder="Введите текст" style="height: 82px;">{{ old('text') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="options">Варианты (Для переноса строк надо ставить символ "|" между строк)</label>
                        <textarea class="form-control" rows="3" id="options" name="options" placeholder="Введите варианты" style="height: 82px;">{{ old('options') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="type">Вид деятельности</label>
                        <select name="type" id="type" class="form-control">
                            <option value>Выбрать</option>
                            <option value="1" {{ old('type') == 1 ? "selected" : ""}}>Научно-исследовательская и инновационная деятельность</option>
                            <option value="2" {{ old('type') == 2 ? "selected" : ""}}>Образовательная деятельность</option>
                            <option value="3" {{ old('type') == 3 ? "selected" : ""}}>Организационно-воспитательная и иная деятельность</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="curator_id">Ответственный</label>
                        <select name="curator_id" id="curator_id" class="form-control">
                            <option value>Выбрать</option>
                            @foreach ($curators as $curator)
                                <option value="{{ $curator->id }}" {{ old('curator_id') == $curator->id ? "selected" : ""}}>{{ $curator->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="order">Позиция в таблице</label>
                        <input type="number" class="form-control" id="order" name="order" value="{{ old('order') ?? 1 }}" placeholder="Введите позицию в таблице">
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