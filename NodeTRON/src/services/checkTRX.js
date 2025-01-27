const TronWeb = require('tronweb');

async function checkTrxBalance(ownerAddress) {
    try {
        const tronWeb = new TronWeb({
            fullHost: 'https://api.shasta.trongrid.io',
            // privateKey: 'ваш_приватный_ключ', // если нужно подписывать транзакции
        });

        // Получаем баланс TRX на адресе
        const trxBalance = await tronWeb.trx.getBalance(ownerAddress);

        // Баланс возвращается в SUN (1 TRX = 1e6 SUN)
        const trxBalanceInTrx = tronWeb.fromSun(trxBalance);

        console.log('TRX balance:', trxBalanceInTrx);
        return { balance: trxBalanceInTrx };
    } catch (error) {
        console.error('Error checking TRX balance:', error);
        throw new Error('Failed to check TRX balance');
    }
}

module.exports = { checkTrxBalance };
