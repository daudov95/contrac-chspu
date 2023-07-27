@extends('layouts.app')

@section('header')
    @include('frontend.parts.header')
@endsection

@section('content')

<div class="main user-panel">

    <div class="full-container">

        <div class="user-panel__wrap">

            <h1 class="title">{{ $semester_user->table->name ?? 'Такой критерии не существует' }}</h1>

            <table class="table user-panel__table">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th align="left">Показатель</th>
                        <th width="100">Баллы</th>
                        <th width="300">Документы</th>
                        <th width="300">Ответственные</th>
                        <th width="150">Комментарии</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($semester_user->questions as $k => $question)
                        <tr id="{{ $question->id }}">
                            <td>{{ $k+1 }}</td>
                            <td >{{ $question->text }}</td>
                            <td class="points" data-id="{{ $question->id }}">
                                @php
                                    $points = $semester_user_questions->where('question_id', $question->id)->first();
                                    echo $points ? $points->points : '-';
                                    // dd($points->question_id);
                                @endphp
                            </td>
                            <td class="documents" data-id="{{ $question->id }}">
                                @if (count($question->documents) > 0)
                                    <div class="documents__wrap">
                                        @foreach ($question->documents as $doc)
                                            <a href="{{ asset('storage/'. $doc->path) }}" target="_blank" data-document-id="{{ $doc->id }}">{{ $doc->name }}</a>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                            <td>{{ $question->curator->name ?? 'Не выбран' }}</td>
                            <td class="comments" data-id="{{ $question->id }}" style="text-align: center;">
                                <span>
                                    @php
                                        $question_info = $semester_user_questions->where('question_id', $question->id)->first();
                                    @endphp
                                    {{ $question_info ? $comments->where('question_id', $question_info->id)->where('user_id', Auth::id())->count() : 0 }}
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 114.44" width="20">
                                    <path d="M34.75 35.84A6.72 6.72 0 1 1 28 42.56a6.72 6.72 0 0 1 6.72-6.72ZM7 0h108.91a7 7 0 0 1 7 7v72.86a7 7 0 0 1-7 7H62.55l-26.41 19.59c-5 4.76-9.47 7.76-12.88 8-5 .3-7.61-3.1-7-11.56v-16H7a7 7 0 0 1-7-7V7a7 7 0 0 1 7-7Zm108.91 6.8H7a.17.17 0 0 0-.2.2v72.86A.17.17 0 0 0 7 80h12.64a3.4 3.4 0 0 1 3.4 3.4v19.49a2.09 2.09 0 0 1 0 .25c-.23 3.15-.27 4.48-.17 4.47 1.67-.1 4.77-2.46 8.75-6.24l.32-.26L59.2 80.87a3.36 3.36 0 0 1 2.24-.87h54.47a.17.17 0 0 0 .17-.17V7a.17.17 0 0 0-.17-.17Zm-55.47 29a6.72 6.72 0 1 1-6.73 6.72 6.72 6.72 0 0 1 6.73-6.72Zm25.69 0a6.72 6.72 0 1 1-6.73 6.72 6.72 6.72 0 0 1 6.73-6.72Z" style="fill-rule:evenodd"/>
                                </svg>

                                {{-- <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 122.88 113.94"><path d="M3.77 0h115.34a3.79 3.79 0 0 1 3.77 3.77v77.17a3.79 3.79 0 0 1-3.77 3.78H61.44l-29.1 21.62c-9.61 9.13-16.08 11.45-15.15-1V84.72H3.77A3.79 3.79 0 0 1 0 80.94V3.77A3.79 3.79 0 0 1 3.77 0Zm59.15 34.34a7.12 7.12 0 1 1-7.12 7.11 7.11 7.11 0 0 1 7.12-7.11Zm27.19 0A7.12 7.12 0 1 1 83 41.45a7.11 7.11 0 0 1 7.11-7.11Zm-54.39 0a7.12 7.12 0 1 1-7.11 7.11 7.11 7.11 0 0 1 7.11-7.11Z" style="fill-rule:evenodd"/></svg> --}}
                            </td>
                        </tr>
                    @endforeach

                    
                </tbody>
            </table>
        
        </div>
    </div>


    <div class="popup popup-default actives">
        <div class="popup__wrap">
            <button class="popup__close"><svg xmlns="http://www.w3.org/2000/svg" width="60" height="30" fill="none" viewBox="0 0 24 24"><path fill="#000" fill-rule="evenodd" d="M19.207 6.207a1 1 0 0 0-1.414-1.414L12 10.586 6.207 4.793a1 1 0 0 0-1.414 1.414L10.586 12l-5.793 5.793a1 1 0 1 0 1.414 1.414L12 13.414l5.793 5.793a1 1 0 0 0 1.414-1.414L13.414 12l5.793-5.793z" clip-rule="evenodd"/></svg></button>
            
            <form enctype="multipart/form-data" class="form">
                <h3 class="popup__title">Изменение баллов</h3>
                <input type="hidden" name="user_id" value="{{ $semester_user->id }}">
                <input type="hidden" name="table_id" value="{{ $semester_user->table_id }}">
                <input type="hidden" name="question_id" value="0">
                <button class="popup__btn">Сохранить</button>
            </form>            
            
        </div>
    </div>

</div>


<div class="popup popup-comments actives">
    <div class="popup__wrap">
        <button class="popup__close"><svg xmlns="http://www.w3.org/2000/svg" width="60" height="30" fill="none" viewBox="0 0 24 24"><path fill="#000" fill-rule="evenodd" d="M19.207 6.207a1 1 0 0 0-1.414-1.414L12 10.586 6.207 4.793a1 1 0 0 0-1.414 1.414L10.586 12l-5.793 5.793a1 1 0 1 0 1.414 1.414L12 13.414l5.793 5.793a1 1 0 0 0 1.414-1.414L13.414 12l5.793-5.793z" clip-rule="evenodd"/></svg></button>
        
        <h3 class="popup__title">Комментарии:</h3>

        <div class="popup-comments">
            <ul class="popup-comments__list">
            </ul>
        </div>
    </div>
</div>

@endsection