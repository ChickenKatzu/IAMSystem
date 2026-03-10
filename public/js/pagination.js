// resources/js/pagination.js
document.addEventListener('DOMContentLoaded', function() {
    // Tangkap semua link pagination
    document.querySelectorAll('.pagination a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const url = this.getAttribute('href');
            
            // Fetch data dengan AJAX
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                // Update konten tabel/list
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('.content-wrapper').innerHTML;
                
                document.querySelector('.content-wrapper').innerHTML = newContent;
                
                // Update URL tanpa reload
                history.pushState({}, '', url);
            })
            .catch(error => console.error('Error:', error));
        });
    });
});