// ============================================================
// MAIN PUBLIC JS
// ============================================================

document.addEventListener('DOMContentLoaded', function () {

    // --------------------------------------------------------
    // 1. LIKE BUTTON (AJAX)
    // --------------------------------------------------------
    const likeButtons = document.querySelectorAll('.like-btn');

    likeButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            const contentType = this.getAttribute('data-type');
            const contentId   = this.getAttribute('data-id');
            const countEl     = this.querySelector('.like-count');

            fetch(window.SITE_URL + '/?page=like', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'content_type=' + contentType + '&content_id=' + contentId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.action === 'liked') {
                        btn.classList.add('liked');
                        btn.querySelector('i').className = 'bi bi-heart-fill';
                    } else {
                        btn.classList.remove('liked');
                        btn.querySelector('i').className = 'bi bi-heart';
                    }
                    if (countEl) countEl.textContent = data.count;
                }
            })
            .catch(err => console.error('Like error:', err));
        });
    });

    // --------------------------------------------------------
    // 2. IMAGE GALLERY (Detail Pages)
    // --------------------------------------------------------
    const galleryThumbs = document.querySelectorAll('.gallery-thumb');
    const mainImage     = document.getElementById('mainGalleryImage');

    galleryThumbs.forEach(function (thumb) {
        thumb.addEventListener('click', function () {
            if (mainImage) {
                mainImage.src = this.getAttribute('data-src');
            }
            galleryThumbs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // --------------------------------------------------------
    // 3. NAVBAR SCROLL EFFECT
    // --------------------------------------------------------
    window.addEventListener('scroll', function () {
        const navbar = document.getElementById('mainNavbar');
        if (navbar) {
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        }
    });

    // --------------------------------------------------------
    // 4. SMOOTH SCROLL FOR ANCHOR LINKS
    // --------------------------------------------------------
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // --------------------------------------------------------
    // 5. FILTER BUTTONS (Projects, Properties, Interiors)
    // --------------------------------------------------------
    const filterBtns    = document.querySelectorAll('.filter-btn');
    const filterItems   = document.querySelectorAll('.filter-item');

    filterBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            const filter = this.getAttribute('data-filter');

            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            filterItems.forEach(function (item) {
                if (filter === 'all' || item.getAttribute('data-category') === filter) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

});

// Make SITE_URL available to JS
// This is set in the footer via a script tag