function onClickBtnSeen(event) {
    event.preventDefault();

    const url = this.href;
    const seasonNumber = url.split("/")[7];
    const icon = this.querySelector("i.js-seen");
    const seasonIcon = document.querySelector("i.js-season-seens-" + seasonNumber);

    axios.get(url).then(function (response) {
        icon.textContent = response.data.seen;
        if (icon.classList.contains(response.data.oldClass)) {
            icon.classList.replace(response.data.oldClass, response.data.newClass);
        }
    }).then(function () {
        seasonIcon.textContent = ' Tout vu';
        seasonIcon.classList.replace('fa-times', 'fa-check');
        document.querySelectorAll("i.js-seen-" + seasonNumber).forEach(function (icon2) {
            if (icon2.classList.contains('fa-times')) {
                seasonIcon.textContent = ' Tout voir';
                seasonIcon.classList.replace('fa-check', 'fa-times');
            }
        })
    })
}

document.querySelectorAll("a.js-seens").forEach(function (link) {
    link.addEventListener('click', onClickBtnSeen);
});