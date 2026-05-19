<form action="{{ url()->current() }}" method="GET" class="row g-3 mb-4 align-items-center bg-white p-3 rounded shadow-sm mx-0 border">
    <div class="col-lg-6">
        <div class="input-group">
            <span class="input-group-text bg-transparent border-end-0 text-muted">
                <i class="fas fa-search"></i>
            </span>
            <input type="text" name="search" class="form-control border-start-0 ps-0" 
                   placeholder="Search by name or ID..." value="{{ request('search') }}">
        </div>
    </div>

    <div class="col-lg-4">
        <select name="type" class="form-select border-primary border-2 shadow-none">
            <option value="all">All Types (Complaint/Incident)</option>
            <option value="Complaint" {{ request('type') == 'Complaint' ? 'selected' : '' }}>Complaint</option>
            <option value="Incident" {{ request('type') == 'Incident' ? 'selected' : '' }}>Incident</option>
        </select>
    </div>

    <div class="col-lg-2 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100 fw-bold">Filter</button>
        <a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>