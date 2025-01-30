const {sendUSDT} = require('../services/sendUSDT');

async function sendRoute(fastify, option){
    fastify.post('/sendTronUSDT', async(request, reply)=>{
        try{
            const {addressTo, amount, ownerAddress, privateKey} = request.body;
            console.log(addressTo, amount, ownerAddress, privateKey)
            const result = await sendUSDT(addressTo, amount, ownerAddress, privateKey);
            console.log({transactionHash: result})
            reply.send({transactionHash: result});
        }catch(error){
            reply.status(500).send({error: error.message});
        };
    })
}

module.exports = sendRoute;