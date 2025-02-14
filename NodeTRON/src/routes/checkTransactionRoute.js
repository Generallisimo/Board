const { checkTransaction } = require('../services/checkTransaction');

async function checkTransactionRoute(fastify) {
    fastify.get('/check_transaction', async (request, reply) => {
        try {
            const { address, hours } = request.query;

            const parsedHours = parseInt(hours, 10);  // Преобразуем часы в число

            if (isNaN(parsedHours) || parsedHours <= 0) {
                return reply.status(400).send({ error: 'Invalid hours parameter' });
            }

            const result = await checkTransaction(address, parsedHours);

            reply.send({
                result: result
            });
        } catch (e) {
            reply.status(500).send({
                error: e.message
            });
        }
    });
}

module.exports = checkTransactionRoute;
