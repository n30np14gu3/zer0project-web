@extends('index')

@section('dashboard-active', 'active')
@section('page-title', env('CHEAT_NAME')." :: Личный кабинет")

@section('page-content')
    <div class="row">
        <div class="col-xl-4">
            <div class="list-group" id="list-tab" role="tablist">
                @if(@$data['user']->status != 0 && !@$data['user_bans']['has_bans'])
                    <a class="list-group-item list-group-item-action active" data-toggle="list" href="#list-cheats" role="tab">Читы</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-subscription" role="tab">Подписки</a>
                    <a class="list-group-item list-group-item-action"  data-toggle="list" href="#list-keys" role="tab">Активация ключа</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-security" role="tab">Смена пароля</a>

                    @if(@$data['user']->staff_status == 1)
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-create-cheat" role="tab">Создание чита</a>
                        <a class="list-group-item list-group-item-action"  data-toggle="list" href="#list-update-cheat" role="tab">Обновление чита</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-generate-promo" role="tab">Генерация промо кодов</a>
                    @endif

                @else
                    <a class="list-group-item list-group-item-action active disabled">Блокировки и ограничения</a>
                @endif
            </div>
        </div>
        <div class="col-xl-8">
            @if(@$data['user']->status != 0)
                @if(@$data['user_bans']['has_bans'])
                    <h6>Активные блокировки ({{count(@$data['user_bans']['bans'])}})</h6>
                    <hr>
                    @foreach(@$data['user_bans']['bans'] as $ban)
                        <div class="alert alert-danger" role="alert">
                            <b>{{@$ban['reason']}}</b> (Истекает: {{@$ban['end_date']}})
                        </div><br>
                    @endforeach
                @else
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="list-cheats" role="tabpanel">
                            @include('modules.dashboard.cheats')
                        </div>

                        <div class="tab-pane fade" id="list-subscription" role="tabpanel">
                            @include('modules.dashboard.subscription-info')
                        </div>

                        <div class="tab-pane fade" id="list-keys" role="tabpanel" aria-labelledby="list-subscription-info">
                            @include('modules.dashboard.promo-codes')
                        </div>

                        <div class="tab-pane fade" id="list-security" role="tabpanel">
                            @include('modules.dashboard.security')
                        </div>

                        @if(@$data['user']->staff_status == 1)
                            <div class="tab-pane fade" id="list-create-cheat" role="tabpanel">
                                @include('modules.dashboard.admin.create-cheat')
                            </div>

                            <div class="tab-pane fade" id="list-update-cheat" role="tabpanel">
                                @include('modules.dashboard.admin.update-cheat')
                            </div>

                            <div class="tab-pane fade" id="list-generate-promo" role="tabpanel">
                                @include('modules.dashboard.admin.generate-promo')
                            </div>
                        @endif
                    </div>
                @endif
            @else
                <div class="tab-pane fade show active">
                    <div class="alert alert-danger" role="alert">
                        Аккаунт не подтвержен. На Ваш почтовый ящик была отправлена ссылка для подтверждения
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
