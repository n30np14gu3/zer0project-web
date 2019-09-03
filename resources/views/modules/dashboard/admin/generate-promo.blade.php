<form id="generate-promo-form">
    <div class="form-group">
        <label for="promo-cheat">Чит</label>
        <select class="form-control" id="promo-cheat" name="cheat-id" required>
            @foreach(@$data['cheats'] as $cheat)
                <option value="{{@$cheat->id}}">{{@$cheat->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <input type="number" class="form-control" placeholder="Инкремент (в секундах)" name="increment" required>
    </div>
    <div class="form-group">
        <input type="number" class="form-control" placeholder="Кол-во" name="count" required>
    </div>
    <textarea class="form-control" id="generated-promo" style="display: none" rows="7"></textarea>
    {{csrf_field()}}
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Создать</button>
    </div>
    <ul style="color: red; display: none" id="generate-promo-errors"></ul>
</form>
