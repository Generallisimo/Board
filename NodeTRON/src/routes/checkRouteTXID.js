const { checkTXID } = require('../services/checkTXID');

async function checkRouteTXID(fastify) {
    fastify.post('/check_txid', async (request, reply) => {
        try {
            const { transactionHash } = request.body;

            if (!transactionHash) {
                return reply.status(400).send({ error: 'Transaction hash is required' });
            }

            const isSuccess = await checkTXID(transactionHash);
            console.log(isSuccess)
            reply.send({ success: isSuccess });
        } catch (e) {
            reply.status(500).send({
                error: e.message
            });
        }
    });
}

module.exports = checkRouteTXID;
