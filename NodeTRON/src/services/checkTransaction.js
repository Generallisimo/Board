const axios = require('axios');

async function checkTransaction(address, hours) {
    const url = `https://api.shasta.trongrid.io/v1/accounts/${address}/transactions/trc20`;

    try {
        
        const response = await axios.get(url);
        
        if (!response.data || !response.data.data) {
            throw new Error('Invalid response data');
        }
        
        const transactions = response.data.data;
        const currentTime = Date.now();
        
        const filteredTransactions = transactions.filter(tx => {
            const txTime = tx.block_timestamp;
            const timeDifference = currentTime - txTime;
            const hoursInMs = hours * 3600000;
            const isWithinTimeRange = timeDifference <= hoursInMs;
            
            return isWithinTimeRange;
        });

        return filteredTransactions;
    } catch (error) {
        console.error('Error fetching transactions:', error.message);
        throw error;
    }
}

module.exports = { checkTransaction };
