# music-taskApp
# 🎸 To-Do List para Guitarristas de Jazz

Una aplicación full stack para que guitarristas de jazz gestionen sus tareas diarias o semanales relacionadas con su práctica musical.

---

## 🧠 Descripción del Proyecto

Aplicación desarrollada con **Symfony (API)** y **Angular (frontend)** que permite a los usuarios (guitarristas) crear, visualizar, actualizar y eliminar tareas musicales, ayudándoles a organizar y optimizar su rutina de estudio musical.

---

## ✅ Funcionalidades

1. **Registro/Login**
    - Cada guitarrista tiene su cuenta personal para acceder a su lista de tareas.

2. **Gestión de tareas musicales**
   Cada tarea puede tener:
    - 🎵 **Título**: por ejemplo, "Practicar escalas mayores"
    - 🕓 **Duración estimada** (en minutos)
    - 📆 **Fecha de práctica**
    - 🏷️ **Categoría**: Técnica, Improvisación, Repertorio, Transcripción, Lectura
    - ✅ **Estado**: Completada o pendiente
    - ✍️ **Notas** (opcional)

3. **Filtros**
    - Ver tareas por **categoría**, **fecha** o **estado**.

4. **Panel principal**
    - Resumen diario del tipo: “Hoy tienes 3 tareas: 1 de técnica, 2 de repertorio”.

---

## 🔗 Endpoints de la API (Symfony)

| Método | Ruta                | Descripción                    |
|--------|---------------------|--------------------------------|
| GET    | `/api/tasks`        | Listar tareas del usuario      |
| POST   | `/api/tasks`        | Crear nueva tarea              |
| GET    | `/api/tasks/{id}`   | Ver una tarea específica       |
| PUT    | `/api/tasks/{id}`   | Editar una tarea               |
| DELETE | `/api/tasks/{id}`   | Eliminar una tarea             |
| POST   | `/api/register`     | Crear nuevo usuario            |
| POST   | `/api/login`        | Obtener token de autenticación |

---

## 🧰 Tecnologías utilizadas

- **Backend**: Symfony 7.x (PHP)
- **Frontend**: Angular 18+
- **Autenticación**: JWT 
- **Base de datos**: MySQL 
- **ORM**: Doctrine

---

## 🚀 Objetivo del Proyecto

Facilitar a los músicos de jazz la organización de su estudio mediante una interfaz intuitiva y un backend robusto.

---

Hecho con ❤️ por Narciris para guitarristas apasionados del jazz.