@extends('layout.adminDashboard')

@section('head')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    #edit-category-form {
        font-family: 'Roboto', sans-serif;
        max-width: 500px;
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
@endsection

@section('content')
<a href="{{ route('categorys.index') }}" class="btn-back mb-3" style="max-width: 500px; margin: 40px auto 0 auto; display: block;">
    <i class="bi bi-arrow-left"></i> Back to Category List
</a>
<div id="edit-category-form">
    <h2 class="form-title text-center mb-4">
        <i class="bi bi-pencil-square me-2"></i>Edit Category
    </h2>
    <form action="{{ route('categorys.update', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to update this category?');">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-tag"></i></span>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $category->name) }}" required>
            </div>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="parent_id" class="form-label">Parent Category</label>
            <select class="form-select" id="parent_id" name="parent_id">
                <option value="">-- None --</option>
                @foreach($parentCategories as $id => $name)
                    <option value="{{ $id }}" {{ old('parent_id', $category->parent_id) == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
            @error('parent_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i> Update Category
            </button>
        </div>
    </form>
</div>
@endsection