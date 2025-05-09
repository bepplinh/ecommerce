@extends('layout.adminDashboard')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="{{ route('product.images.store', $productVariant->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="main_image" id="mainImageInput">

                <div class="product-info mb-4 p-3 border-left border-primary bg-light rounded">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <span class="text-muted">Sản phẩm:</span>
                                <h5 class="product-name mb-0">{{$productVariant->product->name}}</h5>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <span class="text-muted mr-2">Màu sắc:</span>
                                <div class="d-flex align-items-center">
                                    <span class="color-badge mr-2"
                                        style="background-color: {{ $productVariant->color->hex_code }};"></span>
                                    <span class="font-weight-medium">{{ $productVariant->color->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="upload-zone mb-4">
                    <label for="images" class="form-label fw-bold mb-2">
                        <i class="fas fa-images mr-2"></i>Chọn ảnh cho màu {{ $productVariant->color->name }}
                    </label>

                    <div class="custom-file-upload">
                        <input type="file" class="file-input" name="images[]" id="images" multiple accept="image/*"
                            required>
                        <div class="upload-area">
                            <div class="upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <div class="upload-text">
                                Kéo thả ảnh vào đây hoặc nhấn để chọn ảnh
                            </div>
                            <div class="selected-files-info mt-2">
                                Chưa có file nào được chọn
                            </div>
                        </div>
                    </div>

                    <div class="form-text text-muted mb-3">
                        <i class="fas fa-info-circle mr-1"></i>
                        Có thể chọn nhiều ảnh. Định dạng hỗ trợ: JPG, PNG, GIF
                    </div>

                    <!-- Image preview area -->
                    <div class="image-preview-container mt-3">
                        <h6 class="preview-title d-none mb-3">
                            <i class="fas fa-eye mr-1"></i>Xem trước ảnh
                        </h6>
                        <div class="image-preview-grid" id="imagePreviewGrid"></div>
                    </div>
                </div>

                <!-- Nút submit -->
                <div class="d-flex justify-content-between">
                    <a href="javascript:history.back()" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-2"></i>Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save mr-2"></i>Thêm ảnh
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 8px;
        overflow: hidden;
    }

    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .product-name {
        color: #333;
        font-weight: 600;
    }

    .font-weight-medium {
        font-weight: 500;
    }

    .color-badge {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: inline-block;
        border: 1px solid #e9e9e9;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .custom-file-upload {
        position: relative;
        margin-bottom: 15px;
    }

    .file-input {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 10;
    }

    .upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 6px;
        padding: 30px 20px;
        text-align: center;
        background-color: #f8f9fa;
        transition: all 0.3s;
    }

    .file-input:hover+.upload-area,
    .file-input:focus+.upload-area {
        border-color: #007bff;
        background-color: #f0f7ff;
    }

    .upload-icon {
        font-size: 36px;
        color: #6c757d;
        margin-bottom: 10px;
    }

    .upload-text {
        font-size: 16px;
        color: #495057;
        margin-bottom: 5px;
    }

    .selected-files-info {
        font-size: 14px;
        color: #6c757d;
    }

    .btn {
        border-radius: 4px;
        padding: 8px 16px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0069d9;
        border-color: #0062cc;
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
    }

    /* Image preview styles */
    .image-preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
    }

    .preview-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        aspect-ratio: 1;
    }

    .preview-item .main-image-selector {
        position: absolute;
        bottom: 5px;
        left: 5px;
        background: rgba(255, 255, 255, 0.8);
        padding: 3px 8px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        opacity: 0.8;
        transition: opacity 0.2s;
        z-index: 2;
    }

    .preview-item:hover .main-image-selector {
        opacity: 1;
    }

    .preview-item .main-image-selector input[type="radio"] {
        margin: 0;
    }

    .preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }

    .preview-item:hover img {
        transform: scale(1.05);
    }

    .preview-item .remove-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 50%;
        width: 25px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #dc3545;
        cursor: pointer;
        opacity: 0;
        transition: opacity 0.2s;
    }

    .preview-item:hover .remove-btn {
        opacity: 1;
    }

    .preview-item .file-name {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        padding: 5px;
        font-size: 12px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        opacity: 0;
        transition: opacity 0.2s;
    }

    .preview-item:hover .file-name {
        opacity: 1;
    }

    .preview-title {
        color: #495057;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 8px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('images');
    const fileInfo = document.querySelector('.selected-files-info');
    const uploadArea = document.querySelector('.upload-area');
    const previewGrid = document.getElementById('imagePreviewGrid');
    const previewTitle = document.querySelector('.preview-title');
    
    // Mảng để lưu trữ các file đã chọn
    let selectedFiles = [];
    
    fileInput.addEventListener('change', function() {
        handleFiles(fileInput.files);
    });
    
    function handleFiles(files) {
        if (files.length > 0) {
            // Cập nhật thông tin số lượng file
            fileInfo.textContent = files.length + ' file được chọn';
            uploadArea.style.borderColor = '#28a745';
            uploadArea.style.backgroundColor = '#f0fff4';
            document.querySelector('.upload-icon').style.color = '#28a745';
            
            // Hiển thị tiêu đề preview
            previewTitle.classList.remove('d-none');
            
            // Thêm file mới vào mảng quản lý
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                
                // Chỉ xử lý file hình ảnh
                if (file.type.startsWith('image/')) {
                    selectedFiles.push(file);
                    
                    // Tạo preview item
                    createPreviewItem(file);
                }
            }
        } else {
            resetUploadArea();
        }
    }
    
    function createPreviewItem(file) {
        // Tạo container cho item preview
        const previewItem = document.createElement('div');
        previewItem.className = 'preview-item';
        previewItem.dataset.fileName = file.name;
        
        // Tạo ảnh preview
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.onload = function() {
            URL.revokeObjectURL(this.src);
        };
        
        // Tạo selector ảnh chính
        const mainImageSelector = document.createElement('label');
        mainImageSelector.className = 'main-image-selector';
        
        const radio = document.createElement('input');
        radio.type = 'radio';
        radio.name = 'main_image';
        radio.value = file.name;
        // Chọn ảnh đầu tiên làm ảnh chính mặc định
        if (selectedFiles.length === 0) {
            radio.checked = true;
        }
        
        const selectorText = document.createElement('span');
        selectorText.textContent = 'Ảnh chính';
        
        mainImageSelector.appendChild(radio);
        mainImageSelector.appendChild(selectorText);
        
        // Tạo nút xóa
        const removeBtn = document.createElement('div');
        removeBtn.className = 'remove-btn';
        removeBtn.innerHTML = '<i class="fas fa-times"></i>';
        removeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const isMainImage = radio.checked;
            removeFile(file.name);
            previewItem.remove();
            
            // Nếu xóa ảnh chính, tự động chọn ảnh đầu tiên còn lại làm ảnh chính
            if (isMainImage && selectedFiles.length > 0) {
                const firstRadio = document.querySelector('input[name="main_image"]');
                if (firstRadio) {
                    firstRadio.checked = true;
                }
            }
            
            // Cập nhật thông tin số lượng file
            if (selectedFiles.length === 0) {
                resetUploadArea();
            } else {
                fileInfo.textContent = selectedFiles.length + ' file được chọn';
            }
        });
        
        // Tạo tên file
        const fileName = document.createElement('div');
        fileName.className = 'file-name';
        fileName.textContent = file.name;
        
        // Thêm các phần tử vào item preview
        previewItem.appendChild(img);
        previewItem.appendChild(mainImageSelector);
        previewItem.appendChild(removeBtn);
        previewItem.appendChild(fileName);
        
        // Thêm item vào grid
        previewGrid.appendChild(previewItem);
    }
    
    function removeFile(fileName) {
        // Tìm và xóa file khỏi mảng
        selectedFiles = selectedFiles.filter(file => file.name !== fileName);
        
        // Cập nhật lại input file (không thể trực tiếp, cần tạo mới DataTransfer)
        updateFileInput();
    }
    
    function updateFileInput() {
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => {
            dataTransfer.items.add(file);
        });
        fileInput.files = dataTransfer.files;
    }
    
    function resetUploadArea() {
        fileInfo.textContent = 'Chưa có file nào được chọn';
        uploadArea.style.borderColor = '#dee2e6';
        uploadArea.style.backgroundColor = '#f8f9fa';
        document.querySelector('.upload-icon').style.color = '#6c757d';
        previewTitle.classList.add('d-none');
        previewGrid.innerHTML = '';
        selectedFiles = [];
    }
    
    // Drag and drop support
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight() {
        uploadArea.style.borderColor = '#007bff';
        uploadArea.style.backgroundColor = '#f0f7ff';
    }
    
    function unhighlight() {
        if (selectedFiles.length === 0) {
            uploadArea.style.borderColor = '#dee2e6';
            uploadArea.style.backgroundColor = '#f8f9fa';
        } else {
            uploadArea.style.borderColor = '#28a745';
            uploadArea.style.backgroundColor = '#f0fff4';
        }
    }
    
    uploadArea.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        handleFiles(files);
    }
});
document.querySelector('form').addEventListener('submit', function(e) {
    const selectedMainImage = document.querySelector('input[name="main_image"]:checked');
    if (selectedMainImage) {
        document.getElementById('mainImageInput').value = selectedMainImage.value;
    }
});
</script>
@endsection