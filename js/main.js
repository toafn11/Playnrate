document.addEventListener('DOMContentLoaded', () => {

    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm) {
        reviewForm.addEventListener('submit', e => {
            let valid = true;
            const score = document.getElementById('score');
            if (score) {
                const s = parseInt(score.value);
                if (isNaN(s) || s < 1 || s > 10) {
                    alert('Score must be between 1 and 10.'); // Tạm dùng alert hoặc hàm showFieldError của bạn
                    valid = false;
                }
            }

            const review = document.getElementById('review_text');
            if (review && review.value.trim().length < 5) {
                alert('Review text must be at least 5 characters.');
                valid = false;
            }

            if (!valid) e.preventDefault();
        });
    }

    // --- PHẦN RENDER SAO ---
    const scoreInput = document.getElementById('score');
    const starPicker = document.getElementById('starPicker');

    if (scoreInput && starPicker) {
        renderStarPicker(parseInt(scoreInput.value) || 0);

        starPicker.addEventListener('mouseover', e => {
            const star = e.target.closest('[data-val]');
            if (star) highlightStars(parseInt(star.dataset.val));
        });

        starPicker.addEventListener('mouseout', () => {
            highlightStars(parseInt(scoreInput.value) || 0);
        });

        starPicker.addEventListener('click', e => {
            const star = e.target.closest('[data-val]');
            if (star) {
                const val = parseInt(star.dataset.val);
                scoreInput.value = val;
                highlightStars(val);
            }
        });
    }

    function renderStarPicker(active) {
        if (!starPicker) return;
        starPicker.innerHTML = '';
        for (let i = 1; i <= 10; i++) {
            const s = document.createElement('span');
            s.dataset.val = i;
            s.textContent = i <= active ? '★' : '☆';
            // Dùng màu vàng sáng cho sao
            s.style.cssText = `cursor:pointer;font-size:1.8rem;color:${i <= active ? '#FFD700' : '#ccc'};transition:color .15s;`;
            starPicker.appendChild(s);
        }
    }

    function highlightStars(val) {
        if (!starPicker) return;
        starPicker.querySelectorAll('[data-val]').forEach(s => {
            const v = parseInt(s.dataset.val);
            s.textContent = v <= val ? '★' : '☆';
            s.style.color = v <= val ? '#FFD700' : '#ccc';
        });
    }


    // Form game edit
    const gameForm = document.getElementById('gameForm');
    if (gameForm) {
        gameForm.addEventListener('submit', e => {
            let valid = true;

            // Title
            const title = document.getElementById('title');
            if (title && title.value.trim().length < 2) {
                showFieldError('title', 'Title must be at least 2 characters.');
                valid = false;
            } else { clearFieldError('title'); }

            // Genre
            const genre = document.getElementById('genre_id');
            if (genre && !genre.value) {
                showFieldError('genre_id', 'Please select a genre.');
                valid = false;
            } else { clearFieldError('genre_id'); }

            // Year
            const year = document.getElementById('release_year');
            if (year) {
                const y = parseInt(year.value);
                if (isNaN(y) || y < 1970 || y > new Date().getFullYear() + 2) {
                    showFieldError('release_year', 'Enter a valid release year (1970 – present).');
                    valid = false;
                } else { clearFieldError('release_year'); }
            }

            // Description
            const desc = document.getElementById('description');
            if (desc && desc.value.trim().length < 10) {
                showFieldError('description', 'Description must be at least 10 characters.');
                valid = false;
            } else { clearFieldError('description'); }

            if (!valid) e.preventDefault();
        });
    }
    // File upload
    const fileInput   = document.getElementById('cover_image');
    const previewWrap = document.getElementById('imagePreview');

    if (fileInput && previewWrap) {
        fileInput.addEventListener('change', () => {
            const file = fileInput.files[0];
            if (!file) return;

            if (!file.type.startsWith('image/')) {
                showFieldError('cover_image', 'Please select a valid image file.');
                fileInput.value = '';
                return;
            }
            if (file.size > 2 * 1024 * 1024) {
                showFieldError('cover_image', 'Image must be smaller than 2 MB.');
                fileInput.value = '';
                return;
            }

            clearFieldError('cover_image');
            const reader = new FileReader();
            reader.onload = e => {
                previewWrap.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            };
            reader.readAsDataURL(file);
        });
    }
});
