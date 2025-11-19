const loveButton = document.getElementById("love-button");

loveButton.addEventListener("click", function () {
    if (loveButton.classList.contains("active")) {
        loveButton.classList.remove("active");
        deleteObject();
    } else {
        loveButton.classList.add("active");
        insertObject();
    }
})

window.addEventListener("load", function isInLoveList() {
    const urlParams = new URLSearchParams(window.location.search);
    const pageId = urlParams.get('p');

    let getState = new XMLHttpRequest();

    getState.onreadystatechange = function () {
        if (getState.readyState == 4 && getState.status == 200) {
            // console.log(this.responseText);
            if (JSON.parse(this.responseText) == 0) {
                loveButton.classList.remove("active");
            } else if (JSON.parse(this.responseText) == 1) {
                loveButton.classList.add("active");
            }
        }
    }

    getState.open("GET", "/assets/src/love_objet.php?request=load&p=" + encodeURIComponent(pageId), true);
    getState.send();
})

function insertObject() {
    const urlParams = new URLSearchParams(window.location.search);
    const pageId = urlParams.get('p');
    let insertState = new XMLHttpRequest();

    insertState.open("POST", "/assets/src/love_objet.php?request=add&p=" + encodeURIComponent(pageId), true);
    insertState.send();
}

function deleteObject() {
    const urlParams = new URLSearchParams(window.location.search);
    const pageId = urlParams.get('p');
    let deleteState = new XMLHttpRequest();

    deleteState.open("POST", "/assets/src/love_objet.php?request=remove&p=" + encodeURIComponent(pageId), true);
    deleteState.send();
}