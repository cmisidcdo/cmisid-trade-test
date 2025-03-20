<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header text-white text-center py-3" style="background-color: #1e1b4b; border-radius: 12px 12px 0 0;">
            <h2 class="fw-bold m-0">Activity Logs</h2>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search logs..." wire:model.live.debounce.500ms="search">
                        <button class="btn btn-outline-secondary border-start-0" type="button">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <button class="btn btn-warning">
                        <i class="bi bi-archive-fill"></i> View Archive
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th>#</th>
                            <th>Action</th>
                            <th>Model Type</th>
                            <th>Performed By</th>
                            <th>Log Name</th>
                            <th>Date</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $index => $log)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($log->event == 'created')
                                        <span class="badge" style="background-color: #0dcaf0;">{{ ucfirst($log->event) }}</span>
                                    @elseif($log->event == 'updated')
                                        <span class="badge bg-warning">{{ ucfirst($log->event) }}</span>
                                    @elseif($log->event == 'deleted')
                                        <span class="badge bg-danger">{{ ucfirst($log->event) }}</span>
                                    @else
                                        <span class="badge bg-info">{{ ucfirst($log->event ?? 'N/A') }}</span>
                                    @endif
                                </td>
                                <td>{{ class_basename($log->subject_type) ?? 'N/A' }}</td>
                                <td>{{ $log->causer?->name ?? 'System' }}</td>
                                <td>{{ $log->log_name }}</td>
                                <td>{{ $log->created_at->diffForHumans() }}</td>
                                <td>
                                    <button class="btn btn-sm" style="background-color: #0dcaf0; color: white;" data-bs-toggle="modal" data-bs-target="#logDetailsModal" wire:click="showDetails({{ $log->id }})">
                                        <i class="bi bi-eye-fill"></i> View
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No logs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-0">Showing 1 to {{ count($logs) }} of {{ $logs->total() }} entries</p>
                </div>
                <div>
                    {{ $logs->links() }}
                </div>
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