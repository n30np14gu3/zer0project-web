<html lang="{{str_replace('_', '-', app()->getLocale())}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>@yield('page-title')</title>
    <link rel="stylesheet" href="{{url('/bootstrap/css/bootstrap-material-design.min.css')}}">
    <link rel="stylesheet" href="{{url('/semantic-ui/css/toast.min.css')}}">
    <link rel="stylesheet" href="{{url('/semantic-ui/css/transition.min.css')}}">
    <link rel="stylesheet" href="{{url('/semantic-ui/css/icon.min.css')}}">
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="/">{{env('CHEAT_NAME')}}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-nav-bard" aria-controls="menu-nav-bard" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="menu-nav-bard">
        <ul class="navbar-nav mr-auto">
            @if(@$logged)
                <li class="nav-item @yield('dashboard-active')">
                    <a class="nav-link" href="{{url('/dashboard')}}">Личный кабинет</a>
                </li>
            @endif
        </ul>
        <div class="mt-2 mt-md-0">
            @if(@$logged)
                <a class="btn btn-danger" href="{{url('/logout')}}">Выход</a>
            @else
                <button type="button" class="btn btn-info"  data-toggle="modal"  data-target="#auth-modal">Вход</button>
                <button type="button" class="btn btn-success" data-toggle="modal"  data-target="#register-modal">Регистрация</button>
            @endif
        </div>
    </div>
</nav>
<main role="main" class="container-fluid" style="margin-top: 10px">
    @yield('page-content')
</main>
@include('modules.modals')
<script src="{{url('/vendor/js/jquery-3.1.1.min.js')}}"></script>
<script src="{{url('/vendor/js/popper.min.js')}}"></script>
<script src="{{url('/bootstrap/js/bootstrap-material-design.min.js')}}"></script>
<script src="{{url('/vendor/js/holder.min.js')}}"></script>
<script src="{{url('/semantic-ui/js/toast.min.js')}}"></script>
<script src="{{url('/semantic-ui/js/transition.min.js')}}"></script>

<script src="{{url('/js/functions.js')}}"></script>
<script src="{{url('/js/ajax.js')}}"></script>
@if(@$data['user']->staff_status == 1)
    <script src="{{url('/js/ajax-admin.js')}}"></script>
@endif
<script>
    $('body').bootstrapMaterialDesign();
</script>


</body>
</html>
