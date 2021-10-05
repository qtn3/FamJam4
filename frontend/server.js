var http = require('http');
const hostname = '127.0.0.1';
const port = 3000;

var server = http.createServer((req, res) => {
 res.statusCode = 200;
 res.setHeader('Content-Type', 'text/plain');
 res.end('Hello World');
});

server.listen(port, hostname, () => {
    console.log('Node.js web server at port 5000 is running...');
});

