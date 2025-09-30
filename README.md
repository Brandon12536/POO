# 🏗️ Laravel OOP + Supabase CRUD - Sistema de Gestión de Empleados

Sistema completo de gestión de empleados que demuestra **todos los conceptos de Programación Orientada a Objetos (OOP)** implementados de forma real y práctica con base de datos **Supabase** y documentación **Swagger**.

## 🌐 **Sistema Desplegado**
**URL Local:** [http://127.0.0.1:8000](http://127.0.0.1:8000)

**Documentación API:** [http://127.0.0.1:8000/api/documentation](http://127.0.0.1:8000/api/documentation)

## ✨ Características principales
- 🏗️ **Conceptos OOP reales**: Constructor, Métodos, Herencia, Excepciones, Interfaces, Clases Abstractas, $this y parent::
- 🗄️ **Base de datos real**: Integración completa con Supabase PostgreSQL
- 📊 **CRUD completo**: Create, Read, Update, Delete con validaciones empresariales
- 📋 **API REST**: Endpoints sin CSRF para integración externa
- 📚 **Documentación Swagger**: Interfaz interactiva para probar todos los endpoints
- 🎯 **Arquitectura en capas**: Controller → Service → Model → Database
- 🔒 **Validaciones empresariales**: Email único, rangos de edad, salarios válidos
- 📈 **Estadísticas**: Reportes automáticos de empleados y salarios
- 🧪 **Página de pruebas**: Interface HTML para testing rápido
- 🎨 **Ejemplos prácticos**: Cada concepto OOP aplicado en contexto empresarial

## 🛠️ Tecnologías principales

![PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white&style=for-the-badge)
![Laravel](https://img.shields.io/badge/Laravel-FF2D20?logo=laravel&logoColor=white&style=for-the-badge)
![Swagger](https://img.shields.io/badge/Swagger-85EA2D?logo=swagger&logoColor=black&style=for-the-badge)
![Supabase](https://img.shields.io/badge/Supabase-3ECF8E?logo=supabase&logoColor=white&style=for-the-badge)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-336791?logo=postgresql&logoColor=white&style=for-the-badge)
![Guzzle](https://img.shields.io/badge/Guzzle-FF6B35?logo=php&logoColor=white&style=for-the-badge)
![Composer](https://img.shields.io/badge/Composer-885630?logo=composer&logoColor=white&style=for-the-badge)
![OOP](https://img.shields.io/badge/OOP-4F5D95?logo=php&logoColor=white&style=for-the-badge)
![REST API](https://img.shields.io/badge/REST%20API-25D366?logo=postman&logoColor=white&style=for-the-badge)
![Development Status](https://img.shields.io/badge/Status-Production%20Ready-green?style=for-the-badge)

## 🏗️ **Conceptos OOP Implementados**

### 1. **Constructor** - Inicialización empresarial
```php
// ✅ Uso real: Inyección de dependencias
public function __construct()
{
    $this->employeeModel = new EmployeeModel();
    $this->supabase = new SupabaseClient();
}
```

### 2. **Métodos** - Lógica de negocio
```php
// ✅ Uso real: Métodos con validación y persistencia
public function createEmployee(array $data): array
{
    $this->validateEmployeeData($data);
    $employee = new Employee(...);
    return $this->employeeModel->create($employee);
}
```

### 3. **Herencia** - Jerarquía empresarial
```php
// ✅ Uso real: Especialización de entidades
abstract class Person implements Identifiable
{
    protected string $name, $email;
    abstract public function getInfo(): string;
}

class Employee extends Person
{
    private float $salary;
    public function getInfo(): string { /* implementación */ }
}
```

### 4. **Excepciones** - Manejo específico de errores
```php
// ✅ Uso real: Excepciones del dominio empresarial
class InvalidEmployeeDataException extends Exception
{
    // Manejo específico para validación de empleados
}
```

### 5. **Interfaz** - Contratos empresariales
```php
// ✅ Uso real: Contrato de identificación
interface Identifiable
{
    public function getName(): string;
    public function getEmail(): string;
    public function getInfo(): string;
}
```

### 6. **Clase Abstracta** - Base arquitectural
```php
// ✅ Uso real: Base para entidades de negocio
abstract class Person implements Identifiable
{
    protected function getBasicInfo(): string { /* común */ }
    abstract public function getInfo(): string; /* específico */
}
```

### 7. **$this y parent::** - Composición real
```php
// ✅ Uso real: Reutilización y extensión
public function getInfo(): string
{
    $basicInfo = parent::getBasicInfo();
    return $basicInfo . " - Salario: $" . number_format($this->salary, 2);
}
```

## 📁 Estructura del proyecto

```
Laravel/
├── app/
│   ├── Http/Controllers/
│   │   ├── Controller.php              # Controlador base con Swagger config
│   │   ├── OOPDemoController.php       # Demos de conceptos OOP
│   │   └── EmployeeCrudController.php  # CRUD completo con Supabase
│   ├── Services/
│   │   ├── SupabaseClient.php          # Cliente HTTP para Supabase
│   │   └── EmployeeService.php         # Lógica de negocio
│   ├── Models/
│   │   └── EmployeeModel.php           # Modelo de datos con CRUD
│   ├── OOP/
│   │   ├── Contracts/
│   │   │   ├── Operable.php            # Interfaz para procesadores
│   │   │   └── Identifiable.php        # Interfaz para identificación
│   │   ├── Abstracts/
│   │   │   ├── BaseProcessor.php       # Clase abstracta base
│   │   │   └── Person.php              # Clase abstracta para personas
│   │   ├── Models/
│   │   │   └── Employee.php            # Modelo Employee con herencia
│   │   └── Processors/
│   │       └── AdvancedProcessor.php   # Procesador con herencia
│   └── Exceptions/
│       ├── InvalidValueException.php   # Excepción para procesadores
│       └── InvalidEmployeeDataException.php # Excepción para empleados
├── routes/
│   ├── web.php                         # Rutas web (con CSRF)
│   └── api.php                         # Rutas API (sin CSRF)
├── database/
│   └── supabase_setup.sql              # Script de base de datos
├── bootstrap/
│   └── app.php                         # Configuración con rutas API
├── test_api.html                       # Página de pruebas interactiva
├── README_SUPABASE_CRUD.md             # Documentación técnica
└── README.md                           # Este archivo
```

## ⚡ Instalación rápida

1. 📥 Clona el repositorio:
   ```bash
   git clone <url-del-repo>
   cd Laravel
   ```

2. 📦 Instala dependencias:
   ```bash
   composer install
   ```

3. ⚙️ Configura las variables de entorno:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. 🗄️ Configura Supabase en `.env`:
   ```env
   # Base de datos Supabase
   DB_CONNECTION=pgsql
   DB_HOST=db.tu-proyecto.supabase.co
   DB_PORT=5432
   DB_DATABASE=postgres
   DB_USERNAME=postgres
   DB_PASSWORD=tu-password-supabase
   
   # API Supabase
   SUPABASE_URL=https://tu-proyecto.supabase.co
   SUPABASE_ANON_KEY=tu-anon-key
   SUPABASE_SERVICE_KEY=tu-service-key
   ```

5. 🗄️ Ejecuta el script SQL en Supabase:
   - Ve al **SQL Editor** en tu dashboard de Supabase
   - Copia y ejecuta el contenido de `database/supabase_setup.sql`

6. 🚀 Inicia el servidor:
   ```bash
   php artisan serve
   ```

7. 🌐 Abre en el navegador:
   - **Swagger UI**: [http://127.0.0.1:8000](http://127.0.0.1:8000)
   - **Página de pruebas**: [http://127.0.0.1:8000/test_api.html](http://127.0.0.1:8000/test_api.html)

## 🚀 Endpoints Principales

### 🏗️ **Demos OOP** (Conceptos educativos)
- `GET /oop-demo` - Demostración completa de conceptos OOP
- `GET /oop-demo/constructor` - Constructor con empleado real
- `GET /oop-demo/method` - Métodos públicos y privados
- `GET /oop-demo/inheritance` - Herencia Employee → Person
- `GET /oop-demo/exception` - Manejo de excepciones
- `GET /oop-demo/interface` - Implementación de Identifiable
- `GET /oop-demo/abstract` - Clase abstracta Person
- `GET /oop-demo/this-parent` - Uso de $this y parent::

### 📊 **CRUD Completo** (Base de datos real)
- `GET /api/employees` - Listar todos los empleados
- `POST /api/employees` - Crear empleado nuevo
- `GET /api/employees/{id}` - Obtener empleado por ID
- `PUT /api/employees/{id}` - Actualizar empleado
- `DELETE /api/employees/{id}` - Eliminar empleado
- `GET /api/employees/statistics` - Estadísticas de empleados

### 🧪 **Demos con Supabase** (OOP + Base de datos)
- `POST /api/oop-demo/employee` - Crear empleado (OOP + Supabase)
- `PUT /api/oop-demo/employee` - Actualizar empleado (OOP + Supabase)

## 📚 Documentación Completa

### 🚀 **Acceso Rápido**
- ⚡ [Swagger UI](http://127.0.0.1:8000) - Documentación interactiva
- 🧪 [Página de Pruebas](http://127.0.0.1:8000/test_api.html) - Testing rápido
- 🐳 [Docker para Producción](#-despliegue-con-docker) - Contenedor listo para producción

### 🏗️ **Conceptos OOP Explicados**
- 🔧 **Constructor**: Inicialización de servicios y dependencias
- 📝 **Métodos**: Lógica de negocio, validaciones y cálculos
- 🌳 **Herencia**: Employee extiende Person (jerarquía empresarial)
- ⚠️ **Excepciones**: InvalidEmployeeDataException para errores específicos
- 📋 **Interfaz**: Identifiable define contratos de identificación
- 🏛️ **Clase Abstracta**: Person como base para entidades
- 🔗 **$this y parent::**: Composición y reutilización de código

### 🗄️ **Base de Datos**
- 📊 **Tabla employees**: Estructura completa con validaciones
- 🔍 **Índices**: Optimización para email, position, salary
- 🛡️ **RLS**: Row Level Security habilitado
- 🕒 **Triggers**: Actualización automática de timestamps
- 📋 **Datos de ejemplo**: 5 empleados precargados

### 🎯 **Funcionalidades Empresariales**
- ✅ **Validaciones**: Email único, edad 18-65, salario > 0
- 📊 **Estadísticas**: Promedios, conteos, distribución por puesto
- 🔍 **Búsquedas**: Por ID, email, filtros múltiples
- 📈 **Reportes**: Métricas automáticas de empleados

## 🧪 Testing y Calidad

### 📊 **Herramientas de Testing**
- 🌐 **Swagger UI**: Testing interactivo de todos los endpoints
- 🧪 **Página HTML**: Interface de pruebas con JavaScript
- 📋 **Validaciones**: Verificación automática de datos
- ⚡ **Respuestas rápidas**: Feedback inmediato de operaciones

### 🎯 **Casos de Prueba Cubiertos**
- ✅ **CRUD completo**: Crear, leer, actualizar, eliminar
- ✅ **Validaciones**: Datos inválidos, duplicados, rangos
- ✅ **Excepciones**: Manejo de errores específicos
- ✅ **Estadísticas**: Cálculos y agregaciones
- ✅ **Conceptos OOP**: Todos los patrones implementados

### 📋 **Comandos de Testing**
```bash
# Probar endpoints desde terminal
curl -X GET "http://127.0.0.1:8000/api/employees"

# Crear empleado
curl -X POST "http://127.0.0.1:8000/api/employees" \
  -H "Content-Type: application/json" \
  -d '{"name":"Test User","age":30,"email":"test@empresa.com","salary":75000,"position":"Developer"}'

# Ver estadísticas
curl -X GET "http://127.0.0.1:8000/api/employees/statistics"
```

## 🎯 **Diferencias con Ejemplos Básicos**

| **Aspecto** | **Ejemplo Básico** | **Este Proyecto** |
|-------------|-------------------|-------------------|
| **Constructor** | `new Employee('Juan')` | Inyección de dependencias, configuración de servicios |
| **Métodos** | `getName() { return $name; }` | Validaciones, cálculos, persistencia en BD |
| **Herencia** | `Dog extends Animal` | Employee extends Person (jerarquía empresarial) |
| **Excepciones** | `throw new Exception()` | InvalidEmployeeDataException específica |
| **Interfaz** | `interface Animal` | Identifiable con funcionalidad empresarial |
| **Persistencia** | Arrays en memoria | Base de datos PostgreSQL real |
| **Validación** | Básica o ninguna | Validación empresarial completa |
| **Arquitectura** | Clases sueltas | Capas: Controller → Service → Model → DB |

## 🌟 **Casos de Uso Empresariales Reales**

1. **🏢 Gestión de RRHH**: Sistema completo de empleados
2. **📊 Reportes gerenciales**: Estadísticas automáticas
3. **🔍 Búsquedas avanzadas**: Filtros por múltiples criterios
4. **✅ Validaciones empresariales**: Email único, rangos válidos
5. **📈 Métricas en tiempo real**: Promedios, conteos, distribuciones
6. **🔌 API para integración**: Endpoints REST sin CSRF
7. **📚 Documentación viva**: Swagger con ejemplos reales

## 🛡️ **Seguridad y Mejores Prácticas**

- 🔒 **Validación de datos**: Sanitización y verificación completa
- 🛡️ **Excepciones específicas**: Manejo granular de errores
- 🔑 **Variables de entorno**: Credenciales seguras
- 📋 **Documentación**: Swagger con ejemplos y validaciones
- 🎯 **Separación de responsabilidades**: Arquitectura en capas
- 🗄️ **Base de datos segura**: Supabase con RLS habilitado

## 📝 **Ejemplos de Uso**

### Crear Empleado
```json
POST /api/employees
{
  "name": "Ana García",
  "age": 28,
  "email": "ana.garcia@empresa.com",
  "salary": 75000,
  "position": "Desarrolladora Senior"
}
```

### Respuesta
```json
{
  "success": true,
  "data": {
    "id": 6,
    "name": "Ana García",
    "age": 28,
    "email": "ana.garcia@empresa.com",
    "position": "Desarrolladora Senior",
    "salary": 75000,
    "annual_salary": 900000,
    "full_info": "Ana García (28 años) - ana.garcia@empresa.com - Puesto: Desarrolladora Senior, Salario: $75,000.00",
    "created_at": "2024-01-01T10:00:00Z"
  },
  "concepts_used": [
    "Constructor - Crea instancia Employee",
    "Herencia - Employee extiende Person",
    "Métodos - calculateAnnualSalary(), getInfo()",
    "Interfaz - Implementa Identifiable",
    "Base de datos - Inserción en Supabase"
  ]
}
```

## 🎉 **Resultado Final**

Este proyecto demuestra **todos los conceptos de OOP aplicados en un contexto empresarial real**:

- ✅ **No es solo teoría**: Cada concepto resuelve problemas reales
- ✅ **Base de datos real**: Supabase PostgreSQL en producción
- ✅ **API completa**: Endpoints REST documentados
- ✅ **Validaciones empresariales**: Reglas de negocio reales
- ✅ **Arquitectura profesional**: Capas bien definidas
- ✅ **Documentación completa**: Swagger interactivo
- ✅ **Casos de uso reales**: Sistema de gestión de empleados

**¡Es la diferencia entre aprender conceptos teóricos vs. aplicarlos en un sistema de producción real!**

## 🐳 Despliegue con Docker

### **Dockerfile para Producción**

El proyecto incluye un `Dockerfile` optimizado para producción con:

- ✅ **PHP 8.3** con extensiones necesarias
- ✅ **Nginx** como servidor web
- ✅ **Composer** para dependencias
- ✅ **Supervisord** para gestión de procesos
- ✅ **Optimizaciones** de cache y autoload
- ✅ **Variables de entorno** configurables

### **Comandos Docker**

```bash
# Construir imagen
docker build -t laravel-oop-supabase .

# Ejecutar contenedor
docker run -d \
  --name laravel-oop-app \
  -p 80:80 \
  -e DB_HOST=db.tu-proyecto.supabase.co \
  -e DB_PASSWORD=tu-password \
  -e SUPABASE_URL=https://tu-proyecto.supabase.co \
  -e SUPABASE_ANON_KEY=tu-anon-key \
  -e SUPABASE_SERVICE_KEY=tu-service-key \
  laravel-oop-supabase

# Ver logs
docker logs laravel-oop-app

# Acceder al contenedor
docker exec -it laravel-oop-app bash
```

### **Docker Compose (Opcional)**

```yaml
version: '3.8'
services:
  app:
    build: .
    ports:
      - "80:80"
    environment:
      - APP_ENV=production
      - APP_DEBUG=false
      - DB_HOST=db.tu-proyecto.supabase.co
      - DB_PASSWORD=tu-password
      - SUPABASE_URL=https://tu-proyecto.supabase.co
      - SUPABASE_ANON_KEY=tu-anon-key
      - SUPABASE_SERVICE_KEY=tu-service-key
    restart: unless-stopped
```

### **Despliegue en Producción**

1. **Construir imagen**: `docker build -t laravel-oop .`
2. **Configurar variables**: Actualizar credenciales de Supabase
3. **Ejecutar contenedor**: `docker run -d -p 80:80 laravel-oop`
4. **Verificar**: Acceder a `http://tu-servidor/api/documentation`

## 📝 Licencia
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE)

## © Copyright
**© 2025 Brandon Pérez R. Todos los derechos reservados.**

Este proyecto es propiedad intelectual de Brandon Pérez R. Se permite el uso, modificación y distribución bajo los términos de la licencia MIT.
