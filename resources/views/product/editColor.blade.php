@extends('layout.adminDashboard')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Edit Color</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('colors.update', $color->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label for="name">Color Name:</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $color->name }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="hex_code">Hex Code:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="hex_code" name="hex_code"
                                        value="{{ $color->hex_code }}" required>
                                    <input type="color" class="form-control form-control-color" id="colorPicker"
                                        value="{{ $color->hex_code }}" title="Choose color">
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label>Color Preview:</label>
                                <div id="colorPreview"
                                    style="width: 10%; height: 50px; background-color: {{ $color->hex_code }}; border: 1px solid #ddd; border-radius: 8px;">
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('colors.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Color</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const hexInput = document.getElementById('hex_code');
        const colorPicker = document.getElementById('colorPicker');
        const colorPreview = document.getElementById('colorPreview');

        // Update when hex code is typed
        hexInput.addEventListener('input', function() {
            colorPreview.style.backgroundColor = this.value;
            colorPicker.value = this.value;
        });

        // Update when color is picked
        colorPicker.addEventListener('input', function() {
            hexInput.value = this.value;
            colorPreview.style.backgroundColor = this.value;
        });
    </script>
@endsection
