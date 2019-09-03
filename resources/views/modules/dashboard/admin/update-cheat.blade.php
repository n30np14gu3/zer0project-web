<form id="update-cheat-form" enctype="multipart/form-data">
    <div class="form-group">
        <label for="update-cheat">Чит</label>
        <select class="form-control" id="update-cheat" name="cheat-id" required>
            @foreach(@$data['cheats'] as $cheat)
                <option value="{{@$cheat->id}}">{{@$cheat->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Имя процесса" name="process-name" id="process-name" required>
    </div>
    <div class="form-group">
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="game-loader">
            <label class="custom-file-label">Лоадер</label>
        </div>
    </div>
    <div class="form-group">
        <div class="custom-file">
            <input type="file" class="custom-file-input"  name="game-dll">
            <label class="custom-file-label">DLL Для инжекта</label>
        </div>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="update-check" name="update-dll">
            <label class="custom-control-label" for="update-check">Обновить дату обновления при загрузке dll</label>
        </div>
    </div>
    {{csrf_field()}}
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Обновить</button>
    </div>
    <ul style="color: red; display: none" id="update-cheat-errors"></ul>
</form>
