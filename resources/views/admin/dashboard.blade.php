@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-4 text-primary fw-bold">Admin Dashboard</h3>

    @if($links->count())
        {{-- Dashboard Analytics --}}
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary shadow-sm rounded-lg">
                    <div class="card-body text-center">
                        <h6 class="card-title mb-2">Total Links</h6>
                        <h4 class="fw-bold">{{ $links->count() }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success shadow-sm rounded-lg">
                    <div class="card-body text-center">
                        <h6 class="card-title mb-2">Total Clicks</h6>
                        <h4 class="fw-bold">{{ $links->sum('clicks') }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info shadow-sm rounded-lg">
                    <div class="card-body text-center">
                        <h6 class="card-title mb-2">Top Link</h6>
                        <h6 class="fw-bold text-truncate">
                            {{ Str::limit($links->sortByDesc('clicks')->first()->original_url, 25) }}
                        </h6>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning shadow-sm rounded-lg">
                    <div class="card-body text-center">
                        <h6 class="card-title mb-2">Most Clicks</h6>
                        <h4 class="fw-bold">{{ $links->max('clicks') }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Chart --}}
        <div class="card shadow mb-4 border-0">
            <div class="card-header bg-light fw-bold">
                Clicks Over Time
            </div>
            <div class="card-body">
                <canvas id="analyticsChart" height="100"></canvas>
            </div>
        </div>

        {{-- Table --}}
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white fw-bold">
                All Shortened Links
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="linksTable" class="table table-striped table-bordered align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Original URL</th>
                            <th>Short Link</th>
                            <th>Clicks</th>
                            <th>Created By</th> {{-- New column --}}
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                        <tbody>
                            @foreach($links as $link)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-truncate" style="max-width: 250px;">
                                    <a href="{{ $link->original_url }}" target="_blank">
                                        {{ $link->original_url }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ url('s/' . $link->short_code) }}" target="_blank">
                                        {{ $link->short_code }}
                                    </a>
                                </td>
                                <td>{{ $link->clicks }}</td>
                                <td>{{ $link->user->name ?? '—' }}</td> {{-- Added --}}
                                <td>{{ $link->created_at->format('d M Y') }}</td>
                                <td>
                                    <form action="{{ route('link.delete', $link->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning text-center">
            No links found.
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function () {
        $('#linksTable').DataTable();

        // Prepare dummy chart data – Replace with your own
        const labels = @json($links->pluck('created_at')->map->format('M d'));
        const clicks = @json($links->pluck('clicks'));

        const ctx = document.getElementById('analyticsChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Clicks',
                    data: clicks,
                    fill: true,
                    backgroundColor: 'rgba(0,123,255,0.1)',
                    borderColor: '#007bff',
                    tension: 0.4,
                    pointBackgroundColor: '#007bff'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
