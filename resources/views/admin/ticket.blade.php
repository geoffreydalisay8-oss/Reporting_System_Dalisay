@extends('layouts.admin')

@section('content')

<div class="incident-container p-4">
    <h1 class="page-title mb-4" style="font-weight: 800; color: #0f172a;">Incident & Complaint</h1>

    <div class="bg-white p-3 rounded shadow-sm mb-4 border">
    <form id="filterForm" action="{{ url()->current() }}" method="GET" class="row g-3 align-items-center">
        <div class="col-lg-6">
            <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0" 
                       placeholder="Search by Title, Reporter, or ID..." value="{{ request('search') }}">

            </div>
        </div>

       <div class="col-lg-5 col-md-4">
                <select name="category" class="form-select border-primary border-2 shadow-none">
                    <option value="all">All Departments</option>
                    @foreach(\App\Models\Department::all() as $dept)
                        <option value="{{ $dept->id }}" {{ request('category') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
        </form>
</div>

    <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
        <table class="table align-middle mb-0" style="min-width: 1000px;">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 py-3 text-uppercase text-secondary small" style="letter-spacing: 1px;">Ticket</th>
                    <th class="py-3 text-uppercase text-secondary small" style="letter-spacing: 1px;">Title & Reporter</th>
                    <th class="py-3 text-uppercase text-secondary small" style="letter-spacing: 1px;">department</th>
                    <th class="py-3 text-uppercase text-secondary small" style="letter-spacing: 1px;">Priority</th>
                    <th class="py-3 text-uppercase text-secondary small" style="letter-spacing: 1px;">Status</th>
                    <th class="py-3 text-center text-uppercase text-secondary small" style="letter-spacing: 1px; width: 300px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                <tr>
                    <td class="ps-4">
                        <span class="fw-bold text-dark" style="font-size: 1.1rem;">#{{ $ticket->id }}</span>
                    </td>
                    <td>
                        <div class="fw-bold text-dark" style="font-size: 1rem;">{{ $ticket->title }}</div>
                        <div class="text-muted small">{{ $ticket->user->name ?? 'Guest' }}</div>
                    </td>
                    <td><span class="badge bg-light text-primary border">{{ $ticket->department->name ?? 'N/A' }}</span></td>
                    <td>
                        <span class="fw-bold" style="color: {{ $ticket->priority == 'High' ? '#ef4444' : ($ticket->priority == 'Medium' ? '#f59e0b' : '#10b981') }};">
                            ● {{ $ticket->priority }}
                        </span>
                    </td>
                    <td>
                        <span class="badge rounded-pill px-3 py-2" style="
                            background: {{ $ticket->status == 'Resolved' ? '#dcfce7' : ($ticket->status == 'In Progress' ? '#ffedd5' : '#f1f5f9') }}; 
                            color: {{ $ticket->status == 'Resolved' ? '#166534' : ($ticket->status == 'In Progress' ? '#9a3412' : '#475569') }};">
                            {{ $ticket->status }}
                        </span>
                    </td>
                    <td class="pe-4">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            @if(Auth::user()->role === 'admin')
                                <form action="{{ route('admin.tickets.assign', $ticket->id) }}" method="POST" class="m-0 flex-grow-1">
                                    @csrf
                                    <select name="assigned_to" class="form-select form-select-sm" onchange="this.form.submit()" style="border-radius: 8px;">
                                            {{-- Option for unassigning --}}
                                            <option value="" {{ is_null($ticket->assigned_to) ? 'selected' : '' }}>— Unassigned —</option> 
                                            
                                            @foreach($staffMembers as $staff)
                                                <option value="{{ $staff->id }}" {{ $ticket->assigned_to == $staff->id ? 'selected' : '' }}>
                                                    {{ $staff->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                </form>
                                <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-sm btn-outline-primary" style="border-radius: 20px;"> </a>
                                    
                              
                            @else
                                <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-sm btn-primary w-100" style="border-radius: 8px;">
                                    View & Reply
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">No incidents found in the system.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filterForm');
        const searchInput = filterForm.querySelector('input[name="search"]');
        const typeSelect = filterForm.querySelector('select[name="category"]');

        // 1. Automatic for the Dropdown (Instant)
        typeSelect.addEventListener('change', function() {
            filterForm.submit();
        });

        // 2. Automatic for Search (Debounced)
        // This waits for the user to stop typing for 500ms before submitting
        let typingTimer;
        const doneTypingInterval = 500; 

        searchInput.addEventListener('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {
                // Submit only if search is empty (reset) or more than 2 characters
                if (searchInput.value.length > 2 || searchInput.value.length === 0) {
                    filterForm.submit();
                }
            }, doneTypingInterval);
        });

        // Keep the cursor at the end of the input after auto-refresh
        if(searchInput.value.length > 0) {
            searchInput.focus();
            searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
        }
    });
</script>
@endsection