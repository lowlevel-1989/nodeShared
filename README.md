Node Shared
===========

## Que es nodeShared?

  Es un simulador de daemon nodejs de codigo abierto, que corre en un hosting compartido creado en PHP,
  con el fin de que sea posible usar javascript en el lado del servidor con apache. De esta manera,
  poderse realizar pruebas con esta nueva tecnologia.

## Como se configura el servidor?

  1. Se requiere subir node al servidor via SSH o FTP, el cual se puede descargar desde
  el siguiente enlace: [Node/dist][Node].
  Se recomienda siempre utilizar las ultimas versiones.

  2. Configurar index.php
    define("NODE_DIR", "/home/formatcom/node"); //Se especifica la ruta de nodejs en el servidor.
    define("NODE_APP", "/home/formatcom/index.js"); //Se indica la app para hacer deploy
    define("ADMIN_PASS", "12345Admin"); //Se configura una contrasena para las consultas con el servidor.

  3. Modificar .htaccess
    Colocar el puerto que se utilizara. Por defecto, viene con el puerto 49999.

  4. Subir el proyecto nodeShared a la carpeta publica del servidor. Ya con esto tenemos el servidor
  listo para utilizar con nodejs.

## Como se utiliza nodeShared?

  nodeShared esta completamente pensado para trabajar como un API y soporta tanto
  metodo GET como POST y responde siempre con un JSONP.

  * Encender el servidor
    http://tudominio.com/hackNode/?exec=start&pass=12345Admin
  * Apagar el servidor
    http://tudominio.com/hackNode/?exec=stop&pass=12345Admin

## Donde corre la app?

  * http://tudominio.com/node/

## Cual es el fin de nodeShared?

  La idea de nodeShared es simular un daemon para nodejs sin ser root,
  al igual que poder utilizar todos los puertos de un hosting compartido.

  Todos los log se encuentran en la carpeta node/supervisor/.

  Para que nodeShared puede simular un daemon, es necesario que tu cliente
  lo primero que haga sea atacar a http://tudominio.com/hackNode/?exec=start&pass=12345Admin
  mediante AJAX y esperar como respuesta el JSONP, el cual respondera si el servidor esta encendido.
  Si acaba de ser encendido, o si el proceso habia sido finalizado, dependiendo de la respuesta,
  el te generara un reporte en los archivos log, y automaticamente sabra si levantar el servidor
  o no. De esta manera, la aplicacion nunca se caera.
  Gracia a los logs, se podran ver todos los estados por los que ha pasado el servidor.

  [Node]: https://nodejs.org/dist/
  [start]: http://tudominio.com/hackNode/?exec=start&pass=12345Admin
  [stop]: http://tudominio.com/hackNode/?exec=stop&pass=12345Admin
  [app]: http://tudominio.com/node/
