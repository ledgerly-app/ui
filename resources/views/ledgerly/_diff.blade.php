<div class="ledgerly-diff-wrapper">
    <table class="ledgerly-diff">
        <thead>
            <tr>
                <th>Field</th>
                <th>Before</th>
                <th>After</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($diff as $row)
                <tr>
                    <td>{{ $row['field'] }}</td>
                    <td>{{ $row['before'] }}</td>
                    <td>{{ $row['after'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
