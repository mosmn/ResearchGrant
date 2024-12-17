@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <!-- Hero Section -->
    <div class="bg-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8 text-center text-md-start">
                    <h1 class="display-4 fw-bold mb-4">Research Grant Management System</h1>
                    <p class="lead mb-4">Streamline your research grant management process with our comprehensive system. Track, manage, and collaborate on research grants efficiently.</p>
                    @guest
                        <div class="d-grid gap-2 d-md-block">
                            <a href="{{ route('login') }}" class="btn btn-light btn-lg px-4 me-md-2">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">Register</a>
                            @endif
                        </div>
                    @else
                        <a href="{{ route('grants.index') }}" class="btn btn-light btn-lg px-4">Go to Dashboard</a>
                    @endguest
                </div>
                <div class="col-md-4 d-none d-md-block text-center">
                    <i class="bi bi-diagram-3 display-1"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container py-5">
        <h2 class="text-center mb-5">Key Features</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center">
                    <i class="bi bi-graph-up display-5 text-primary mb-3"></i>
                    <h4>Grant Tracking</h4>
                    <p>Monitor research grants and track their progress effectively</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <i class="bi bi-people display-5 text-primary mb-3"></i>
                    <h4>Team Collaboration</h4>
                    <p>Collaborate with team members and manage research activities</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <i class="bi bi-calendar-check display-5 text-primary mb-3"></i>
                    <h4>Milestone Management</h4>
                    <p>Set and track research milestones and deliverables</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4">Get in Touch</h2>
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <p class="mb-4">Have questions about our research grant management system?</p>
                    <a href="mailto:contact@example.com" class="btn btn-primary btn-lg">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
