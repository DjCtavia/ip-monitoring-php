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
        const result = await API_IP_add(ipAddress);
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




function createMonitoringCard(ip, ipType, pingStatus) {
    const template = document.getElementById('ip_monitoring_card_template');
    const clone = document.importNode(template.content, true);

    clone.getElementById('ipAddress').textContent = ip;
    clone.getElementById('ipType').textContent = ipType;
    clone.getElementById('pingStatus').textContent = pingStatus;

    const cardContainer = document.getElementById('monitored_ip_list');
    const card = document.createElement('div');
    card.className = `card-monitoring ${pingStatus === 'Online' ? 'ping-reached' : 'ping-error'}`;
    card.appendChild(clone);

    cardContainer.appendChild(card);
}

async function doMonitoringList() {
    const monitoringList = await API_monitoring_list();

    if (monitoringList.status !== 'success') return;

    monitoringList.data.forEach(entry => {
        const { ip_address, ip_type, ping_status } = entry;
        createMonitoringCard(ip_address, ip_type, ping_status ? 'Online' : 'Offline');
    });
}

doMonitoringList();
setInterval(async () => {
    doMonitoringList();
}, 5000)