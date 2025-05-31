@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2 class="mb-4">Menu Category List</h2>

        {{-- @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif --}}
        <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary mb-3">+ Add Category</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Category Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kategori as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->nama_kategori }}</td>
                        <td>
                            <a href="{{ route('admin.kategori.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('admin.kategori.destroy', $item->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger btn-delete">Delete</button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <script>
        // Konfirmasi sebelum menghapus
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');
                const url = form.getAttribute('data-url');

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
