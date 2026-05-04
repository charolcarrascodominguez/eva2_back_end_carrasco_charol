# Evaluacion Sumativa N°„1 - Desarrollo Backend

**Alumno:** Osnalvys Mijares  
**Alumno:** Charol Carrasco  
**Proyecto:** Sprint 0 - APi Fintech Solutions S.A.

---

## Descripcion del Proyecto

Este proyecto corresponde al Sprint 0 del desarrollo backend para la startup **Fintech Solutions S.A.**

El objetivo es implementar una base tecnica funcional utilizando Laravel, Docker y MySQL, asegurando una arquitectura clara, mantenible y escalable.

Se desarrolla una APi RESTful basica que permite validar el correcto funcionamiento del backend, incluyendo conexion a base de datos y comunicacion HTTP.

---

## Arquitectura del Sistema (MVC)

El sistema esta basado en el patron **MVC (Modelo - Vista - Controlador)**:

* **Modelo:** gestiona la interaccion con la base de datos  
* **Vista:** no aplica directamente (APi REST)  
* **Controlador:** maneja la logica del backend  

---

### Diagrama de Arquitectura

[ CLiENTE (Navegador / Postman) ]
°˝
[ NGiNX (Puerto 8081) ]
°˝
[ PHP-FPM (Laravel) ]
°˝
[ Rutas °˙ Controlador °˙ Middleware ]
°˝
[ Modelo ]
°˝
[ Base de Datos (MySQL) ]]


---

## Flujo de una Peticion HTTP

1. El cliente (Postman o navegador) envia una solicitud HTTP  
2. NGiNX recibe la peticion en el puerto 8081  
3. NGiNX redirige la solicitud a PHP-FPM  
4. Laravel procesa la solicitud mediante las rutas (`api.php`)  
5. La ruta invoca el controlador correspondiente  
6. El controlador ejecuta la logica de negocio  
7. El modelo interactua con la base de datos  
8. Se genera una respuesta en formato JSON  
9. La respuesta es enviada al cliente  

---

## Rol del Backend

El backend cumple un rol fundamental:

* Recibe solicitudes HTTP del cliente  
* Procesa reglas de negocio  
* Valida datos  
* interactua con la base de datos  
* Construye respuestas en formato JSON  

Actua como intermediario entre cliente, servidor y base de datos.

---

## Tecnologias Utilizadas

* PHP 8.2  
* Laravel 10+  
* MySQL 8  
* NGiNX  
* Docker  
* Postman  
* Git / GitHub  

---

## Criterios de Calidad del Sprint 0

| Criterio        | Decision Tecnica   | Justificacion                   |
|-----------------|------------------|--------------------------------|
| Modularidad     | Uso de MVC       | Separacion de responsabilidades |
| Mantenibilidad  | Estructura Laravel | Codigo escalable              |
| Claridad        | Archivo `.env`   | Configuracion centralizada      |
| Responsabilidad | Controladores    | Logica separada                 |
| Trazabilidad    | Logs de Laravel  | Seguimiento de errores          |
| Portabilidad    | Docker           | Entorno replicable              |

---

## Estructura del Proyecto

app/
routes/
database/
docker-compose.yml
README.md

---

#---

## Base de Datos

Base de datos utilizada: **MySQL**

```sql
CREATE DATABASE iF NOT EXiSTS fintech;

CREATE TABLE clients (
    client_id iNT UNSiGNED AUTO_iNCREMENT PRiMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNiQUE,
    phone_number VARCHAR(20),
    date_of_birth DATE,
    created_at TiMESTAMP DEFAULT CURRENT_TiMESTAMP,
    updated_at TiMESTAMP DEFAULT CURRENT_TiMESTAMP
);

---

## Endpoint de Salud

**Ruta:**

GET /api/health

**Respuesta esperada:**

JSON
{
  "status": "online",
  "version": "1.0.0",
  "environment": "docker"
}

Codigo de respuesta: 200 OK

---

## Migraciones y Seeders

Se implementaron migraciones para la creacion de tablas y seeders para datos de prueba.

Comandos utilizados:

```
php artisan migrate
php artisan db:seed
```

Se verifica:

* Conexion correcta a la base de datos
* Ejecucion exitosa de migraciones
* insercion de datos mediante seeders

---

## Entorno Docker

El proyecto utiliza Docker con los siguientes servicios:

* NGiNX (servidor web)
* PHP-FPM (ejecucion de Laravel)
* MySQL (base de datos)

### Ventajas

* Portabilidad del entorno
* Facil despliegue
* Evita conflictos de versiones

---

## Control de Versiones

Repositorio gestionado con Git y alojado en GitHub.

Nombre del repositorio: https://github.com/charolcarrascodominguez/eva1_carrasco_charol y https://github.com/nazareth0420/eva1_mijares_osnalvys

```
eva1_mijares_osnalvys
```

---

## üë®‚Äçüè?Entrega

* Repositorio privado en GitHub
* Docente agregado como colaborador:

```
psilva-docente
```

---

## üë®‚Äçüí?Autor

**Osnalvys Mijares**

---

## ‚ú?Conclusi√≥n

Se implement√≥ correctamente una APi backend funcional utilizando Laravel, aplicando buenas pr√°cticas de arquitectura MVC, persistencia de datos y entorno dockerizado, cumpliendo con los requisitos del Sprint 0.

El proyecto demuestra la capacidad de construir una base t√©cnica s√≥lida para futuras funcionalidades del sistema.

