<div class="list-group">
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Игра</th>
            <th scope="col">Дата окончания</th>
            <th scope="col">Привязка</th>
        </tr>
        </thead>
        <tbody>
        @foreach(@$data['subscriptions'] as $subscription)
            <tr>
                <td>{{@$subscription['base']->id}}</td>
                <td>{{@$subscription['game']->name}}</td>
                <td>{{date("d-m-Y H:i:s", @$subscription['base']->expire_time)}}</td>
                <td>{{@$subscription['base']->hwid == null ? "Нет" : "Да"}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
