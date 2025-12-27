document.addEventListener('DOMContentLoaded', function() {
    const likeButtons = document.querySelectorAll('.community-buttons button:first-child');

    likeButtons.forEach(button => {
        if (button.textContent.trim() === 'Like') {
            button.addEventListener('click', function() {
                this.classList.toggle('liked');

                if (this.classList.contains('liked')) {
                    this.textContent = 'Liked'; 
                } else {
                    this.textContent = 'Like';
                }
            });
        }
    });

    const communityPosts = document.querySelectorAll('.community-posts');

    communityPosts.forEach(post => {
        post.addEventListener('mouseover', function() {
            this.classList.add('hovered');
        });

        post.addEventListener('mouseout', function() {
            this.classList.remove('hovered');
        });
    });
});