const loveButton = document.getElementById("love-button");

loveButton.addEventListener("click", function () {
    if(loveButton.classList.contains("active")) {
        loveButton.classList.remove("active");
        // bdd call
    } else {
        loveButton.classList.add("active");
        // bdd call
    }
})