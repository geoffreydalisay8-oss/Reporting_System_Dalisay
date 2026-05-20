@extends('layouts.staff')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">My Assigned Workload</h2>
            <p class="text-muted small mb-0">Manage and update the status of issues assigned explicitly to you.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Ticket Title</th>
                            <th>Reporter</th>
                            <th>Classification</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">#{{ $ticket->id }}</td>
                                <td>
                                    <span class="fw-semibold text-dark">{{ $ticket->title }}</span>
                                </td>
                                <td>{{ $ticket->user->name ?? 'Guest Client' }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1">
                                        {{ $ticket->type }}
                                    </span>
                                </td>
                                <td>
                                    @if($ticket->status === 'Pending')
                                        <span class="badge bg-secondary">Pending</span>
                                    @elseif($ticket->status === 'In Progress')
                                        <span class="badge bg-warning text-dark">In Progress</span>
                                    @elseif($ticket->status === 'Resolved')
                                        <span class="badge bg-success">Resolved</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('staff.tickets.show', $ticket->id) }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                                        View Ticket
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-3 d-block text-secondary"></i>
                                    No tickets assigned to you at the moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection