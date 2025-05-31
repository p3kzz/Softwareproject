@extends('layouts.admin')
@section('content')
    <div class="container mt-5">
        <h4>Add Table</h4>
        <form action="{{ route('admin.mejaQr.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nomor_meja" class="form-label">Table Number </label>
                <input type="number" name="nomor_meja" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
