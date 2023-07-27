@extends('admin.layouts.app')

@section('page_title') Настройки @endsection

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

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Настройки</h3>
            </div>
            
            <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                @CSRF
                <input type="hidden" name="id" value="{{ $settings->id }}">
                <div class="card-body">
                    <div class="form-group">
                        <label for="year">Текущий год</label>
                        <select name="year" id="year" class="form-control">
                            <option value>Выберите год</option>
                            @foreach ($semesters->unique('year') as $semester)
                                <option value="{{ $semester->year }}" {{ $settings->year == $semester->year ? 'selected' : null }}>{{ $semester->year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="semester">Текущий семестр</label>
                        <select name="semester" id="semester" class="form-control">
                            <option value>Выберите семестр</option>
                            <option value="1" {{ $settings->semester == 1 ? 'selected' : null }}>Первый</option>
                            <option value="2" {{ $settings->semester == 2 ? 'selected' : null }}>Второй</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="allow" name="allow" {{ $settings->active == 1 ? 'checked' : null}}>
                            <label class="custom-control-label" for="allow">Принимать ответы</label>
                        </div>
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

@section('custom_script')
    <script src="{{ asset("assets/js/admin.js") }}"></script>
@endsection