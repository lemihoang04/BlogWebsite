
window.onload = function() {
    // Check if the search or category parameters exist in the URL
    const urlParams = new URLSearchParams(window.location.search);
    const search = urlParams.get('search');
    const category = urlParams.get('category');

    if (search || category) {
        // Scroll to the results section if search or category is present
        const resultsSection = document.getElementById('results');
        if (resultsSection) {
            resultsSection.scrollIntoView({ behavior: 'smooth' });
        }
    }
};


document.getElementById('categorySelect').addEventListener('change', function() {
    // Submit the form when a new category is selected
    document.getElementById('searchForm').submit();
    
});