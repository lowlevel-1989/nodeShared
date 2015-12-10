var http = require('http');
http.createServer(function (req, res) {
  // Ejemplo de zona administrativa, NOTA: ES UN EJEMPLO.
  res.writeHead(200, {'Content-Type': 'text/html'});
  res.write('Zona Administrativa!\n');
  res.write('<a href="../manager/?daemon=admin&exec=stop&pass=12345Admin">Salir</a>');
  res.end();
}).listen(49998, '127.0.0.1');
