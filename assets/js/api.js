const API_addIpAddress = async (ip) => {
    try {
        const response = await fetch('/api/ip/add.php', {
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