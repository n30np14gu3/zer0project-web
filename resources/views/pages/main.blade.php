@extends('index')
@section('page-title', env('CHEAT_NAME'))
@section('page-content')
    <h1 style="text-align: center">Welcome to {{env('CHEAT_NAME')}}</h1>
    <div style="width: 100%; align-items: center; text-align: center">
        @if(!@$logged)
            <button type="button" class="btn btn-raised btn-info btn-lg" data-target="#auth-modal" data-toggle="modal" >Вход</button>
        @else
            <a class="btn btn-raised btn-info btn-lg" href="{{url('/dashboard')}}">Личный кабинет</a>
        @endif
    </div>
@endsection
