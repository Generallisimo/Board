document.addEventListener('DOMContentLoaded', function(){
    const status = document.querySelector('.status-text');
    
    function checkStatus(wallet, hash_id) {
        const url = window.apiUrl;
        fetch(`${url}/api/top_up/${wallet}/${hash_id}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log(data)
                if (data.message.result) {
                    const transactionId = data.message.result[0]?.transaction_id;
                    if (transactionId) {
                        status.innerText = 'Платеж успешно обработан';
                    } else {
                        status.innerText = 'Транзакция не найдена';
                    }
                } else {
                    status.innerText = 'Ошибка, обратитесь в поддержку';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                status.innerText = 'Ошибка при обработке платежа';
            });
    }
    
    const wallet = document.querySelector('input[name="wallet"]').value;
    const hash_id = document.querySelector('input[name="hash_id"]').value;

    checkStatus(wallet, hash_id);

    setInterval(() => checkStatus(wallet, hash_id), 60000);
});
