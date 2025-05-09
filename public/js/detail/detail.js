// Lắng nghe sự kiện khi người dùng chọn màu
document.querySelectorAll('.color-radio').forEach(radio => {
    radio.addEventListener('change', function () {
        const colorId = this.value;  // Lấy ID màu sắc đã chọn

        // Gửi yêu cầu AJAX đến server
        fetch(`/get-sizes/${colorId}`)
            .then(response => response.json())
            .then(data => {
                const sizeOptions = document.getElementById('size-options');
                sizeOptions.innerHTML = ''; // Xóa các kích thước cũ

                // Cập nhật các kích thước vào giao diện
                if (data.sizes.length > 0) {
                    data.sizes.forEach(size => {
                        const sizeWrapper = document.createElement('div');
                        sizeWrapper.classList.add('size-option-wrapper');
                        
                        const input = document.createElement('input');
                        input.type = 'radio';
                        input.name = 'size';
                        input.id = `size${size.name}`;
                        input.value = size.name;
                        input.classList.add('size-radio');
                        
                        const label = document.createElement('label');
                        label.setAttribute('for', `size${size.name}`);
                        label.classList.add('size-box');
                        label.textContent = size.name;

                        sizeWrapper.appendChild(input);
                        sizeWrapper.appendChild(label);
                        sizeOptions.appendChild(sizeWrapper);
                    });
                }
            })
            .catch(error => console.error('Error fetching sizes:', error));
    });
});
