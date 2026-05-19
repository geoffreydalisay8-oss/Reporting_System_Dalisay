@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4 px-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 bg-transparent p-0">
                <li class="breadcrumb-item small"><a href="{{ route('admin.ticket.index') }}">Tickets</a></li>
                <li class="breadcrumb-item small active">#{{ $ticket->id }}</li>
            </ol>
        </nav>
        <a href="{{ route('admin.ticket.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <h2 class="fw-bold mb-4">Ticket Details</h2>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary small text-uppercase">Report Information</h6>
                    <span class="badge bg-warning text-dark px-3 rounded-pill">{{ $ticket->status }}</span>
                </div>
                <div class="card-body">
                    <h3 class="fw-bold mb-1">{{ $ticket->title }}</h3>
                    <div class="text-muted small mb-3">
                        <i class="fas fa-user me-1"></i> Reported by <strong>{{ $ticket->user->name }}</strong> 
                        <span class="mx-2">|</span>
                        <i class="fas fa-calendar me-1"></i> {{ $ticket->created_at->format('M d, Y g:i A') }}
                    </div>
                    <div class="p-3 bg-light rounded border">
                        <label class="text-uppercase text-muted fw-bold small d-block mb-2">Description</label>
                        <p class="mb-0">{{ $ticket->description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary small text-uppercase">Management Actions</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.tickets.updateStatus', $ticket->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-2 text-uppercase" style="font-size: 0.7rem;">Current Status</label>
                            <select name="status" class="form-select border-2">
                                <option value="Pending" {{ $ticket->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="In Progress" {{ $ticket->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Resolved" {{ $ticket->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-bold py-2 shadow-sm">
                            <i class="fas fa-save me-2"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary small text-uppercase">Discussion</h6>
        </div>
        <div class="card-body">
            <div class="message-list mb-4">
                @foreach($ticket->comments as $comment)
                    <div class="d-flex mb-4 align-items-start">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 40px; height: 40px; flex-shrink: 0; font-weight: bold;">
                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                        </div>
                        <div class="flex-grow-1 border-bottom pb-3">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-0 fw-bold text-dark">{{ $comment->user->name }}</h6>
                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="text-secondary mb-0 mt-2 small">{{ $comment->message }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 pt-4 border-top">
                <h6 class="fw-bold mb-3 small text-uppercase text-muted">Supporting Evidence</h6>
                <div class="row g-2">
                    @forelse($ticket->attachments as $attachment)
                        <div class="col-md-3 col-6">
                            <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank">
                                <img src="{{ asset('storage/' . $attachment->file_path) }}" class="img-fluid rounded border shadow-sm" style="height: 140px; width: 100%; object-fit: cover;">
                            </a>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted small fst-italic">No evidence files attached.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <form action="{{ route('comments.store', $ticket->id) }}" method="POST" class="mt-4">
                @csrf
                <div class="form-group mb-2">
                    <textarea name="body" class="form-control border-2" rows="3" placeholder="Type your response here..." style="resize: none;"></textarea>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Post Comment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection