@extends('layout.adminDashboard')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Add New Color</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('colors.index') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name">Color:</label>
                                <input type="text" class="form-control w-50" id="name" name="name" required>
                            </div>

                            <div class="form-group">
                                <label for="hex_code">HexCode of Color:</label>
                                <input type="text" class="form-control w-50" id="hex_code" name="hex_code" required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Add Color</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Available Colors</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            Color
                                            <a href="{{ route('colors.index', ['sort' => 'asc']) }}" class="text-dark">
                                                <i class="fas fa-sort-alpha-down ms-1"></i>
                                            </a>
                                            <a href="{{ route('colors.index', ['sort' => 'desc']) }}" class="text-dark">
                                                <i class="fas fa-sort-alpha-up ms-1"></i>
                                            </a>
                                        </th>
                                        <th class="text-center">Color Preview</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($colors as $color)
                                        <tr>
                                            <td class="text-center align-middle">{{ $color->name }}</td>
                                            <td class="text-center align-middle">
                                                <div style="width: 30px; height: 30px; background-color: {{ $color->hex_code }}; margin: auto; border: 1px solid #ddd; border-radius: 6px;"></div>
                                            </td>
                                            <td class="align-middle">
                                                <div class="d-flex justify-content-center align-items-center" style="gap: 2px;">
                                                    <a href="{{ route('colors.edit', $color->id) }}" class="btn btn-warning p-1 d-flex justify-content-center align-items-center" style="font-size: 0.8rem; width: 30px; height: 30px;">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('colors.destroy', $color->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger p-1 d-flex justify-content-center align-items-center" style="font-size: 0.8rem; width: 30px; height: 30px;"
                                                            onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>  
                    </div>
                </div>
            </div>
        </div>

       <!-- Edit Color Modal -->
<div class="modal fade" id="editColor{{ $color->id }}" tabindex="-1" aria-labelledby="editColorLabel{{ $color->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editColorLabel{{ $color->id }}">Edit Color</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('colors.update', $color->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="colorName" class="form-label">Color Name</label>
                        <input type="text" class="form-control" id="colorName" name="name" value="{{ $color->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="colorHex" class="form-label">Hex Code</label>
                        <input type="text" class="form-control" id="colorHex" name="hex_code" value="{{ $color->hex_code }}" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    </div>

    <script>
        document.getElementById('code').addEventListener('input', function() {
            document.getElementById('codeText').value = this.value;
        });
    </script>
@endsection
