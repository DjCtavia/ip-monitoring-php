const addNewIPButton = document.getElementById("addNewIPButtonDialog");
const newIPDialog = document.getElementById("addNewIPDialog");
const confirmBtn = newIPDialog.querySelector("#confirmBtn");
const inputAddIP = newIPDialog.querySelector("#addressIP");
const errorFieldText = newIPDialog.querySelector("#errorDiagIpAdd");

addNewIPButton.addEventListener("click", () => {
    newIPDialog.showModal();
    inputAddIP.focus();
});

confirmBtn.addEventListener("click", async (event) => {
    event.preventDefault();
    const ipAddress = inputAddIP.value;

    try {
        const result = await API_addIpAddress(ipAddress);
        if (result.status !== 'error') {
            errorFieldText.classList.remove('d-block')
            errorFieldText.innerText = '';
            inputAddIP.value = '';
            newIPDialog.close();
            return;
        }
        console.log(result);
        errorFieldText.innerText = result.message;
        errorFieldText.classList.add('d-block')
    } catch (error) {
        console.error(error);
        errorFieldText.innerText = error.message;
        errorFieldText.classList.add('d-block')
    }
});
