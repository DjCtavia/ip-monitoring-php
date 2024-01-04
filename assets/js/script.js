const addNewIPButton = document.getElementById("addNewIPButtonDialog");
const newIPDialog = document.getElementById("addNewIPDialog");
const confirmBtn = newIPDialog.querySelector("#confirmBtn");

addNewIPButton.addEventListener("click", () => {
    newIPDialog.showModal();
});

confirmBtn.addEventListener("click", (event) => {
    event.preventDefault();
    newIPDialog.close();
});
