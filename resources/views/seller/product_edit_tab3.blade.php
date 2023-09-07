<div id="tab3" class="tab-pane fade">
    <table class="datatable table table-bordered table-striped table-condensed w-100">
        <thead>
            <tr>
                <th scope="col" class="all">Felhasználó neve</th>
                <th scope="col" class="all">Értékelés címe</th>
                <th scope="col" class="all">Értékelés</th>
                <th scope="col" class="none">Értékelés szövege</th>
                <th scope="col" class="none">Dátum</th>
                <th scope="col" class="all">Műveletek</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ratings AS $rating)
            <tr>
                <td>{{ $rating->user_name }}</td>
                <td>{{ $rating->title }}</td>
                <td>{{ $rating->stars }}</td>
                <td>{{ $rating->body }}</td>
                <td>{{ $rating->updated }}</td>
                <td>
                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>