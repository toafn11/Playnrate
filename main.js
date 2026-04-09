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

});