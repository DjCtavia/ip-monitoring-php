const ipCardMap = {}; // Map to store IP addresses and their corresponding cards

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



function formatTimestamp(timestamp) {
    const currentDate = new Date();
    const pastDate = new Date(timestamp);

    const timeDifference = currentDate - pastDate;
    const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));

    let result = `Since ${days} days`;

    if (hours > 0) {
        result += ` ${hours}h`;
    }

    if (minutes > 0) {
        result += ` ${minutes}min`;
    }

    return result;
}

function createMonitoringCard(description, ip, pingStatus, timestamp) {
    const template = document.getElementById('ip_monitoring_card_template');
    const clone = document.importNode(template.content, true);

    clone.getElementById('description').textContent = description ?? ip;
    clone.getElementById('ipAddress').textContent = ip;
    clone.getElementById('pingStatus').textContent = pingStatus;
    if (timestamp) {
        clone.getElementById('timestamp').textContent = formatTimestamp(timestamp);
    }

    const card = document.createElement('div');
    card.className = `card-monitoring ${pingStatus === 'Online' ? 'ping-reached' : 'ping-error'}`;
    card.appendChild(clone);

    return card;
}

function updateMonitoringCard(card, pingStatus, timestamp) {
    card.className = `card-monitoring ${pingStatus === 'Online' ? 'ping-reached' : 'ping-error'}`;
    card.querySelector('#pingStatus').textContent = pingStatus;
    if (timestamp) {
        card.querySelector('#timestamp').textContent = formatTimestamp(timestamp);
    }
}

const DELAY_BETWEEN_EACH_MONITORING_UPDATE = 5000;

async function doMonitoringList() {
    try {
        const monitoringList = await API_monitoring_list();

        if (monitoringList.status !== 'success') {
            throw new Error('Error fetching monitored IP list');
        }

        monitoringList.data.forEach(entry => {
            const {ip_address, ip_type, ping_status, description, timestamp} = entry;

            if (ipCardMap[ip_address]) {
                updateMonitoringCard(ipCardMap[ip_address], ping_status ? 'Online' : 'Offline', timestamp);
            } else {
                const card = createMonitoringCard(description, ip_address, ping_status ? 'Online' : 'Offline', timestamp);
                ipCardMap[ip_address] = card;
                document.getElementById('monitored_ip_list').appendChild(card);
            }
        });
    } catch (error) {} finally {
        // setTimeout(doMonitoringList, DELAY_BETWEEN_EACH_MONITORING_UPDATE);
    }
}

doMonitoringList();