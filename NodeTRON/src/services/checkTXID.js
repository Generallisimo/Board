const axios = require('axios');

async function checkTXID(transactionHash, totalTimeout = 300000, delay = 10000) {
    const url = 'https://api.shasta.trongrid.io/walletsolidity/gettransactionbyid';

    const startTime = Date.now();
    
    while (Date.now() - startTime < totalTimeout) {
        try {
            const response = await axios.post(url, { value: transactionHash });
            // console.log('Response data:', response.data);

            // Проверка данных ответа
            if (response.data && response.data.ret && response.data.ret[0]) {
                const status = response.data.ret[0].contractRet;
                console.log('Transaction status:', status);

                if (status === 'SUCCESS') {
                    console.log('Transaction successful');
                    return true;  // Успешная транзакция
                } else if (status === 'REVERT') {
                    console.log('Transaction reverted');
                    return false;  // Транзакция была отменена
                }
            }

            // Если статус не получен, ожидаем перед следующей попыткой
            console.log('Status not available, retrying...');
            await new Promise(resolve => setTimeout(resolve, delay));

        } catch (error) {
            // Обработка ошибок запроса
            console.error('Error fetching transaction status:', error.message);
            // Если ошибка в запросе, можно попробовать снова
            await new Promise(resolve => setTimeout(resolve, delay));
        }
    }

    // Если не удалось получить статус после 5 минут ожидания
    console.log('Transaction status could not be determined within the timeout period');
    return false;
}

module.exports = { checkTXID };
