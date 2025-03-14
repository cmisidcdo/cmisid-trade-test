<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
            <h2 class="fw-bold m-0">Activity Logs</h2>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="Search logs..." wire:model.live.debounce.500ms="search">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Action</th>
                            <th>Model Type</th>
                            <th>Performed By</th>
                            <th>Log Name</th>
                            <th>Date</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td><span class="badge bg-info">{{ ucfirst($log->event ?? 'N/A') }}</span></td>
                                <td>{{ class_basename($log->subject_type) ?? 'N/A' }}</td>
                                <td>{{ $log->causer?->name ?? 'System' }}</td>
                                <td>{{ $log->log_name }}</td>
                                <td>{{ $log->created_at->diffForHumans() }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#logDetailsModal" wire:click="showDetails({{ $log->id }})">
                                        View
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No logs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $logs->links() }}
            </div>
        </div>
    </div>

    <!-- Log Details Modal -->
    <div wire:ignore.self class="modal fade" id="logDetailsModal" tabindex="-1" aria-labelledby="logDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logDetailsModalLabel">Log Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($selectedLog)
                        <p><strong>Action:</strong> {{ ucfirst($selectedLog->event ?? 'N/A') }}</p>
                        <p><strong>Model:</strong> {{ class_basename($selectedLog->subject_type) ?? 'N/A' }}</p>
                        <p><strong>Performed By:</strong> {{ $selectedLog->causer?->name ?? 'System' }}</p>
                        <p><strong>Date:</strong> {{ $selectedLog->created_at->format('F j, Y, g:i a') }}</p>
                        <pre class="bg-light p-2 rounded">{{ json_encode($selectedLog->properties, JSON_PRETTY_PRINT) }}</pre>
                    @else
                        <p>No details available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
