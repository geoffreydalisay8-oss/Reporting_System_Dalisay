@extends('layouts.employee')

@section('content')

@php
    $userId = auth()->id();
    $total       = \App\Models\Ticket::where('user_id', $userId)->count();
    $pending     = \App\Models\Ticket::where('user_id', $userId)->where('status', 'Pending')->count();
    $inProgress  = \App\Models\Ticket::where('user_id', $userId)->where('status', 'In Progress')->count();
    $resolved    = \App\Models\Ticket::where('user_id', $userId)->where('status', 'Resolved')->count();
    $resolutionRate = $total > 0 ? round(($resolved / $total) * 100) : 0;
    $recentTickets = \App\Models\Ticket::where('user_id', $userId)->with('department')->latest()->take(5)->get();
@endphp

<style>
    .stat-card {
        background: white;
        border-radius: 16px;
        border: 1px solid var(--border);
        box-shadow: var(--card-shadow);
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 18px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }
    .stat-icon {
        width: 54px; height: 54px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }
    .stat-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 4px;
    }
    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text);
        line-height: 1;
    }
    .stat-sub {
        font-size: 0.72rem;
        color: var(--text-muted);
        margin-top: 4px;
    }

    .ticket-row {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s;
        cursor: pointer;
    }
    .ticket-row:last-child { border-bottom: none; }
    .ticket-row:hover { background: #f8fafc; }

    .progress-bar-track {
        height: 8px;
        background: #e2e8f0;
        border-radius: 4px;
        overflow: hidden;
    }
    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #3b82f6, #10b981);
        border-radius: 4px;
        transition: width 1s ease;
    }

    .quick-action {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 20px;
        background: white;
        border: 1px solid var(--border);
        border-radius: 14px;
        text-decoration: none;
        color: var(--text);
        font-weight: 600;
        font-size: 0.88rem;
        transition: all 0.2s;
        box-shadow: var(--card-shadow);
    }
    .quick-action:hover {
        border-color: var(--primary);
        background: var(--primary-light);
        color: var(--primary);
        transform: translateY(-2px);
    }
    .quick-action-icon {
        width: 44px; height: 44px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem;
    }
</style>

{{-- Page Header --}}
<div style="margin-bottom: 28px;">
    <h1 style="font-size: 1.75rem; font-weight: 800; color: var(--text); margin-bottom: 4px;">
        Good day, {{ auth()->user()->name }} 👋
    </h1>
    <p style="color: var(--text-muted); font-size: 0.95rem;">
        Here's a summary of your report activity.
    </p>
</div>

{{-- Stats Grid --}}
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 28px;">

    <div class="stat-card">
        <div class="stat-icon" style="background: #eff6ff;">🎫</div>
        <div>
            <div class="stat-label">Total Reports</div>
            <div class="stat-value">{{ $total }}</div>
            <div class="stat-sub">All submitted</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: #fffbeb;">🕒</div>
        <div>
            <div class="stat-label">Pending</div>
            <div class="stat-value" style="color: #f59e0b;">{{ $pending }}</div>
            <div class="stat-sub">Awaiting action</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: #fff7ed;">🔄</div>
        <div>
            <div class="stat-label">In Progress</div>
            <div class="stat-value" style="color: #f97316;">{{ $inProgress }}</div>
            <div class="stat-sub">Being handled</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: #f0fdf4;">✅</div>
        <div>
            <div class="stat-label">Resolved</div>
            <div class="stat-value" style="color: #10b981;">{{ $resolved }}</div>
            <div class="stat-sub">Completed</div>
        </div>
    </div>

</div>

{{-- Recent Tickets --}}
<div class="card-base" style="overflow: hidden;">
    <div style="padding: 20px 28px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h3 style="font-size: 1rem; font-weight: 700; color: var(--text); margin: 0;">Recent Reports</h3>
            <p style="font-size: 0.8rem; color: var(--text-muted); margin: 2px 0 0;">Your 5 most recently submitted reports</p>
        </div>
        <a href="{{ route('tickets.index') }}" class="btn-primary-custom" style="font-size: 0.82rem; padding: 8px 16px;">
            View All <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc;">
                    <th style="padding: 14px 28px; text-align: left; font-size: 0.72rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.06em;">Ticket ID</th>
                    <th style="padding: 14px 28px; text-align: left; font-size: 0.72rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.06em;">Subject</th>
                    <th style="padding: 14px 28px; text-align: left; font-size: 0.72rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.06em;">Department</th>
                    <th style="padding: 14px 28px; text-align: left; font-size: 0.72rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.06em;">Priority</th>
                    <th style="padding: 14px 28px; text-align: left; font-size: 0.72rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.06em;">Status</th>
                    <th style="padding: 14px 28px; text-align: left; font-size: 0.72rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.06em;">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTickets as $ticket)
                <tr class="ticket-row" onclick="window.location='{{ route('tickets.show', $ticket->id) }}'">
                    <td style="padding: 16px 28px; font-weight: 700; font-size: 0.9rem; color: var(--text-muted);">
                        #{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}
                    </td>
                    <td style="padding: 16px 28px; font-weight: 600; color: var(--text); font-size: 0.9rem;">
                        {{ Str::limit($ticket->title, 35) }}
                    </td>
                    <td style="padding: 16px 28px;">
                        <span class="badge-dept">{{ $ticket->department->name ?? 'N/A' }}</span>
                    </td>
                    <td style="padding: 16px 28px;">
                        @if($ticket->priority == 'High')
                            <span class="badge-status badge-priority-high"><i class="fas fa-circle" style="font-size: 0.5rem;"></i> High</span>
                        @elseif($ticket->priority == 'Medium')
                            <span class="badge-status badge-priority-medium"><i class="fas fa-circle" style="font-size: 0.5rem;"></i> Medium</span>
                        @else
                            <span class="badge-status badge-priority-low"><i class="fas fa-circle" style="font-size: 0.5rem;"></i> Low</span>
                        @endif
                    </td>
                    <td style="padding: 16px 28px;">
                        @if($ticket->status == 'Pending')
                            <span class="badge-status badge-pending">⏳ Pending</span>
                        @elseif($ticket->status == 'In Progress')
                            <span class="badge-status badge-progress">🔄 In Progress</span>
                        @elseif($ticket->status == 'Resolved')
                            <span class="badge-status badge-resolved">✅ Resolved</span>
                        @else
                            <span class="badge-status badge-cancelled">✗ Cancelled</span>
                        @endif
                    </td>
                    <td style="padding: 16px 28px; font-size: 0.85rem; color: var(--text-muted);">
                        {{ $ticket->created_at->format('M d, Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 60px; text-align: center;">
                        <div style="font-size: 2.5rem; margin-bottom: 12px;">📋</div>
                        <div style="font-size: 1rem; font-weight: 600; color: var(--text-muted); margin-bottom: 8px;">No reports yet</div>
                        <a href="{{ route('tickets.create') }}" class="btn-primary-custom" style="font-size: 0.85rem; padding: 10px 20px;">
                            <i class="fas fa-plus"></i> Submit your first report
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection