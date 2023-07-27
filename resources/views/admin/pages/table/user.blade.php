@extends('admin.layouts.app')

@section('page_title') Данные пользователя @endsection

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
                <h3 class="card-title">Данные пользователя</h3>
                <input type="hidden" name="user_id" value="{{ $semester_user->id }}">
                <input type="hidden" name="table_id" value="{{ $semester_user->table_id }}">
                <input type="hidden" name="question_id" value="0">
                <input type="hidden" name="question_curator_id" value="0">
                <input type="hidden" name="curator_id" value="{{ Auth::id() }}">
            </div>
            
            <div class="card-body">
                <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
                                <thead>
                                    <tr>
                                        <th class="sorting" width="50">#</th>
                                        <th class="sorting">Показатель</th>
                                        <th class="sorting" width="200">Баллы</th>
                                        <th class="sorting" width="200">Документы</th>
                                        <th class="sorting" width="300">Ответственные</th>
                                        <th class="sorting" width="100">Комментарии</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($semester_user)
                                        @foreach ($semester_user->questions as $k => $question)
                                            <tr id="{{ $question->id }}">
                                                <td>{{ $k+1 }}</td>
                                                <td >{{ $question->text }}</td>
                                                <td class="points" data-id="{{ $question->id }}" data-question_curator_id="{{ $question->curator_id }}">
                                                    @php
                                                        $id = (int)$question->id;
                                                        $points = $semester_user_questions->where('question_id', $id)->first();
                                                        $points = $points ? $points->points : '-';
                                                    @endphp
                                                    {{  $points }}
                                                </td>
                                                <td class="documents" data-id="{{ $question->id }}" data-question_curator_id="{{ $question->curator_id }}">
                                                    @if (count($question->documents) > 0)
                                                        <div class="documents__wrap">
                                                            @foreach ($question->documents as $doc)
                                                                <a href="{{ asset('storage/'. $doc->path) }}" target="_blank" data-document-id="{{ $doc->id }}">{{ $doc->name }}</a>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>{{ $question->curator->name ?? 'Не выбран' }}</td>
                                                <td class="comments" data-id="{{ $question->id }}" data-question_curator_id="{{ $question->curator_id }}" style="text-align: center;">
                                                    <span>
                                                        @php
                                                            $question_info = $semester_user_questions->where('question_id', $question->id)->first();

                                                            // dump($question_info);
                                                        @endphp
                                                        {{ $question_info ? $comments->where('question_id', $question_info->id)->where('user_id', $semester_user->id)->count() : 0 }}
                                                    </span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 114.44" width="20">
                                                        <path d="M34.75 35.84A6.72 6.72 0 1 1 28 42.56a6.72 6.72 0 0 1 6.72-6.72ZM7 0h108.91a7 7 0 0 1 7 7v72.86a7 7 0 0 1-7 7H62.55l-26.41 19.59c-5 4.76-9.47 7.76-12.88 8-5 .3-7.61-3.1-7-11.56v-16H7a7 7 0 0 1-7-7V7a7 7 0 0 1 7-7Zm108.91 6.8H7a.17.17 0 0 0-.2.2v72.86A.17.17 0 0 0 7 80h12.64a3.4 3.4 0 0 1 3.4 3.4v19.49a2.09 2.09 0 0 1 0 .25c-.23 3.15-.27 4.48-.17 4.47 1.67-.1 4.77-2.46 8.75-6.24l.32-.26L59.2 80.87a3.36 3.36 0 0 1 2.24-.87h54.47a.17.17 0 0 0 .17-.17V7a.17.17 0 0 0-.17-.17Zm-55.47 29a6.72 6.72 0 1 1-6.73 6.72 6.72 6.72 0 0 1 6.73-6.72Zm25.69 0a6.72 6.72 0 1 1-6.73 6.72 6.72 6.72 0 0 1 6.73-6.72Z" style="fill-rule:evenodd"/>
                                                    </svg>    
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                
                            </table>
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


@section('footer_html')

<!-- Modal -->
<div class="modal fade" id="pointsModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Изменение баллов</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="pointsInput">Введите баллы</label>
                    <input type="number" class="form-control" id="pointsInput"  name="points" placeholder="Введите баллы" min="0">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" id="pointsChange">Сохранить изменения</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="documentsModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Изменение документов</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Приклепленные файлы</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Название</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody class="documents-list">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="commentsModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Комментарии</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane comments-list" id="activity">
                            
                                <div class="post clearfix">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm" src="{{ asset('assets/admin/img/admin.svg') }}" alt="User Image">
                                        <span class="username">
                                        <span>Sarah Ross</span>
                                        <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                        </span>
                                        <span class="description">Время - 3 days ago</span>
                                    </div>
                                    <p>новый коммментарий</p>
                                </div>
                            
                            </div>
                        
                        </div>

                        <form class="form-horizontal" action="/api/admin/comments/store" method="POST">
                            <div class="input-group input-group-sm mb-0">
                                <input class="form-control form-control-sm" placeholder="Ваш комментарий" name="comment">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-danger send-comment">Отправить</button>
                                </div>
                            </div>
                        </form>
                    
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection