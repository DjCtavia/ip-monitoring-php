const API_IP_add = async (ip) => {
    try {
        const response = await fetch('/src/api/ip/add.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ip}),
        });

        if (!response.ok) {
            throw new Error('Error adding IP address');
        }

        return await response.json();
    } catch (error) {
        return {status: 'error', message: error.message}
    }
};

const API_monitoring_list = async () => {
    try {
        const response = await fetch('/src/api/monitoring/list.php', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('Error getting monitored IP list');
        }

        return await response.json();
    } catch (error) {
        return { status: 'error', message: error.message };
    }
};