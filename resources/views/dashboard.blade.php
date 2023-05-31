@extends('layouts.app')

@section('content')
    @if (Auth::check())
        <div class="sm:grid sm:gap-10">
            <div class="sm:col-span-2">
                {{-- 投稿フォーム --}}
                @include('tasks.form')
                {{-- 投稿一覧 --}}
                @include('tasks.index')
            </div>
        </div>
    @else
        <div class="center jumpbutton">
            <div class="navbar-brand d-flex flex-row-reverse bd-highlight">
                Welcome to the tasks
            </div>
        </div>
    @endif
@endsection