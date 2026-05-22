@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">System Activity Log</h2>
        <span class="badge bg-primary">{{ $activities->total() }} Total Events</span>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-4">
            <div class="position-relative">
                <div style="position: absolute; left: 19px; top: 0; bottom: 0; width: 2px; background: #e9ecef;"></div>

                @forelse($activities as $activity)
                    <div class="d-flex mb-4 position-relative" style="z-index: 2;">
                        @php
                            $color = '#4a90e2'; // default blue = updated
                            if($activity->status_to == 'Resolved')    $color = '#2ecc71'; // green
                            if($activity->status_to == 'Deleted')     $color = '#e74c3c'; // red
                            if($activity->status_to == 'Cancelled')   $color = '#e74c3c'; // red
                            if($activity->status_to == 'Pending')     $color = '#f39c12'; // orange
                            if($activity->status_to == 'In Progress') $color = '#3498db'; // blue
                            if($activity->comment == 'user_added')    $color = '#a855f7'; // purple
                            if($activity->field_name == 'created')    $color = '#1cc88a'; // teal
                        @endphp

                        {{-- Timeline Icon --}}
                        <div style="width: 40px; height: 40px; background: {{ $color }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 4px solid white; flex-shrink: 0; color: white;">
                            @if($activity->status_to == 'Deleted')
                                <i class="fas fa-trash"></i>
                            @elseif($activity->field_name == 'created')
                                <i class="fas fa-plus"></i>
                            @elseif($activity->comment == 'user_added')
                                <i class="fas fa-user-plus"></i>
                            @elseif($activity->status_to == 'Resolved')
                                <i class="fas fa-check"></i>
                            @else
                                <i class="fas fa-history"></i>
                            @endif
                        </div>

                        {{-- Activity Card --}}
                        <div class="ms-3 bg-light p-3 rounded-3 w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    {{-- Who performed the action (staff/admin) --}}
                                    <span class="fw-bold">{{ $activity->user->name ?? 'System' }}</span>
                                    <span class="badge ms-2 text-white" style="background: {{ $color }}; font-size: 0.7rem;">
                                        {{ ucfirst($activity->user->role ?? 'system') }}
                                    </span>
                                </div>
                                <small class="text-muted">{{ $activity->created_at->format('M d, Y • h:i A') }}</small>
                            </div>

                            {{-- Activity Description --}}
                            <div class="mt-2">
                                @if($activity->comment == 'user_added')
                                    {{-- Staff Added --}}
                                    <span>Added new staff member: <strong>{{ $activity->status_to }}</strong></span>

                                @elseif($activity->status_to == 'Deleted')
                                    {{-- Ticket Deleted --}}
                                    <span>
                                        Deleted ticket <strong>#{{ $activity->ticket_id }}</strong>
                                        <span class="badge ms-1" style="background: #fde8e8; color: #e74c3c;">Deleted</span>
                                    </span>
                                    <small class="text-muted d-block mt-1">
                                        Reporter: <strong>{{ $activity->ticket->user->name ?? 'N/A' }}</strong>
                                    </small>

                                @elseif($activity->field_name == 'created')
                                    {{-- Ticket Created --}}
                                    <span>
                                        Created ticket <strong>#{{ $activity->ticket_id }}</strong>
                                        <span class="badge ms-1" style="background: #dcfce7; color: #166534;">New</span>
                                    </span>
                                    <small class="text-muted d-block mt-1">
                                        Reporter: <strong>{{ $activity->ticket->user->name ?? 'N/A' }}</strong>
                                    </small>

                                @else
                                    {{-- Status Updated --}}
                                    <span>
                                        Updated ticket <strong>#{{ $activity->ticket_id }}</strong>
                                        from <span class="badge" style="background: #fee2e2; color: #991b1b;">{{ $activity->status_from ?? 'None' }}</span>
                                        to <span class="badge" style="background: #dcfce7; color: #166534;">{{ $activity->status_to }}</span>
                                    </span>
                                    {{-- ✅ Show who reported/owns the ticket --}}
                                    <small class="text-muted d-block mt-1">
                                        Reporter: <strong>{{ $activity->ticket->user->name ?? 'N/A' }}</strong>
                                    </small>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No activity yet</h5>
                        <p class="text-secondary">Activity will appear here once tickets are created or updated.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $activities->links('pagination::simple-tailwind') }}
            </div>
        </div>
    </div>
</div>
@endsection