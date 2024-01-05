const addNewIPButton = document.getElementById("addNewIPButtonDialog");
const newIPDialog = document.getElementById("addNewIPDialog");
const confirmBtn = newIPDialog.querySelector("#confirmBtn");
const inputAddIP = newIPDialog.querySelector("#addressIP");

addNewIPButton.addEventListener("click", () => {
    newIPDialog.showModal();
    inputAddIP.focus();
});

confirmBtn.addEventListener("click", (event) => {
    event.preventDefault();
    newIPDialog.close();
});
