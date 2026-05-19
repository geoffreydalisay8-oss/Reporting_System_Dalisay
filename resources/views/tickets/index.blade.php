
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@extends('layouts.employee')

@section('content')
<div style="max-width: 1400px; margin: 0 auto; padding: 20px;">
    <!-- Header Section with increased size -->
    <div style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="color: #0f172a; margin: 0; font-size: 2.5rem; font-weight: 800; letter-spacing: -0.025em;">My Tickets</h1>
            <p style="color: #64748b; margin-top: 8px; font-size: 1.1rem;">View, track, and manage all your submitted reports in one place.</p>
        </div>
        <a href="{{ route('tickets.create') }}" style="background: #3b82f6; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: background 0.2s;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
            + Create New Ticket
        </a>
    </div>
    
   <div class="bg-white p-3 rounded shadow-sm mb-4 border">
    <form id="userFilterForm" action="{{ url()->current() }}" method="GET" class="row g-3 align-items-center">
        <div class="col-lg-7 col-md-6">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control border-start-0 ps-0" 
                       placeholder="Search by subject or ticket ID..." value="{{ request('search') }}">
            </div>
        </div>

        <div class="col-lg-5 col-md-4">
            <select name="category" class="form-select border-primary border-2 shadow-none">
                <option value="all">All Categories</option>
                <option value="Complaint" {{ request('category') == 'Complaint' ? 'selected' : '' }}>Complaint</option>
                <option value="Incident" {{ request('category') == 'Incident' ? 'selected' : '' }}>Incident</option>
            </select>
        </div>
    </form>
</div>


    <!-- Main Large Table Container -->
    <div class="content-card" style="padding: 0; overflow: hidden; background: white; border-radius: 16px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
        <table style="width: 100%; border-collapse: collapse; min-width: 1000px;">
            <thead>
                <tr style="border-bottom: 2px solid #f1f5f9; background: #f8fafc;">
                    <th style="padding: 20px 30px; text-align: left; color: #475569; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Ticket ID</th>
                    <th style="padding: 20px 30px; text-align: left; color: #475569; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Subject</th>
                    <th style="padding: 20px 30px; text-align: left; color: #475569; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Category</th>
                    <th style="padding: 20px 30px; text-align: left; color: #475569; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Priority</th>
                    <th style="padding: 20px 30px; text-align: left; color: #475569; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Status</th>
                    <th style="padding: 20px 30px; text-align: left; color: #475569; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Created Date</th>
                    <th style="padding: 20px 30px; text-align: center; color: #475569; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Action</th>
                </tr>
            </thead>
          <tbody style="cursor: pointer;">
    @forelse($tickets as $ticket)
    <tr style="border-bottom: 1px solid #f1f5f9; transition: all 0.2s;" 
        onmouseover="this.style.background='#f8fafc';" 
        onmouseout="this.style.background='transparent';"
        onclick="window.location='{{ route('tickets.show', $ticket->id) }}'">
        
        <td style="padding: 25px 30px; font-weight: 700; color: #1e293b; font-size: 1rem;">
            <span style="color: #64748b; font-weight: 400;">#</span>{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}
        </td>
        
        <td style="padding: 25px 30px;">
            <div style="font-weight: 600; color: #0f172a; font-size: 1.1rem;">{{ $ticket->title }}</div>
        </td>
        
        <td style="padding: 25px 30px;">
            <span style="background: #eff6ff; color: #1d4ed8; padding: 6px 14px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; border: 1px solid #dbeafe;">
                {{ $ticket->type }}
            </span>
        </td>

        <td style="padding: 25px 30px;">
            <span style="background: {{ $ticket->priority == 'High' ? '#fef2f2' : '#f8fafc' }}; color: {{ $ticket->priority == 'High' ? '#b91c1c' : '#475569' }}; padding: 6px 14px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; border: 1px solid {{ $ticket->priority == 'High' ? '#fee2e2' : '#e2e8f0' }};">
                {{ $ticket->priority }}
            </span>
        </td>

        <td style="padding: 25px 30px;">
            <span style="background: {{ $ticket->status == 'In Progress' ? '#fff7ed' : ($ticket->status == 'Resolved' ? '#f0fdf4' : ($ticket->status == 'Cancelled' ? '#fef2f2' : '#f8fafc')) }}; color: {{ $ticket->status == 'In Progress' ? '#9a3412' : ($ticket->status == 'Resolved' ? '#166534' : ($ticket->status == 'Cancelled' ? '#991b1b' : '#64748b')) }}; padding: 8px 16px; border-radius: 8px; font-size: 0.9rem; font-weight: 700; display: inline-block; min-width: 100px; text-align: center; border: 1px solid {{ $ticket->status == 'In Progress' ? '#ffedd5' : ($ticket->status == 'Resolved' ? '#dcfce7' : ($ticket->status == 'Cancelled' ? '#fee2e2' : '#e2e8f0')) }};">
                {{ $ticket->status }}
            </span>
        </td>

        <td style="padding: 25px 30px; color: #64748b; font-size: 1rem;">
            {{ $ticket->created_at->format('M d, Y') }}
        </td>
        
     <td style="padding: 25px 30px; text-align: center; white-space: nowrap;">
    <div style="display: flex; gap: 10px; justify-content: center; align-items: center;">
        
        {{-- View Details Button --}}
        <a href="{{ route('tickets.show', $ticket->id) }}" 
           style="background: #f1f5f9; color: #0f172a; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 0.9rem; display: inline-block; line-height: 1.2;">
            View Details
        </a>

        {{-- Cancel Button Section --}}
        @if($ticket->status === 'Pending')
            <form action="{{ route('tickets.cancel', $ticket->id) }}" method="POST" 
                  style="display: flex; margin: 0; padding: 0;" {{-- Fixed: Flex and No Margin --}}
                  onclick="event.stopPropagation();"
                  onsubmit="return confirm('Are you sure you want to cancel this ticket?');">
                @csrf
                <button type="submit" 
                        style="background: #fff1f2; color: #e11d48; border: 1px solid #fda4af; padding: 10px 18px; border-radius: 8px; font-weight: 700; font-size: 0.9rem; cursor: pointer; display: flex; align-items: center; gap: 6px; line-height: 1.2;">
                    <i class="fas fa-times-circle"></i> Cancel
                </button>
            </form>
        @endif
        
    </div>
</td>
    </tr>
    @empty
    <tr>
        <td colspan="7" style="padding: 100px 30px; text-align: center;">
            <div style="font-size: 1.5rem; color: #94a3b8; margin-bottom: 10px;">No tickets found</div>
            <a href="{{ route('tickets.create') }}" style="color: #3b82f6; text-decoration: none; font-weight: 700;">Submit your first ticket &rarr;</a>
        </td>
    </tr>
    @endforelse
</tbody>
        </table>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userForm = document.getElementById('userFilterForm');
        const searchInput = userForm.querySelector('input[name="search"]');
        const categorySelect = userForm.querySelector('select[name="category"]');

        // Instant refresh on category change
        categorySelect.addEventListener('change', function() {
            userForm.submit();
        });

        // Debounced search for the subject
        let typingTimer;
        searchInput.addEventListener('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {
                if (searchInput.value.length > 2 || searchInput.value.length === 0) {
                    userForm.submit();
                }
            }, 500);
        });

        // Keep focus for a smooth typing experience
        if(searchInput.value.length > 0) {
            searchInput.focus();
            searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
        }
    });
</script>
@endsection