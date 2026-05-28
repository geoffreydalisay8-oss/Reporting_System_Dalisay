@extends('layouts.app')
@section('content')

<!-- Hero Section -->
<section id="home" class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="text-center">
        <h1 class="display-1 fw-bold mb-4">Welcome to <br> <span class="text-brand">ReportPortal</span></h1>
        <p class="lead mb-5" style="max-width: 700px; color: #94a3b8;" >
           ReportPortal is designed to transform manual, inefficient habits into a professional, trackable, and transparent digital environment for your organization. </p>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-5">
    <div class="container py-5">
        <h2 class="mb-4">About <span class="text-brand">ReportPortal</span></h2>
        <div class="row align-items-center">
            <div class="col-lg-7">
                <p class="fs-4" style="color: #94a3b8;">
                   ReportPortal built for to replace unreliable manual reporting methods with a centralized, automated system that ensures every incident and complaint is professionally tracked, transparently resolved, and held to the highest standards of organizational accountability.
                </p>
            </div>
            <div class="col-lg-5">
                <div class="p-4 bg-card rounded-4 border">
                    <h5 class="text-brand">Our Goal</h5>
                    <p class="text-light">Our goal is to provide total transparency and accountability across every department in your organization.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Features Section -->
<section id="features" class="py-5">
    <div class="container py-5">
        <h2 class="text-center mb-5">System Capabilities</h2>
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="p-5 bg-card rounded-4 h-100">
                    <h4 class="text-brand mb-3">Automated Ticketing</h4>
                    <p class="text-light">ReportPortal automatically generates tickets upon submission, reducing manual workload and ensuring consistency.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-5 bg-card rounded-4 h-100">
                    <h4 class="text-brand mb-3">Role-Based Access</h4>
                    <p class="text-light">Enhances security by organizing system usage among users, staff, and administrators through structured access control.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-5 bg-card rounded-4 h-100">
                    <h4 class="text-brand mb-3">Real-Time Tracking</h4>
                    <p class="text-light">Users and staff can view ticket statuses (open, in progress, resolved) and receive updates in real time.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section id="how-it-works" class="py-5" style="background-color: #0f172a;">
    <div class="container py-5">
        <h2 class="text-center mb-5 fw-bold text-white">How It Works</h2>
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="p-4">
                    <div class="display-5 fw-bold text-primary mb-3">01</div>
                    <h4 class="text-white">Report</h4>
                    <p class="text-white-50">Users submit incidents or complaints through form, including category, description, and priority level.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4">
                    <div class="display-5 fw-bold text-primary mb-3">02</div>
                    <h4 class="text-white">Automate</h4>
                    <p class="text-white-50">The system automatically generates a ticket and assigns it to the appropriate department or support agent.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4">
                    <div class="display-5 fw-bold text-primary mb-3">03</div>
                    <h4 class="text-white">Resolve</h4>
                    <p class="text-white-50">Users and staff view real-time status updates (open, in progress, resolved) until the issue is closed.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection