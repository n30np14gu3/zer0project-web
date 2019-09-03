<form id="new-cheat-form" enctype="multipart/form-data">
    <div class="form-group">
        <input type="text" class="form-control"  placeholder="Название чита" name="cheat-name" required>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Имя процесса" name="process-name" required>
    </div>
    <div class="form-group">
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="game-loader" required>
            <label class="custom-file-label">Лоадер</label>
        </div>
    </div>
    <div class="form-group">
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="game-dll" required>
            <label class="custom-file-label">DLL Для инжекта</label>
        </div>
    </div>
    {{csrf_field()}}
    <button type="submit" class="btn btn-primary">Создать</button>
    <ul style="color: red; display: none" id="new-cheat-errors"></ul>
</form>
