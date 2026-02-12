<div class="ledgerly-metadata">
    <details>
        <summary>Metadata</summary>

        <dl>
            @foreach ($metadata as $row)
                <dt>{{ $row['label'] }}</dt>
                <dd>{{ $row['value'] }}</dd>
            @endforeach
        </dl>
    </details>
</div>
