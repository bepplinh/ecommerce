@extends('layout.adminDashboard')
@section('head')
<style>
    #edit-user-form {
        font-family: 'Roboto', sans-serif;
        max-width: 420px;
        margin: 40px auto;
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
    .form-control, .form-select {
        border-radius: 0.7rem;
        border: 1.5px solid #e3e6ed;
        font-size: 1rem;
        transition: border-color 0.2s;
        background: #f8fafc;
    }
    .form-control:focus, .form-select:focus {
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
    .btn-back {
        border-radius: 0.7rem;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
        background: #e3e6ed;
        color: #2d3a4b;
        border: none;
        margin-bottom: 1.5rem;
        transition: background 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }
    .btn-back:hover {
        background: #d1d7e0;
        color: #357ae8;
        text-decoration: none;
    }
    .text-danger {
        font-size: 0.95rem;
        margin-top: 0.25rem;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection

@section('content')
<a href="{{ route('showUsers') }}" class="btn-back mb-3" style="max-width: 420px; margin: 40px auto 0 auto; display: block;">
    <i class="bi bi-arrow-left"></i> Back to User List
</a>
<div id="edit-user-form">
    <h2 class="form-title text-center mb-4">
        <i class="bi bi-person-lines-fill me-2"></i>Edit User
    </h2>
    <form action="{{ route('updateUser', ['id' => $user->id]) }}" method="POST" onsubmit="return confirmUpdate()">
        @csrf
        @method('POST')

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->username) }}" required>
            </div>
            @error('username')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">New Password <span class="text-muted">(Leave blank to keep current password)</span></label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm New Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Is Admin</label>
            <select class="form-select" name="is_admin" required>
                <option value="0" {{ old('is_admin', $user->is_admin) == '0' ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('is_admin', $user->is_admin) == '1' ? 'selected' : '' }}>Yes</option>
            </select>
            @error('is_admin')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Update
            </button>
        </div>
    </form>
</div>
<script>
    function confirmUpdate() {
        return confirm("Are you sure you want to update this user?");
    }
</script>
@endsection