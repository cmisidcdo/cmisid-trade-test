<div>
    <table class="table">
        <thead>
            <tr>
                <th>Action</th>
                <th>Performed By</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
                <tr>
                    <td>{{ $log->description }}</td>
                    <td>{{ $log->causer?->name ?? 'System' }}</td>
                    <td>{{ $log->created_at->diffForHumans() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
