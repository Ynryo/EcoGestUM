const profileModal = document.getElementById("profile-modal");
const profileButton = document.getElementById("profile-button");

profileButton.addEventListener("click", function () {
    if (profileModal.style.display === "none") {
        profileModal.style.display = "flex";
    } else {
        profileModal.style.display = "none";
    }
})