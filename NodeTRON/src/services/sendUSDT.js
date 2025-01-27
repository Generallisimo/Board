// const tronWeb = require('../config/tronConfig')
const TronWeb = require('tronweb');
const BigNumber = require('bignumber.js');

async function sendUSDT(addressTo, amount, ownerAddress, privateKey) {
    try {
        const tronWeb = new TronWeb({
            fullHost: 'https://api.shasta.trongrid.io',
            privateKey: privateKey,
        });

        const contractAddress = 'TG3XXyExBkPp9nzdajDZsozEu4BkaSJozs';
        const contract = await tronWeb.contract().at(contractAddress);
        
        const amountInSun = new BigNumber(amount).toFixed(0);
        console.log(`Sending ${amountInSun} USDT (in Sun) to ${addressTo} from ${ownerAddress}`);

        const usdtBalance = await contract.balanceOf(ownerAddress).call();
        if (new BigNumber(usdtBalance).isLessThan(amountInSun)) {
            throw new Error('Insufficient USDT balance.');
        }

        const result = await contract.transfer(addressTo, amountInSun).send({
            from: ownerAddress,
            feeLimit: 100000000
        });

        console.log('Transaction result:', result);
        return result;

    } catch (error) {
        // Подробное логирование ошибки
        console.error('Error during transaction:', {
            message: error.message,
            stack: error.stack,
            response: error.response ? error.response.data : null
        });
        throw new Error(`Transaction err: ${error.message}`);
    }
}


module.exports={sendUSDT};