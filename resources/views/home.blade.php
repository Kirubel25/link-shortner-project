@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center fw-bold">
                    Shorten Your URL
                </div>
                <div class="card-body">
                    <form action="{{ route('shorten') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="original_url" class="form-label fw-semibold">Enter a URL to shorten</label>
                            <input type="url" name="original_url" class="form-control @error('original_url') is-invalid @enderror" placeholder="https://example.com" required>
                            @error('original_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button class="btn btn-success w-100">Generate Short Link</button>
                    </form>

                    @if(session('success'))
                        <div class="mt-4">
                            <label class="form-label fw-semibold">Your shortened link:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" readonly value="{{ session('success') }}">
                                <button class="btn btn-outline-secondary" onclick="navigator.clipboard.writeText('{{ session('success') }}')">Copy</button>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-light text-center text-muted">
                    <small>Powered by Shortify</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
