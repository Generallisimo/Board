const {checkTrxBalance} = require('../services/checkTRX')

async function checkTRXRoute(fastify) {
    fastify.get('/checkTRX', async(request, reply) => {
        try{

            const {ownerAddress} = request.query

            const result = await checkTrxBalance(ownerAddress)

            reply.send({
                result: result
            })
        }catch(e){
            reply.status(500).send({
                error: e.message
            })
        }
    })
}

module.exports = checkTRXRoute