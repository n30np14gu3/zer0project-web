<form id="change-password-form">
    <div class="form-group">
        <input type="password" class="form-control"  placeholder="Старый пароль" name="old-password" required>
    </div>
    <div class="form-group">
        <input type="password" class="form-control" placeholder="Новый пароль" name="new-password" required>
    </div>
    <div class="form-group">
        <input type="password" class="form-control" placeholder="Повторите пароль" name="new-password-2" required>
    </div>
    {{csrf_field()}}
    <button type="submit" class="btn btn-primary">Сменить пароль</button>
    <ul style="color: red; display: none" id="change-password-errors"></ul>
</form>
