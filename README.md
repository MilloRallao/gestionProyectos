<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# API Gestión de proyectos

En esta API se pueden gestionar proyectos, los cuales pueden tener actividades y estos a su vez pueden tener incidencias. Un usuario puede asignarse a uno o varios proyectos como "Responsable" o como "Participante" o ambos a la vez, a una o varias actividades sólo con 1 de ellos (Responsable o Participante únicamente) y a una o varias incidencias.

## Install Project

### Requisitos
- PHP >= 7.3
- Laravel utiliza Composer para gestionar sus dependencias. Así que, antes de usar Laravel, asegúrate de que tienes [Composer](https://getcomposer.org/) instalado en tu ordenador.

### Instrucciones
- Clona el proyecto en tu ordenador.
- Vete al directorio raíz del proyecto y ejecuta el siguiente comando:

```
$ composer install
```
- Configura tu archivo .env, más información sobre esto [aqui](https://laravel.com/docs/8.x/configuration#environment-configuration).
- Ejecuta los siguientes comandos:
```
$ php artisan key:generate
```
- Ejecuta los migrations y seeders de el proyecto (Configura antes los valores de la base de datos en tu archivo .env).
```
$ php artisan migrate --seed
```
- Finalmente necesitas ejecutar este comando
```
$ php artisan optimize:clear
```

- Y el proyecto está listo para usar.

### Servidor local

Si tienes instalado PHP localmente y deseas utilizar el servidor de desarrollo incorporado de PHP para correr la aplicación, puedes utilizar el comando artisan serve. Este comando iniciará un servidor de desarrollo en http://localhost:8000:
```commands
php artisan serve
```
## API Resources

#### Crear un proyecto
**- URL:**
```url
POST: http://localhost:8000/api/projects
```
**- Parámetros:**
- name: (String, required) Nombre del proyecto.

#### Listar participantes de un proyecto
**- URL:**
```url
GET: http://localhost:8000/api/project-participantes/{projectId}
```

#### Crear una actividad
**- URL:**
```url
POST: http://localhost:8000/api/activities
```
**- Parámetros:**
- name: (String, required) Nombre de la actividad.
- project_id: (Integer, required) Id del proyecto al que se asignará la actividad.

#### Listar participantes de una actividad
**- URL:**
```url
GET: activity-participantes/{activity}
```

#### Crear una incidencia

**- URL:**
```url
POST: http://localhost:8000/api/incidents
```
**- Parámetros:**
- name: (String, required) Nombre de la incidencia.
- activity_id: (Integer, required) Id de la actividad a la que se asignará la incidencia.

#### Listar todas las incidencias de una actividad

- Sólo pueden ver las incidencias de una actividad únicamente aquellos usuarios que sean "Responsables" de dicha actividad.

**- URL:**
```url
POST: http://localhost:8000/api/activity-incidents
```
**- Parámetros:**
- activity_id: (Integer, required) Id de la actividad.
- user_id: (Integer, required) Id del usuario.

#### Asignar proyecto a un usuario

- Los permisos para un proyecto pueden ser 2: "project responsable" y "project participante".

**- URL:**
```url
POST: http://localhost:8000/api/assign-project
```
**- Parámetros:**
- permissions[]: (Array[String], Required) Nombre de los permisos que tendrá el usuario para ese proyecto.
- user_id: (Integer, Required) Id del usuario a asignar.
- project_id: (Integer, required) Id del proyecto donde asignar al usuario.

#### Desasignar proyecto a un usuario
**- URL:**
```url
POST: http://localhost:8000/api/unassign-project
```
**- Parámetros:**
- user_id: (Integer, Required) Id del usuario a desasignar.
- project_id: (Integer, required) Id del proyecto donde desasignar al usuario.

#### Asignar actividad a un usuario

- Los permisos para una actividad pueden ser 2: "activity responsable" y "activity participante". Únicamente puede ser asignado 1 de ambos permisos.

**- URL:**
```url
POST: http://localhost:8000/api/assign-activity
```
**- Parámetros:**
- permissions: (String, Required) Nombre del permiso que tendrá el usuario para esa actividad.
- user_id: (Integer, Required) Id del usuario a asignar.
- activity_id: (Integer, required) Id de la actividad donde asignar al usuario.

#### Desasignar actividad a un usuario
**- URL:**
```url
POST: http://localhost:8000/api/unassign-activity
```
**- Parámetros:**
- user_id: (Integer, Required) Id del usuario a desasignar.
- activity_id: (Integer, required) Id de la actividad donde desasignar al usuario.

#### Asignar incidente a un usuario
**- URL:**
```url
POST: http://localhost:8000/api/assign-incident
```
**- Parámetros:**
- user_id: (Integer, Required) Id del usuario a asignar.
- incident_id: (Integer, required) Id del incidente donde asignar al usuario.

#### Desasignar incidente a un usuario
**- URL:**
```url
POST: http://www.yacoanix.com/api/v1/customers/{CUSTOMER_ID}/delete-photo
```
**- Parámetros:**
- user_id: (Integer, Required) Id del usuario a desasignar.
- incident_id: (Integer, required) Id del incidente donde desasignar al usuario.
