@extends('layout.adminDashboard')
@section('head')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

    #create-user-form {
        font-family: 'Roboto', sans-serif;
        max-width: 420px;
        margin: 0px auto;
        margin-bottom: 40px;
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 8px 32px rgba(60,60,60,0.12);
        padding: 2.5rem 2rem 2rem 2rem;
    }
    .form-title {
        font-weight: 700;
        letter-spacing: 1px;
        color: #2d3a4b;
        margin-bottom: 1.5rem;
    }
    .form-label {
        font-weight: 500;
        color: #495057;
    }
    .form-control {
        border-radius: 0.7rem;
        border: 1.5px solid #e3e6ed;
        font-size: 1rem;
        transition: border-color 0.2s;
        background: #f8fafc;
    }
    .form-control:focus {
        border-color: #4f8cff;
        background: #fff;
        box-shadow: 0 0 0 2px #e3eefd;
    }
    .input-group-text {
        background: #f0f4f8;
        border-radius: 0.7rem 0 0 0.7rem;
        border: 1.5px solid #e3e6ed;
        border-right: none;
        color: #4f8cff;
    }
    .btn-primary {
        border-radius: 0.7rem;
        padding: 0.6rem 2.5rem;
        font-weight: 600;
        background: linear-gradient(90deg, #4f8cff 0%, #6fc3ff 100%);
        border: none;
        transition: background 0.2s;
    }
    .btn-primary:hover {
        background: linear-gradient(90deg, #357ae8 0%, #4f8cff 100%);
    }
    .form-select {
        border-radius: 0.7rem;
        border: 1.5px solid #e3e6ed;
        background: #f8fafc;
    }
    .form-select:focus {
        border-color: #4f8cff;
        background: #fff;
        box-shadow: 0 0 0 2px #e3eefd;
    }
    .text-danger {
        font-size: 0.95rem;
        margin-top: 0.25rem;
    }
</style>
@endsection

@section('content')
<div id="create-user-form">
    <h2 class="form-title text-center mb-4">
        <i class="bi bi-person-plus-fill me-2"></i>
    </h2>
    <form action="{{ route('createUser') }}" method="POST" autocomplete="off">
        @csrf
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
            </div>
            @error('username')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Is Admin</label>
            <select class="form-select" name="is_admin" required>
                <option value="0" {{ old('is_admin') == '0' ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('is_admin') == '1' ? 'selected' : '' }}>Yes</option>
            </select
            @error('is_admin')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-person-plus me-1"></i> Create User
            </button>
        </div>
    </form>
</div>

<!-- Bootstrap Icons CDN (nếu chưa có) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection