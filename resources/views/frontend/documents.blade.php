@extends('layouts.app')

@section('header')
    @include('frontend.parts.header')
@endsection

@section('content')

<div class="main user-panel">

    <div class="full-container">

        <div class="user-panel__wrap">

            <h1 class="title">Документы</h1>

            <table class="table user-panel__table">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th align="left">Наименование</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $k => $document)
                        <tr>
                            <td>{{ $k+1 }}</td>
                            <td><a href="{{ asset('storage/'. $document->path) }}" target="_blank">{{ $document->name }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
        </div>
    </div>


    
</div>

@endsection