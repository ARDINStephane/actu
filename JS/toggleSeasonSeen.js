function onClickBtnSeasonSeen(event) {
    event.preventDefault();

    const url = this.href;
    const seasonNumber = url.split("/")[6];
    const icon = this.querySelector("i.js-season-seens");

    axios.get(url).then(function (response) {

        icon.textContent = response.data.seasonSeen;
        if (icon.classList.contains(response.data.oldClass)) {
            icon.classList.replace(response.data.oldClass, response.data.newClass);
        }
        document.querySelectorAll("i.js-seen-" + seasonNumber).forEach(function (icon2) {
            icon2.textContent = response.data.episodeSeen;
            if (icon2.classList.contains(response.data.oldEpisodeClass)) {
                icon2.classList.replace(response.data.oldEpisodeClass, response.data.newEpisodeClass);
            }
        });
    }).catch(function (error) {
        if (error.response.status === 403) {
            window.location.reload();
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    })
}

document.querySelectorAll("a.js-seasons-seens").forEach(function (link) {
    link.addEventListener('click', onClickBtnSeasonSeen);
});