@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">VCMS - Manage Sections</h2>

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pages as $page)
                        <tr>
                            <td>{{ $page->title }}</td>
                            <td>{{ $page->slug }}</td>
                            <td>
                                <!-- tombol buka modal -->
                                <button class="btn btn-primary btn-sm" onclick="openModal('{{ $page->slug }}')">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

</div>

<!-- Modal (akan diisi AJAX) -->
<div id="editModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="modalContent">
            <!-- temp -->
            <div class="p-5 text-center">Loading...</div>
        </div>
    </div>
</div>

<script>
function openModal(slug) {
    // ambil halaman edit lewat ajax
    fetch(`/vcms/${slug}/edit`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('modalContent').innerHTML = html;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        });
}
</script>

@endsection
