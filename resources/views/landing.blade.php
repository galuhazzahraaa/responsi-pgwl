@extends('layouts.template')

@section('styles')
<style>
    /* Style khusus untuk landing page */
    .landing-page {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        background-color:#dcebf9;
    }

    .landing-content {
        text-align: center;
    }

    .landing-content h1 {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .landing-content p {
        font-size: 1.25rem;
        margin-bottom: 2rem;
    }

    .btn-primary {
        font-size: 1.25rem;
        padding: 0.75rem 1.5rem;
    }
</style>
@endsection

@section('content')
<div class="landing-page">
    <div class="landing-content">
        <h1>Welcome to Bandung Legendary Craving Map</h1>
        <p>Explore interactive maps and data visualization.</p>
        <a href="{{ url('/index-public') }}" class="btn btn-primary">Get Started</a>
    </div>
</div>
@endsection
