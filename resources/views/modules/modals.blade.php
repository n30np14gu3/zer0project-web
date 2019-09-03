@if(!@$logged)
    <div class="modal fade" id="auth-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Авторизация</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="login-form">
                        <div class="form-group">
                            <input type="email" class="form-control"  placeholder="EMail" name="email" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Пароль" name="password" required>
                        </div>
                        {{csrf_field()}}
                        <button type="submit" class="btn btn-primary">Авторизация</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="register-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Регистрация</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="register-form">
                        <div class="form-group">
                            <input type="email" class="form-control"  placeholder="EMail" name="email" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Пароль" name="password" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Повторите пароль" name="password-2" required>
                        </div>
                        {{csrf_field()}}
                        <button type="submit" class="btn btn-primary">Регистрация</button>
                    </form>
                    <ul style="color: red; display: none" id="register-form-errors"></ul>
                </div>

            </div>
        </div>
    </div>
@endif
