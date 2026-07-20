// ============================================================
// ADMIN PANEL JAVASCRIPT
// ============================================================

document.addEventListener('DOMContentLoaded', function () {

    // --------------------------------------------------------
    // 1. SIDEBAR TOGGLE
    // --------------------------------------------------------
    const sidebar        = document.getElementById('adminSidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const toggleBtn      = document.getElementById('sidebarToggleBtn');
    const closeBtn       = document.getElementById('sidebarCloseBtn');

    function openSidebar() {
        sidebar.classList.add('open');
        sidebarOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        sidebarOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
    if (closeBtn)  closeBtn.addEventListener('click', closeSidebar);
    if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);

    // --------------------------------------------------------
    // 2. DARK / LIGHT MODE TOGGLE
    // --------------------------------------------------------
    const html        = document.documentElement;
    const savedTheme  = localStorage.getItem('theme') || 'dark';
    html.setAttribute('data-theme', savedTheme);

    // --------------------------------------------------------
    // 3. IMAGE UPLOAD PREVIEW
    // --------------------------------------------------------
    const imageInput   = document.getElementById('imageInput');
    const previewGrid  = document.getElementById('imagePreviewGrid');
    const uploadArea   = document.getElementById('uploadArea');

    if (uploadArea && imageInput) {
        // Click upload area to trigger file input
        uploadArea.addEventListener('click', function () {
            imageInput.click();
        });

        // Drag and drop
        uploadArea.addEventListener('dragover', function (e) {
            e.preventDefault();
            uploadArea.style.borderColor = 'var(--accent-gold)';
        });

        uploadArea.addEventListener('dragleave', function () {
            uploadArea.style.borderColor = '';
        });

        uploadArea.addEventListener('drop', function (e) {
            e.preventDefault();
            uploadArea.style.borderColor = '';
            const files = e.dataTransfer.files;
            handleImagePreview(files);
        });

        // File input change
        imageInput.addEventListener('change', function () {
            handleImagePreview(this.files);
        });
    }

    function handleImagePreview(files) {
        if (!previewGrid) return;
        previewGrid.innerHTML = '';

        Array.from(files).forEach(function (file, index) {
            if (!file.type.startsWith('image/')) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                const item = document.createElement('div');
                item.className = 'admin-image-preview-item';
                item.innerHTML = `
                    <img src="${e.target.result}" alt="Preview ${index + 1}">
                    <button type="button" class="remove-img-btn" onclick="this.parentElement.remove()">
                        <i class="bi bi-x"></i>
                    </button>
                `;
                previewGrid.appendChild(item);
            };
            reader.readAsDataURL(file);
        });
    }

    // --------------------------------------------------------
    // 4. DELETE CONFIRMATION
    // --------------------------------------------------------
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const confirmed = confirm('Are you sure you want to delete this? This action cannot be undone.');
            if (confirmed) {
                form.submit();
            }
        });
    });

    // --------------------------------------------------------
    // 5. FLASH MESSAGE AUTO DISMISS
    // --------------------------------------------------------
    const flashMessages = document.querySelectorAll('.flash-message');
    flashMessages.forEach(function (msg) {
        setTimeout(function () {
            msg.style.opacity = '0';
            msg.style.transition = 'opacity 0.5s ease';
            setTimeout(function () {
                msg.remove();
            }, 500);
        }, 4000);
    });

    // --------------------------------------------------------
    // 6. PROGRESS BAR INPUT LIVE PREVIEW
    // --------------------------------------------------------
    const progressInput  = document.getElementById('progressInput');
    const progressPreview = document.getElementById('progressPreview');
    const progressValue  = document.getElementById('progressValue');

    if (progressInput && progressPreview) {
        progressInput.addEventListener('input', function () {
            progressPreview.style.width = this.value + '%';
            if (progressValue) progressValue.textContent = this.value + '%';
        });
    }

    // --------------------------------------------------------
    // 7. COVER IMAGE SELECTOR
    // --------------------------------------------------------
    const coverRadios = document.querySelectorAll('.cover-radio');
    coverRadios.forEach(function (radio) {
        radio.addEventListener('change', function () {
            document.querySelectorAll('.admin-image-preview-item').forEach(function (item) {
                item.classList.remove('is-cover');
            });
            this.closest('.admin-image-preview-item').classList.add('is-cover');
        });
    });

    // --------------------------------------------------------
    // 8. TABLE SEARCH FILTER
    // --------------------------------------------------------
    const tableSearch = document.getElementById('tableSearch');
    const tableRows   = document.querySelectorAll('.admin-table tbody tr');

    if (tableSearch) {
        tableSearch.addEventListener('input', function () {
            const query = this.value.toLowerCase();
            tableRows.forEach(function (row) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    }

    // --------------------------------------------------------
    // 9. SELECT ALL CHECKBOX
    // --------------------------------------------------------
    const selectAll = document.getElementById('selectAll');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');

    if (selectAll) {
        selectAll.addEventListener('change', function () {
            rowCheckboxes.forEach(function (cb) {
                cb.checked = selectAll.checked;
            });
        });
    }

    // --------------------------------------------------------
    // 10. TOOLTIP INIT (Bootstrap)
    // --------------------------------------------------------
    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltips.forEach(function (el) {
        new bootstrap.Tooltip(el);
    });

});