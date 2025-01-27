const TronWeb = require('tronweb');

async function createRoute (fastify, option){
    fastify.post('/create',async function(request, reply){
        try{
            const tronWeb = new TronWeb({
                fullHost: 'https://api.shasta.trongrid.io',
                privateKey: '6285daf813fe3497148a2420cf9f30adcae49f4a38ec03db89b0a37d4b5d223e',
            });

            const newWallet = await tronWeb.createAccount();
            const privateKey = newWallet.privateKey;
            const address = tronWeb.address.fromPrivateKey(privateKey);

            console.log(privateKey, address)
            reply.send({
                privateKey: privateKey,
                address: address
            });
        }catch(e){
            reply.status(500).send({ error: 'Failed to create wallet' });
        }
    })
}

module.exports=createRoute;