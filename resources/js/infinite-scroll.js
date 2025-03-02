document.addEventListener('DOMContentLoaded', function() {
    let nextPage = null;
    let loading = false;
    const postsContainer = document.getElementById('posts-container');
    const loadingIndicator = document.getElementById('loading-indicator');

    function loadMorePosts() {
        if (loading || !nextPage) return;

        loading = true;
        if (loadingIndicator) loadingIndicator.classList.remove('hidden');

        fetch(nextPage, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                postsContainer.insertAdjacentHTML('beforeend', data.html);
                nextPage = data.nextPage;
                if (!nextPage) {
                    window.removeEventListener('scroll', handleScroll);
                }
            })
            .catch(error => console.error('Error loading posts:', error))
            .finally(() => {
                loading = false;
                if (loadingIndicator) loadingIndicator.classList.add('hidden');
            });
    }

    function handleScroll() {
        const scrollPosition = window.innerHeight + window.scrollY;
        const scrollThreshold = document.documentElement.scrollHeight - 800;

        if (scrollPosition >= scrollThreshold) {
            loadMorePosts();
        }
    }

    // Initialize nextPage value from the first page load
    if (postsContainer) {
        nextPage = postsContainer.dataset.nextPage;
        // Add scroll event listener only if we have more pages
        if (nextPage) {
            window.addEventListener('scroll', handleScroll);
        }
    }
}); // Removed extra parenthesis