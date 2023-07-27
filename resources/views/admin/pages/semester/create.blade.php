@extends('admin.layouts.app')


@section('page_title') Создание семестра @endsection


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
            <h3 class="card-title">Создание семестра</h3>
            </div>

            
            <form method="POST" action="{{ route('admin.semester.store') }}" enctype="multipart/form-data">
                @CSRF
                <div class="card-body">
                    <div class="form-group">
                        <label for="semester">Семестр</label>
                        <select name="semester" id="semester" class="form-control">
                            <option value>Выберите семестр</option>
                            <option value="1">Первый</option>
                            <option value="2">Второй</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="year">Год</label>
                        <select name="year" id="year" class="form-control">
                            <option value>Выберите год</option>
                            @for ($i = 1; $i < 4; $i++)
                                <option value="{{ (date("Y")-2) +$i }}">{{ (date("Y")-2) +$i }}</option>
                            @endfor
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