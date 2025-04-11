@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-4 text-primary fw-bold">Admin Dashboard</h3>

    @if($links->count())
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white fw-bold">
                All Shortened Links
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="linksTable" class="table table-striped table-bordered align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center py-3 px-4">#</th>
                                <th class="text-center py-3 px-4">Original URL</th>
                                <th class="text-center py-3 px-4">Short Link</th>
                                <th class="text-center py-3 px-4">Clicks</th>
                                <th class="text-center py-3 px-4">Created At</th>
                                <th class="text-center py-3 px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($links as $link)
                                <tr>
                                    <td class="text-center py-2 px-4">{{ $loop->iteration }}</td>
                                    <td class="text-center text-truncate py-2 px-4" style="max-width: 250px;">
                                        <a href="{{ $link->original_url }}" target="_blank" class="text-decoration-none text-primary">
                                            {{ $link->original_url }}
                                        </a>
                                    </td>
                                    <td class="text-center py-2 px-4">
                                        <a href="{{ $link->short_code }}" target="_blank" class="text-decoration-none text-success">
                                            {{ $link->short_code }}
                                        </a>
                                    </td>
                                    <td class="text-center py-2 px-4">{{ $link->clicks }}</td>
                                    <td class="text-center py-2 px-4">{{ $link->created_at->format('d M Y') }}</td>
                                    <td class="text-center py-2 px-4">
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
<script>
    $(document).ready(function() {
        $('#linksTable').DataTable({
            responsive: true,
            language: {
                search: "Search links:",
                paginate: {
                    previous: "Previous",
                    next: "Next"
                }
            },
            pageLength: 10,
            autoWidth: false,
            columnDefs: [
                { targets: [0, 1, 2, 3, 4, 5], className: 'text-center' }
            ]
        });
    });
</script>
@endpush
