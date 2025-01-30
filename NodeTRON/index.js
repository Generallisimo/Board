const Fastify = require('fastify');
const sendRouteTRX = require('./src/routes/sendRouteTrx');
const sendRouteUSDT = require('./src/routes/sendRouteUsdt');
const checkRouteUSDT = require('./src/routes/checkRouteUsdt');
const createWallet = require('./src/routes/createRouteWallet');
const checkTransaction = require('./src/routes/checkTransactionRoute');
const checkRouteTXID = require('./src/routes/checkRouteTXID');
const checkTRXRoute = require('./src/routes/checkRouteTRX');

const fastify = Fastify({ logger: true });

fastify.register(sendRouteTRX);
fastify.register(sendRouteUSDT);
fastify.register(checkRouteUSDT);
fastify.register(createWallet);
fastify.register(checkTransaction);
fastify.register(checkRouteTXID);
fastify.register(checkTRXRoute);



fastify.listen({ host: '0.0.0.0', port: 3000 }, (err, address) => {
    if (err) {
        fastify.log.error(err);
        process.exit(1);
    }
    fastify.log.info(`Server listening at ${address}`);
});


fastify.ready(err => {
    if (err) throw err;
    console.log(fastify.printRoutes());
});