function onClickBtnSeen(event) {
    event.preventDefault();

    const url = this.href;
    const icon = this.querySelector("i.js-seen");

    axios.get(url).then(function (response) {
        console.log(response.data.seen);
        icon.textContent = response.data.seen;
        if (icon.classList.contains(response.data.oldClass)) {
            icon.classList.replace(response.data.oldClass, response.data.newClass);
        }
    }).catch(function (error) {
        if (error.response.status === 403) {
            window.location.reload();
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    })
}

document.querySelectorAll("a.js-seens").forEach(function (link) {
    link.addEventListener('click', onClickBtnSeen);
});