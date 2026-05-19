@extends('layouts.employee')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('tickets.index') }}" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Back to My Reports
        </a>
        <span class="badge {{ $ticket->status == 'Resolved' ? 'bg-success' : 'bg-warning text-dark' }} p-2 px-3 rounded-pill">
            Status: {{ $ticket->status }}
        </span>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-20 mb-4">
                <div class="card-body p-4">
                    <h1 class="h3 fw-bold mb-1">{{ $ticket->title }}</h1>
                    <p class="text-muted small mb-4">Reported on {{ $ticket->created_at->format('M d, Y') }}</p>
                    
                    <h6 class="fw-bold text-uppercase small text-primary">Detailed Description</h6>
                    <p class="border-start border-4 ps-3 py-1">{{ $ticket->description }}</p>
                </div>
            </div>

            <div class="card shadow-sm border-20 mb-4">
                <div class="card-header bg-white fw-bold">Discussion Thread</div>
                <div class="card-body">
                    <div class="chat-box mb-3" style="max-height: 300px; overflow-y: auto;">
                        @forelse($ticket->comments as $comment)
                            <div class="mb-3 {{ $comment->user_id == auth()->id() ? 'text-end' : '' }}">
                                <div class="d-inline-block p-2 rounded {{ $comment->user_id == auth()->id() ? 'bg-primary text-white' : 'bg-light' }}" style="max-width: 80%;">
                                    <small class="d-block fw-bold" style="font-size: 0.7rem;">{{ $comment->user->name }}</small>
                                    {{ $comment->message }}
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small text-center my-4">No activity yet. Start the conversation below.</p>
                        @endforelse
                    </div>
                    
                    <form action="{{ route('comments.store', $ticket->id) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <textarea name="body" class="form-control" placeholder="Write your message..." rows="2"></textarea>
                            <button class="btn btn-primary" type="submit"><i class="fas fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-20">
                <div class="card-header bg-white fw-bold">Attached Evidence</div>
                <div class="card-body">
                                        <div class="row g-2">
                        @forelse($ticket->attachments as $attachment)
                            <div class="col-3">
                                <div class="ratio ratio-4x3">
                                    <img src="{{ asset('storage/' . $attachment->file_path) }}" 
                                        class="img-fluid rounded border shadow-sm object-fit-cover" 
                                        alt="Evidence">
                                </div>
                            </div>
                        @empty
                            <p class="text-muted small mb-0">No files uploaded.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-20 sticky-top" style="top: 20px;">
                <div class="card-header bg-dark text-white fw-bold">Ticket Metadata</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small fw-bold d-block">Category Type</label>
                        <span class="badge bg-info text-white">{{ $ticket->type }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small fw-bold d-block">Priority</label>
                        <span class="badge bg-danger">{{ $ticket->priority }}</span>
                    </div>
                    <hr>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-shield me-2 text-secondary"></i>
                        <div>
                            <label class="text-muted small d-block">Handling Agent</label>
                            <span class="fw-bold small">{{ $ticket->assigned->name ?? 'Awaiting Agent' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection