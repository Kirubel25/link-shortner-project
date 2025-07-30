@extends('layouts.app')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">

            {{-- URL Shortener Card --}}
            <div class="card shadow rounded-4 border-0">
                <div class="card-header bg-primary text-white text-center fw-bold fs-4 rounded-top-4">
                    <i class="bi bi-link-45deg me-2"></i> Shorten Your URL
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('shorten') }}" method="POST" novalidate>
                        @csrf

                        <div class="mb-3">
                            <label for="original_url" class="form-label fw-semibold">Enter a URL</label>
                            <input 
                                type="url" 
                                name="original_url" 
                                id="original_url"
                                class="form-control @error('original_url') is-invalid @enderror" 
                                placeholder="https://example.com" 
                                value="{{ old('original_url') }}" 
                                required 
                                autofocus
                            >
                            @error('original_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-semibold">
                            <i class="bi bi-magic me-1"></i> Generate Short Link
                        </button>
                    </form>

                    @if(session('success'))
                        <div class="alert alert-success mt-4">
                            <label for="shortened-link" class="form-label fw-semibold">Your shortened link:</label>
                            <div class="input-group">
                                <input 
                                    type="text" 
                                    id="shortened-link" 
                                    class="form-control" 
                                    value="{{ session('success') }}" 
                                    readonly
                                >
                                <button 
                                    class="btn btn-outline-secondary" 
                                    type="button"
                                    onclick="copyToClipboard()"
                                >
                                    <i class="bi bi-clipboard"></i> Copy
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="card-footer bg-light text-center text-muted rounded-bottom-4">
                    <small>Powered by <strong>Shortify</strong></small>
                </div>
            </div>

            {{-- User Links Card --}}
            @auth
            <div class="card shadow mt-5 border-0 rounded-4">
                <div class="card-header bg-secondary text-white text-center fw-bold fs-5 rounded-top-4">
                    <i class="bi bi-clock-history me-2"></i> Your Generated Links
                </div>

                <div class="card-body p-4">
                    @if($userLinks->isEmpty())
                        <p class="text-center text-muted">You haven't shortened any links yet.</p>
                    @else
                        <div class="list-group">
                            @foreach($userLinks as $link)
                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="me-3">
                                        <div class="fw-semibold text-truncate" style="max-width: 300px;">
                                            <i class="bi bi-link"></i> {{ Str::limit($link->original_url, 50) }}
                                        </div>
                                        <small>
                                            <i class="bi bi-arrow-right-short"></i> 
                                            <a href="{{ url('/s/' . $link->short_code) }}" target="_blank">{{ url('/s/' . $link->short_code) }}</a>
                                        </small>
                                    </div>
                                    <form method="POST" action="{{ route('user.link.delete', ['id' => $link->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            @endauth

        </div>
    </div>
</div>

@push('scripts')
<script>
    function copyToClipboard() {
        const input = document.getElementById('shortened-link');
        input.select();
        input.setSelectionRange(0, 99999); // mobile support

        navigator.clipboard.writeText(input.value)
            .then(() => {
                showToast('Link copied to clipboard!');
            })
            .catch(err => console.error('Copy failed', err));
    }

    function showToast(message) {
        const toastContainer = document.createElement('div');
        toastContainer.className = 'toast align-items-center text-white bg-success border-0 position-fixed bottom-0 end-0 m-3';
        toastContainer.setAttribute('role', 'alert');
        toastContainer.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        document.body.appendChild(toastContainer);
        const toast = new bootstrap.Toast(toastContainer);
        toast.show();

        setTimeout(() => toastContainer.remove(), 4000);
    }
</script>
@endpush

@endsection
