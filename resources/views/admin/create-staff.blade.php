@extends('layouts.admin')

@section('content')
<style>
    .form-container { max-width: 600px; margin: 0 auto; padding: 20px; }
    
    /* Breadcrumb link */
    .back-link { text-decoration: none; color: #4a90e2; font-size: 0.9rem; font-weight: 600; display: inline-block; margin-bottom: 10px; transition: 0.2s; }
    .back-link:hover { color: #357abd; text-decoration: underline; }

    /* Heading */
    .page-title { margin-bottom: 25px; font-weight: 800; color: #2c3e50; font-size: 1.75rem; }

    /* Card Styling */
    .content-card { 
        background: white; 
        padding: 30px; 
        border-radius: 12px; 
        box-shadow: 0 4px 20px rgba(0,0,0,0.05); 
    }

    /* Form Elements */
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; margin-bottom: 8px; color: #4e73df; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; }
    
    .form-control { 
        width: 100%; 
        padding: 12px 15px; 
        border: 1px solid #d1d3e2; 
        border-radius: 8px; 
        font-size: 0.9rem;
        color: #6e707e;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        box-sizing: border-box; /* Prevents padding from breaking width */
    }
    .form-control:focus { border-color: #bac8f3; outline: 0; box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25); }

    /* Button */
    .btn-submit { 
        width: 100%; 
        background: #4a90e2; 
        color: white; 
        border: none; 
        padding: 14px; 
        border-radius: 8px; 
        font-size: 1rem; 
        font-weight: 700; 
        cursor: pointer; 
        transition: 0.3s background; 
        margin-top: 10px;
    }
    .btn-submit:hover { background: #357abd; box-shadow: 0 4px 12px rgba(74, 144, 226, 0.3); }

    /* Errors */
    .alert-danger { background: #fff5f5; color: #e74a3b; padding: 15px; border-radius: 8px; border-left: 5px solid #e74a3b; margin-bottom: 20px; font-size: 0.9rem; }
</style>

<div class="form-container">
    <a href="{{ route('admin.staff.index') }}" class="back-link">← Back to Staff List</a>
    <h1 class="page-title">Add New Staff</h1>

    @if ($errors->any())
        <div class="alert-danger">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="content-card">
        <form action="{{ route('admin.staff.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. John Doe" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="john@example.com" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">Assignment Type</label>
               <select name="type" class="form-select @error('type') is-invalid @enderror">
                   <option value="" selected disabled>Select Type...</option>
                    <option value="Complaint">Complaint</option>
                    <option value="Incident">Incident</option>
                </select>
                    @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            </div>

            <button type="submit" class="btn-submit">
                Create Staff Account
            </button>
        </form>
    </div>
</div>
@endsection