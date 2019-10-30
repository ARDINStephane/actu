function toggleFavorite(event) {
    event.preventDefault();

    const url = this.href;
    const span = this.querySelector("span.js-toggle-favorite");
    const currentUrl = window.location.href;

    axios.get(url).then(function (response) {
        span.textContent = response.data.label;

        if (span.classList.contains(response.data.oldClass)) {
            span.classList.replace(response.data.oldClass, response.data.newClass);
        }

        if (currentUrl === 'http://localhost:8000/serie/favorites') {
            refresh();
        }
        console.log(currentUrl);
    }).catch(function (error) {
        if (error.response.status === 403) {
            refresh();
        }
    })
}

function refresh() {
    window.location.reload();
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}


document.querySelectorAll("a.js-toggle-favorites").forEach(function (link) {
    link.addEventListener('click', toggleFavorite);
});

