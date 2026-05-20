<style>
    .form-container { max-width: 650px; margin: 0 auto; }
    .back-link { text-decoration: none; color: #4a90e2; font-size: 0.9rem; font-weight: 600; margin-bottom: 10px; display: block; }
    
    .form-card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #444; font-size: 0.9rem; }
    
    .form-input { 
        width: 100%; padding: 12px; border: 1px solid #e1e1e1; border-radius: 8px; outline: none; transition: 0.2s; 
        box-sizing: border-box; /* Crucial for padding */
    }
    .form-input:focus { border-color: #4a90e2; box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1); }
    
    .btn-submit { 
        width: 100%; background: #4a90e2; color: white; border: none; padding: 14px; 
        border-radius: 8px; font-size: 1rem; font-weight: 700; cursor: pointer; transition: 0.3s; 
    }
    .btn-submit:hover { background: #357abd; }

    .error-box { background: #fff5f5; color: #c53030; padding: 15px; border-radius: 8px; border: 1px solid #feb2b2; margin-bottom: 20px; }
</style>

<div class="main-content">
    <div class="form-container">
        <a href="{{ route('admin.staff.index') }}" class="back-link">← Back to Staff List</a>
        <h1 style="margin-bottom: 25px; font-weight: 800; color: #2c3e50;">
            {{ isset($staff) ? 'Edit Staff: '.$staff->name : 'Create New Staff' }}
        </h1>

        @if ($errors->any())
            <div class="error-box">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <div class="form-card">
            <form action="{{ isset($staff) ? route('admin.staff.update', $staff->id) : route('admin.staff.store') }}" method="POST">
                @csrf
                @if(isset($staff)) @method('PUT') @endif
                
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" class="form-input" placeholder="e.g. John Doe" value="{{ $staff->name ?? old('name') }}" required>
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-input" placeholder="john@example.com" value="{{ $staff->email ?? old('email') }}" required>
                </div>

                @if(!isset($staff))
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-input" required>
                </div>
                @endif

                <div class="form-group">
                    <label>Type</label>
                    <select name="type" class="form-input" required>
                        <option value="">-- Select Type --</option>
                        <option value="Complaint" {{ (isset($staff) && $staff->type == 'Complaint') ? 'selected' : '' }}>Complaint</option>
                        <option value="Incident" {{ (isset($staff) && $staff->type == 'Incident') ? 'selected' : '' }}>Incident</option>
                    </select>
                </div>
                </div>

                <button type="submit" class="btn-submit">
                    {{ isset($staff) ? 'Update Staff Member' : 'Create Staff Account' }}
                </button>
            </form>
        </div>
    </div>
</div>