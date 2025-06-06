<div>
    <div class="card shadow-lg">
        <div class="card-header text-white text-center py-3" style="background-color: #1e1b4b; border-radius: 12px 12px 0 0;">
            <h2 class="fw-bold m-0">Activity Logs</h2>
        </div>
        <br>
        <div class="card-body">
            <div class="row mb-4 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0"
                            placeholder="Search venues..."
                            wire:model.live.debounce.300ms="search"
                            aria-label="Search venues">
                        <button class="btn btn-outline-secondary border-start-0 bg-light" type="button"
                            wire:loading.class="d-none" wire:target="search"
                            wire:click="$set('search', '')">
                            <i class="bi bi-x"></i>
                        </button>
                        <span wire:loading wire:target="search" class="input-group-text bg-light border-start-0">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Searching...</span>
                            </div>
                        </span>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center global-table">
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
                <div>
                    {{ $logs->links(data: ['scrollTo' => false]) }}
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