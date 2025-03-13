const TronWeb = require('tronweb');

async function sendTrx(addressTo, amount, ownerAddress, privateKey){
    try{
        const tronWeb = new TronWeb({
            // fullHost: 'https://api.shasta.trongrid.io',
            fullHost: 'https://api.trongrid.io',
            privateKey: privateKey
        });
        const trxBalance = await tronWeb.trx.getBalance(ownerAddress);
        if (trxBalance < amount) { 
            throw new Error('Insufficient TRX balance for transaction fee.');
        }

        const transaction = await tronWeb.transactionBuilder.sendTrx(addressTo, tronWeb.toSun(amount), ownerAddress);
        const signed = await tronWeb.trx.sign(transaction);
        const broadcast = await tronWeb.trx.sendRawTransaction(signed);
        console.log(transaction, signed, broadcast);
        return broadcast;
    }catch(error){
        console.error(`Error during transaction with trx: ${error}`);
        throw new Error(`Transaction err: ${error.message}`);
    };
}

module.exports={sendTrx};