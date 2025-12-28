document.addEventListener('DOMContentLoaded', function() {
    
    // === 1. EFEK VISUAL ASLI (HOVER CARD) ===
    const communityPosts = document.querySelectorAll('.community-posts');
    communityPosts.forEach(post => {
        post.addEventListener('mouseover', function() {
            this.classList.add('hovered');
        });
        post.addEventListener('mouseout', function() {
            this.classList.remove('hovered');
        });
    });

    // === 2. LOGIKA POSTING CERITA (LARAVEL) ===
    const postBtn = document.getElementById('post-btn');
    if (postBtn) {
        postBtn.addEventListener('click', function() {
            const title = document.getElementById('title-input').value;
            const content = document.getElementById('content-input').value;
            const topic = document.getElementById('topic-input').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            if (!title || !content || !topic) {
                alert("Mohon lengkapi data postingan.");
                return;
            }

            fetch('/community', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ title, content, topic })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    alert('Cerita berhasil diposting!');
                    window.location.reload();
                }
            })
            .catch(err => console.error(err));
        });
    }

    // === 3. LOGIKA LIKE (GABUNGAN VISUAL + BACKEND) ===
    // Menggunakan Event Delegation agar tombol baru tetap bisa diklik
    document.body.addEventListener('click', function(e) {
        if (e.target.classList.contains('like-btn')) {
            const button = e.target;
            const postId = button.getAttribute('data-id');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Efek Visual Langsung (Agar terasa cepat)
            button.classList.toggle('liked');
            if (button.classList.contains('liked')) {
                button.innerText = 'Liked';
            }

            // Kirim ke Backend
            fetch(`/community/${postId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    // Update teks dengan jumlah like terbaru dari server
                    button.innerText = `Like (${data.likes})`;
                    if(button.classList.contains('liked')) {
                         button.innerText = `Liked (${data.likes})`;
                    }
                }
            });
        }
    });

    // === 4. TOGGLE KOMENTAR ===
    document.body.addEventListener('click', function(e) {
        if (e.target.classList.contains('comment-toggle-btn')) {
            const btn = e.target;
            const postId = btn.getAttribute('data-id');
            const commentBox = document.getElementById(`comment-box-${postId}`);
            
            // Toggle class active (sesuai CSS tambahan)
            commentBox.classList.toggle('active');
        }
    });
});