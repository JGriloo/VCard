

const httpServer = require('http').createServer()
const io = require("socket.io")(httpServer, {
    allowEIO3: true,
    cors: {
        origin: "http://localhost:8081",
        methods: ["GET", "POST"],
        credentials: true
    }
})
httpServer.listen(8080, function () {
    console.log('listening on *:8080')
})
io.on('connection', function (socket) {
    console.log(`client ${socket.id} has connected`)
    

    socket.on('login',function(vcard){
        

        if (vcard.type==='V') {
            socket.join(`${vcard.id}`)
            console.log(`joined ${vcard.id}`)

        }
    })
    socket.on('logged_out_vcard',function(vcard){
            socket.leave(vcard.id)
            socket.leave('vcard')
    })
    socket.on('updateVcardTransaction',function(vcard_id,originvcard_id){

        io.to(`${vcard_id}`).emit('updateVcardTransaction',originvcard_id)
        io.to(`${originvcard_id}`).emit('updateVcardTransaction',vcard_id)
        console.log(`emitted ${vcard_id} ${originvcard_id}`)
    })
 

})
