<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <form id="activate-promo-form">
                <div class="form-group">
                    <input placeholder="Введите ключ" class="form-control" name="promo-code" required>
                </div>
                {{csrf_field()}}
                <button type="submit" class="btn btn-primary">Активировать</button>
            </form>
            <ul style="color: red; display: none" id="activate-promo-errors"></ul>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <h6>Активированные ключи</h6>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Игра</th>
                    <th scope="col">Ключ</th>
                </tr>
                </thead>
                <tbody>
                @foreach(@$data['used_promo'] as $promo)
                    <tr>
                        <td>{{@$promo['id']}}</td>
                        <td>{{@$promo['game']->name}}</td>
                        <td>{{@$promo['token']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
