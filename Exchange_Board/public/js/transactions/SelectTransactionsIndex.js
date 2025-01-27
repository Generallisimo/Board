document.addEventListener('DOMContentLoaded', function(){
    const await = document.getElementById('await');
    const success = document.getElementById('success');
    const archive = document.getElementById('archive');
    const dispute = document.getElementById('dispute');
    const error = document.getElementById('error');
    const fraud = document.getElementById('fraud');
    const to_success_but = document.getElementById('to_success_but');
    const await_but = document.getElementById('await_but');
    const archive_but = document.getElementById('archive_but');
    const success_but = document.getElementById('success_but');
    const dispute_but = document.getElementById('dispute_but');
    const error_but = document.getElementById('error_but');
    const fraud_but = document.getElementById('fraud_but');
    const to_success = document.getElementById('to_success');

    await_but.addEventListener('click', function(){
        await.style.display = 'table';
        archive.style.display = 'none';
        success.style.display = 'none';
        dispute.style.display = 'none';
        error.style.display = 'none';
        fraud.style.display = 'none';
        to_success.style.display = 'none';
    })
    archive_but.addEventListener('click', function(){
        await.style.display = 'none';
        archive.style.display = 'table';
        success.style.display = 'none';
        dispute.style.display = 'none';
        error.style.display = 'none';
        fraud.style.display = 'none';
        to_success.style.display = 'none';
    })
    success_but.addEventListener('click', function(){
        archive.style.display = 'none';
        success.style.display = 'table';
        await.style.display = 'none';
        dispute.style.display = 'none';
        error.style.display = 'none';
        fraud.style.display = 'none';
        to_success.style.display = 'none';
    })
    dispute_but.addEventListener('click', function(){
        archive.style.display = 'none';
        success.style.display = 'none';
        await.style.display = 'none';
        dispute.style.display = 'table';
        error.style.display = 'none';
        fraud.style.display = 'none';
        to_success.style.display = 'none';
    })
    error_but.addEventListener('click', function(){
        archive.style.display = 'none';
        success.style.display = 'none';
        await.style.display = 'none';
        dispute.style.display = 'none';
        error.style.display = 'table';
        fraud.style.display = 'none';
        to_success.style.display = 'none';
    })
    fraud_but.addEventListener('click', function(){
        archive.style.display = 'none';
        success.style.display = 'none';
        await.style.display = 'none';
        dispute.style.display = 'none';
        error.style.display = 'none';
        fraud.style.display = 'table';
        to_success.style.display = 'none';
    })
    to_success_but.addEventListener('click', function(){
        archive.style.display = 'none';
        success.style.display = 'none';
        await.style.display = 'none';
        dispute.style.display = 'none';
        error.style.display = 'none';
        fraud.style.display = 'none';
        to_success.style.display = 'table';
    })


})