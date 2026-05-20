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
                            $color = '#4a90e2';
                            if($activity->status_to == 'Resolved') $color = '#2ecc71';
                            if($activity->comment == 'user_added') $color = '#a855f7';
                        @endphp
                        
                        <div style="width: 40px; height: 40px; background: {{ $color }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 4px solid white; flex-shrink: 0; color: white;">
                            <i class="fas fa-history"></i>
                        </div>

                        <div class="ms-3 bg-light p-3 rounded-3 w-100">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">{{ $activity->user->name }}</span>
                                <small class="text-muted">{{ $activity->created_at->format('M d, Y • h:i A') }}</small>
                            </div>
                            
                            <div class="mt-2">
                                @if($activity->comment == 'user_added')
                                    Added new staff member: <strong>{{ $activity->status_to }}</strong>
                                @elseif($activity->field_name == 'created')
                                    Created ticket <strong>#{{ $activity->ticket_id }}</strong>
                                @else
                                    Updated ticket <strong>#{{ $activity->ticket_id }}</strong> 
                                    from <span class="text-danger">{{ $activity->status_from ?? 'None' }}</span> 
                                    to <span class="text-success fw-bold">{{ $activity->status_to }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <h5 class="text-muted">No activity yet</h5>
                        <p class="text-secondary">Your activity log will appear here once you are assigned to tickets and perform updates.</p>
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