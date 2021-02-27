## Aplicaci&oacute;n Prueba Practica Haulmer

Aplicación Backend en PHP laravel Framework con control de session JWT.Se puede ver las historias asociadas en [Trello](https://trello.com/b/ve2ZLzpJ).

- [Link video](https://youtu.be/cEmXgybYIcA).

Librerias utilizadas:
- [PHP-JWT](https://github.com/firebase/php-jwt).
- [Request](https://laravel.com/docs/8.x/requests).
- [Http Client](https://laravel.com/docs/8.x/http-client).
- [MOCKAPI](https://www.mockapi.io)

## Ejemplos de Uso / Documentaci&oacute;n

Para iniciar sesion:
- METODO GET || http://127.0.0.1:8000/api/login/{CORREO_ELECTRONICO}/{CONTRASENA} -> POSTMAN COLLECTION (LOGIN)
- EJEMPLO: [http://127.0.0.1:8000/api/login/first1.last1@mail.com/1.1.1]()
Para refrescar su sesion
- METODO GET || http://127.0.0.1:8000/api/refresh/ -> POSTMAN COLLECTION (refresh_JWT)
- EJEMPLO: [http://127.0.0.1:8000/api/refresh/]()
Para cerrar sesion:
- METODO GET || http://127.0.0.1:8000/api/logout/ -> POSTMAN COLLECTION (Logout)
Para agregar un nuevo usuario:
- METODO POST || http://127.0.0.1:8000/api/new -> POSTMAN COLLECTION (Route new)
  +->body (x-www-form-urlencoded): nombre:String , correo_electronico:String, contrasena:String

Para actualizar datos del usuario autenticado y autorizado:
- METODO PUT || http://127.0.0.1:8000/api/me -> POSTMAN COLLECTION (update me unique)
  +->body (x-www-form-urlencoded): nombre:String , correo_electronico:String, contrasena:String
Para borrar datos del usuario autenticado y autorizado:
- METODO DELETE || http://127.0.0.1:8000/api/me -> POSTMAN COLLECTION (delete me unique)

## MOCK API

Se puede probar la API de usuario con la [ruta](https://60380d194e3a9b0017e92ba9.mockapi.io/haulmer_mock/usuarios).

## Pruebas PostMan (export type 2.1)

En la carpeta [/export_postman/Haulmer_api.postman_collection.json](https://github.com/JuanManuelCabezasContardo/haulmer_api/tree/main/export_postman) Existe una colecci&oacute;n de pruebas sobre las distintas rutas de acceso 

