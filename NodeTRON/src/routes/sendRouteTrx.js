const {sendTrx} = require('../services/sendTRX');

async function sendRoute(fastify, option){
    fastify.post('/sendTronTRX', async(request, reply)=>{
        try{
            const {addressTo, amount, ownerAddress, privateKey} = request.body;
            console.log(addressTo, amount, ownerAddress, privateKey)
            const result = await sendTrx(addressTo, amount, ownerAddress, privateKey);
            reply.send(result);
        }catch(error){
            reply.status(500).send({error: error.message});
        };
    })
}

module.exports = sendRoute;