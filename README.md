# Evaluacion Tecnica Haulmer

## Instrucciones de uso

1. Clonar el repositorio: Abre una terminal o línea de comandos y ejecuta el siguiente comando para clonar el repositorio en tu máquina local.

```
git clone git@github.com:Brunalga/prueba-haulmer.git
```

2. Instalar dependencias: Una vez que el repositorio ha sido clonado, ingresa al directorio del proyecto y ejecuta el siguiente comando para instalar las dependencias del proyecto con Composer.

```
cd prueba-haulmer
composer install
```

3. Ejecutar el servidor: Inicia el servidor de desarrollo de Laravel para probar la aplicación en tu navegador

```
php artisan serve
```

## Ejecucion de pruebas

1. Asegúrate de tener el archivo JSON `Pruebas_Haulmer.postman_collection.json` con la colección de pruebas descargado en tu computadora (incluido en el repo).

2. Instala Postman: Si aún no tienes Postman instalado en tu computadora, descárgalo e instálalo desde el sitio web oficial de Postman (https://www.postman.com/downloads/).

3. Importar la colección de pruebas: Abre Postman y haz clic en el botón "Import" en la esquina superior izquierda de la interfaz. Selecciona la opción "File" y luego navega hasta el archivo JSON de la colección de pruebas que descargaste previamente. Postman importará automáticamente la colección y mostrará todas las solicitudes de la misma en el panel izquierdo.

4. Importar la colección de pruebas: Abre Postman y haz clic en el botón "Import" en la esquina superior izquierda de la interfaz. Selecciona la opción "File" y luego navega hasta el archivo JSON de la colección de pruebas que descargaste previamente. Postman importará automáticamente la colección y mostrará todas las solicitudes de la misma en el panel izquierdo.


## Mejoras

### Utilizar Modelos de Laravel para Eventos y Compras (NO REALIZADO) :

En lugar de usar arrays para representar eventos y compras, considera crear modelos para ellos.

### Validación de datos:

Para el método crearCompra, es esencial validar los datos de entrada de la solicitud para asegurarse de que estén en el formato esperado y contengan toda la información necesaria. Puedes utilizar las funciones de validación de Laravel para lograr esto.

### Manejo de errores con Try-Catch:

Cuando trabajas con arrays o interacciones con la base de datos, es importante manejar los errores de manera adecuada. Envuelve los accesos a arrays o las operaciones con la base de datos en bloques try-catch para capturar cualquier excepción que pueda ocurrir.

### Formato de Respuesta de Error:

Estandariza el formato de respuesta de error para la API. En lugar de devolver respuestas genéricas con códigos de estado, puedes crear un formato de respuesta de error más estructurado con un mensaje de error estándar.

### Utilizar la Validación de Solicitudes:

Para crearCompra, puedes usar la validación de Laravel en FormRequest para manejar las reglas de validación de la solicitud de manera más efectiva.

### Utilizar Constantes:

Para valores como America/Santiago, considera definirlos como constantes para evitar valores codificados en el código.

### Manejo adecuado de Excepciones:

En el método infoEventoEspecificoCompleta, estás devolviendo una respuesta 404 si no se encuentra el evento. En lugar de usar el operador de fusión nula (??) para manejar el caso en que no se encuentra el evento, es mejor lanzar una excepción y manejarla utilizando el mecanismo de manejo de excepciones de Laravel.

### Manejo de Errores para listarComprasCliente:

Actualmente, si no se encuentran compras para un cliente, la API devuelve un array vacío. Considera devolver una respuesta de error adecuada con un código de estado HTTP apropiado en su lugar.

## Supuestos y estructura

### Descripción general del controlador de eventos

El controlador de eventos es responsable de manejar todas las solicitudes relacionadas con eventos en la aplicación. Proporciona varios endpoints para obtener información relevante sobre eventos, detalles específicos de un evento, crear compras y listar compras de un cliente.

### Estructura de datos

El controlador utiliza una estructura de datos en forma de matriz para simular una base de datos. La matriz llamada $eventos contiene información sobre diferentes eventos, mientras que la matriz $compras almacena detalles de las compras realizadas.

### Endpoints disponibles

-   GET /eventos/relevantes: Devuelve información relevante de todos los eventos en formato JSON.
-   GET /eventos/completos: Devuelve información completa de todos los eventos en formato JSON.
-   GET /eventos/{id}: Devuelve información completa de un evento específico según su ID en formato JSON.
-   POST /comprar: Permite realizar una compra para un evento específico. Se deben proporcionar los siguientes datos en el cuerpo de la solicitud: id_evento (ID del evento), cliente (nombre del cliente) y cantidad_tickets (cantidad de tickets a comprar).

### Validación y manejo de errores

El controlador utiliza la función validate proporcionada por Laravel para validar los datos de entrada antes de procesar cualquier solicitud. Si los datos no son válidos, se devolverá una respuesta de error con el código HTTP 422 (Unprocessable Entity) y un mensaje explicativo de los errores de validación.

Para manejar excepciones durante la ejecución de la función crearCompra, se ha utilizado un bloque try-catch. Si ocurre alguna excepción, el controlador capturará el error y devolverá una respuesta de error adecuada con el código HTTP correspondiente y el mensaje de error apropiado.
