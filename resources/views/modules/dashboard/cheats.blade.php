<div class="list-group">
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Игра</th>
            <th scope="col">Последнее обновление</th>
            <th scope="col">Лоадер</th>
        </tr>
        </thead>
        <tbody>
        @foreach(@$data['cheats'] as $cheat)
            <tr>
                <td>{{@$cheat->id}}</td>
                <td>{{@$cheat->name}}</td>
                <td>{{date("d-m-Y H:i:s", @$cheat->last_update)}}</td>
                <td>
                    <a class="btn btn-block btn-info btn-raised" href="{{url("/download/".@$cheat->id)}}" target="_blank">Скачать лоадер</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
