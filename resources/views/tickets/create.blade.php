@extends('layouts.employee')

@section('content')
<style>
    .form-input-lg {
        width: 100%; 
        padding: 16px 20px; 
        border: 2px solid #e2e8f0; 
        border-radius: 12px; 
        font-size: 1.1rem; 
        transition: all 0.3s ease;
        color: #1e293b;
    }
    .form-input-lg:focus {
        outline: none;
        border-color: #3498db;
        box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.15);
        background-color: #fff;
    }
    .section-header {
        border-bottom: 2px solid #f1f5f9;
        padding-bottom: 10px;
        margin-bottom: 25px;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.85rem;
        font-weight: 700;
    }
    .btn-lg {
        padding: 18px 30px;
        font-size: 1.1rem;
        font-weight: 700;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s;
    }
</style>

<div style="max-width: 1100px; margin: 0 auto; padding: 40px 20px;">
    
    <!-- Header Section -->
    <div style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h1 style="color: #0f172a; font-size: 2.5rem; font-weight: 800; margin: 0; letter-spacing: -1px;">Submit New Report</h1>
            <p style="color: #64748b; font-size: 1.2rem; margin-top: 8px;">Detailed incident reporting and formal complaints portal.</p>
        </div>
        <div style="text-align: right; color: #94a3b8; font-size: 0.9rem;">
            Fields marked with <span style="color: #ef4444;">*</span> are required
        </div>
    </div>

    <!-- Error Block -->
    @if ($errors->any())
        <div style="background: #fff1f2; border-left: 6px solid #e11d48; padding: 20px; border-radius: 12px; margin-bottom: 30px;">
            <h4 style="margin: 0 0 10px 0; color: #9f1239;">Please correct the following errors:</h4>
            <ul style="margin: 0; padding-left: 20px; color: #be123c;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="background: white; border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08); overflow: hidden; border: 1px solid #f1f5f9;">
        <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data" style="padding: 50px;">
            @csrf
            
            <!-- Section 1: Classification -->
            <div class="section-header">1. Classification & Urgency</div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 40px;">
                
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 10px; color: #334155;">
                        Department <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="department_id" required class="form-input-lg" style="background-color: #f8fafc; appearance: none;">
                        <option value="">-- Select Department --</option>
                        @foreach(\App\Models\Department::all() as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 10px; color: #334155;">
                        Priority Level <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="priority" class="form-input-lg" style="background-color: #f8fafc;">
                        <option value="Low">Low - Minor inconvenience</option>
                        <option value="Medium" selected>Medium - Standard response</option>
                        <option value="High">High - Urgent attention</option>
                    </select>
                </div>

            </div>

            <!-- Section 2: Details -->
            <div class="section-header">2. Issue Information</div>
            <div style="margin-bottom: 30px;">
                <label style="display: block; font-weight: 600; margin-bottom: 10px; color: #334155;">Report Title <span style="color: #ef4444;">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" 
                    placeholder="E.g. Server Room AC Failure or Workplace Safety Concern" 
                    class="form-input-lg" required>
            </div>

            <div style="margin-bottom: 40px;">
                <label style="display: block; font-weight: 600; margin-bottom: 10px; color: #334155;">Full Description <span style="color: #ef4444;">*</span></label>
                <textarea name="description" rows="8" 
                    placeholder="Please provide as much detail as possible. Include dates, locations, and individuals involved if applicable." 
                    class="form-input-lg" style="resize: vertical;" required>{{ old('description') }}</textarea>
            </div>

            <!-- Section 3: Attachment -->
            <div class="section-header">3. Supporting Evidence (Optional)</div>
            <div style="margin-bottom: 50px;">
                <div id="drop-zone" style="border: 2px dashed #cbd5e1; border-radius: 16px; padding: 40px; text-align: center; background: #f8fafc; transition: all 0.3s;">
                    <input type="file" name="attachment" id="file-upload" style="display: none;" accept=".jpg,.png,.pdf,.doc,.docx">
                    
                    <label for="file-upload" style="cursor: pointer; display: block;">
                        <span style="font-size: 3rem;">📸</span>
                        <p id="file-label" style="font-size: 1.1rem; color: #475569; margin: 10px 0;">
                            <strong>Click to upload</strong> or drag and drop
                        </p>
                        <p style="color: #94a3b8; font-size: 0.9rem;">PNG, JPG, PDF, or DOC up to 2MB</p>
                    </label>
                </div>
            </div>

            <script>
                document.getElementById('file-upload').onchange = function() {
                    const fileName = this.files[0] ? this.files[0].name : "Click to upload or drag and drop";
                    document.getElementById('file-label').innerHTML = `<strong>Selected:</strong> ${fileName}`;
                    document.getElementById('drop-zone').style.borderColor = "#3498db";
                    document.getElementById('drop-zone').style.background = "#ebf8ff";
                };
            </script>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 20px; align-items: center; justify-content: flex-end; padding-top: 30px; border-top: 2px solid #f1f5f9;">
                <a href="{{ route('dashboard') }}" class="btn-lg" style="text-decoration: none; color: #64748b; background: #f1f5f9; border: none; flex: 1; text-align: center;">
                    Cancel and Return
                </a>
                <button type="submit" class="btn-lg" style="background: #3498db; color: white; border: none; flex: 2; box-shadow: 0 4px 14px 0 rgba(52, 152, 219, 0.39);">
                    Submit Official Report
                </button>
            </div>
        </form>
    </div>
</div>
@endsection