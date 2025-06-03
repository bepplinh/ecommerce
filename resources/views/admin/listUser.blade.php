@extends('layout.adminDashboard')

@section('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    .user-table-container {
        max-width: 900px;
        margin: 40px auto;
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 8px 32px rgba(60,60,60,0.12);
        padding: 2.5rem 2rem 2rem 2rem;
    }
    .table th, .table td {
        vertical-align: middle !important;
    }
    .action-btn {
        border: none;
        background: none;
        color: #4f8cff;
        font-size: 1.2rem;
        margin: 0 5px;
        cursor: pointer;
        transition: color 0.2s;
    }
    .action-btn:hover {
        color: #e74c3c;
    }
</style>
@endsection

@section('content')
<div class="user-table-container">
    <h2 class="mb-4 text-center"><i class="bi bi-people me-2"></i>User List</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Role</th>
                <th>Created At</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->username }}</td>
                    <td>
                        @if($user->is_admin)
                            <span class="badge bg-success">Admin</span>
                        @else
                            <span class="badge bg-secondary">User</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-center">
                        <a href="{{ route('showEditUser', ['id' => $user->id]) }}" class="action-btn" title="Edit">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('deleteUser', ['id' => $user->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection