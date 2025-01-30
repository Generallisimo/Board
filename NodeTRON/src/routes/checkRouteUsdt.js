const {checkBalance} = require('../services/checkUSDT');

async function checkBalanceRoute(fastify, option){
    fastify.get('/check_balance', async(request, reply)=>{
        try{
            const {ownerAddress} = request.query;
            if (!ownerAddress) {
                return reply.status(400).send({ error: 'ownerAddress is required' });
            }
            const response = await checkBalance(ownerAddress);
            reply.send(response);
        }catch(error){
            console.error('Error in /check_balance route:', error);
            reply.status(500).send({error: error.message});
        }
    })
}

module.exports = checkBalanceRoute;