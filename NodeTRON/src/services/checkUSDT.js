const TronWeb = require('tronweb');
const BigNumber = require('bignumber.js');

async function checkBalance(ownerAddress){
    try{
        const tronWeb = new TronWeb({
            fullHost: 'https://api.shasta.trongrid.io',
            // privateKey: '6285daf813fe3497148a2420cf9f30adcae49f4a38ec03db89b0a37d4b5d223e',
        });
        const contractAddress = 'TG3XXyExBkPp9nzdajDZsozEu4BkaSJozs';
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