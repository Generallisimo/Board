const TronWeb = require('tronweb');
const BigNumber = require('bignumber.js');

async function checkBalance(ownerAddress){
    try{
        const tronWeb = new TronWeb({
            // fullHost: 'https://api.shasta.trongrid.io',
            fullHost: 'https://api.trongrid.io',
        });
        const contractAddress = 'TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t';
        const contract = await tronWeb.contract().at(contractAddress);
    
        tronWeb.setAddress(ownerAddress);
    
        const usdtBalanceRaw = await contract.balanceOf(ownerAddress).call();
        const usdtBalance = new BigNumber(usdtBalanceRaw._hex).dividedBy(1e6);
        
        console.log('Parsed USDT balance:', usdtBalance.toString());
        // reply.send({ balance: usdtBalance.toString() });
        return { balance: usdtBalance.toString() };
    }catch(error){
        console.error('Error checking USDT balance:', error);
        throw new Error('Failed to check USDT balance');
    }
}

module.exports = {checkBalance}