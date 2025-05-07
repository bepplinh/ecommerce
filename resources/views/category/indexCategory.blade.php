@extends('layout.adminDashboard')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Add New Category</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('categorys.store') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="name">Category Name:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="parent_id">Parent Category:</label>
                                <select class="form-control" id="parent_id" name="parent_id">
                                    <option value="">No Parent (Root Category)</option>
                                    <?php $categories_noParent = $categories->where('parent_id', null); ?>
                                    @foreach($categories_noParent as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Add Category</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Available categorys</h5>
                        <form action="{{ route('categorys.index') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search category..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-sm btn-primary">Search</button>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            Category Name
                                            <a href="{{ route('categorys.index', ['sort' => 'asc']) }}" class="text-dark">
                                                <i class="fas fa-sort-alpha-down ms-1"></i>
                                            </a>
                                            <a href="{{ route('categorys.index', ['sort' => 'desc']) }}" class="text-dark">
                                                <i class="fas fa-sort-alpha-up ms-1"></i>
                                            </a>
                                        </th>
                                        <th class="text-center">Parent Category</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td class="text-center align-middle">{{ $category->name }}</td>
                                            <td class="text-center align-middle">
                                                @if($category->parent_id)
                                                    {{ $parentCategories[$category->parent_id] }}
                                                @else
                                                    <span class="badge bg-secondary">Empty</span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <div class="d-flex justify-content-center align-items-center" style="gap: 2px;">
                                                    <a href="{{ route('categorys.edit', $category->id) }}" class="btn btn-warning p-1 d-flex justify-content-center align-items-center" style="font-size: 0.8rem; width: 30px; height: 30px;">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('categorys.destroy', $category->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger p-1 d-flex justify-content-center align-items-center" style="font-size: 0.8rem; width: 30px; height: 30px;"
                                                            onclick="return confirm('Are you sure you want to delete this category?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                </table>
                                <div class="d-flex justify-content-end mt-3">
                                    {{ $categories->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection