document.addEventListener('DOMContentLoaded', function(){
    const status = document.querySelector('.status-text');
    function checkStatus(exchange){
        const url = window.apiUrl;
        console.log('hi')
        fetch(`${url}/api/payment/update/${exchange}`)
            .then(response=>response.json())
            .then(data => {
                if(data.status === 'success'){
                    status.innerText = 'Платеж успешно обработан';
                    clearInterval(requestFetch);
                }else if(data.status === 'to_success'){
                    status.innerText = 'Платеж успешно обработан';
                }else if(data.status === 'archive'){
                    status.innerText = 'Ошибка, обратитесь в тех поддержку';
                    clearInterval(requestFetch);
                }else if(data.status === 'await'){
                    status.innerText = 'Платеж обрабатывается';
                }else if(data.status === 'error'){
                    status.innerText = 'Платеж успешно обработан';
                    clearInterval(requestFetch);
                }else if(data.status === 'dispute'){
                    status.innerText = 'Платеж обрабатывается';
                }else if(data.status === 'fraud'){
                    status.innerText = 'Обратитесь в поддержку, произошла ошибка при переводе';
                    clearInterval(requestFetch);
                }
            })
            .catch(error => console.error('Error:', error));
    }
    
    const exchangeIdUser = document.querySelector('input[name="exchange_id"]').value;
    let requestFetch = setInterval(() => checkStatus(exchangeIdUser), 3000);
})