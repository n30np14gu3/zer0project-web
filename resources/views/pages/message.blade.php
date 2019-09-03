@extends('index')
@section('page-title', env('CHEAT_NAME'))

@section('page-content')
    <div class="tab-pane fade show active">
        <div class="alert {{@$data['style']}}" role="alert">
            {{@$data['content']}}
        </div>
    </div>
@endsection
