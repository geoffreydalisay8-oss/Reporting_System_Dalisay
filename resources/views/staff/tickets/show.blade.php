@extends('layouts.staff')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('staff.tickets.index') }}" class="btn btn-sm btn-link text-decoration-none p-0 text-muted">
            <i class="fas fa-arrow-left me-1"></i> Back to Workload List
        </a>
        <h2 class="fw-bold text-dark mt-2 mb-1">Ticket #{{ $ticket->id }}: {{ $ticket->title }}</h2>
        <p class="text-muted small">Submitted by {{ $ticket->user->name ?? 'Guest' }} &bull; {{ $ticket->created_at->diffForHumans() }}</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="col-lg-8">
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-header bg-transparent border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0">Issue Description</h5>
        </div>
        <div class="card-body px-4 pb-4">
            <div class="p-3 bg-light rounded" style="white-space: pre-wrap;">{{ $ticket->description }}</div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-header bg-transparent border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0"><i class="fas fa-paperclip me-2"></i>Attachments</h5>
        </div>
        <div class="card-body px-4 pb-4">
            @forelse($ticket->attachments as $file)
                <a href="{{ asset('storage/' . $file->path) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-2 d-block text-start">
                    <i class="fas fa-file-alt me-2"></i> {{ $file->filename }}
                </a>
            @empty
                <p class="text-muted small">No attachments found for this ticket.</p>
            @endforelse
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="card-header bg-transparent border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0"><i class="fas fa-comments me-2"></i>Internal Comments</h5>
        </div>
        <div class="card-body px-4 pb-4">
            @forelse($ticket->comments as $comment)
                <div class="mb-3 border-bottom pb-2">
                    <div class="small fw-bold text-dark">{{ $comment->user->name ?? 'Staff' }}</div>
                    <div class="text-secondary small">{{ $comment->content }}</div>
                    <div class="text-muted text-xs" style="font-size: 0.75rem;">{{ $comment->created_at->diffForHumans() }}</div>
                </div>
            @empty
                <p class="text-muted small">No internal comments yet.</p>
            @endforelse
        </div>
    </div>

      

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-dark text-white mb-4" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Management Console</h5>
                    
                    <div class="mb-3 small">
                        <span class="text-muted d-block">Classification Type</span>
                        <span class="fw-semibold text-light">{{ $ticket->type }}</span>
                    </div>

                    <div class="mb-4 small">
                        <span class="text-muted d-block">Current Assignment Status</span>
                        <span class="badge bg-warning text-dark">{{ $ticket->status }}</span>
                    </div>

                   <form action="{{ route('staff.tickets.updateStatus', $ticket->id) }}" method="POST">
    @csrf
    
    <div class="mb-3">
        <label for="status" class="form-label small text-muted">Modify Assignment State</label>
        <select name="status" id="status" class="form-select form-select-sm bg-light border-0">
            <option value="Pending" {{ $ticket->status === 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="In Progress" {{ $ticket->status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
            <option value="Resolved" {{ $ticket->status === 'Resolved' ? 'selected' : '' }}>Resolved</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-sm btn-light w-100 fw-bold rounded-pill shadow-sm">
        save
    </button>
</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection     