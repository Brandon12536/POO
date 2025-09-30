# Laravel OOP + Supabase CRUD

Sistema completo de gestión de empleados que demuestra conceptos OOP con base de datos real en Supabase.

## 🏗️ Arquitectura OOP Implementada

### 1. **Constructor**
- `Employee::__construct()` - Inicializa propiedades
- `EmployeeService::__construct()` - Inyección de dependencias
- `SupabaseClient::__construct()` - Configuración de cliente HTTP

### 2. **Métodos**
- `getName()`, `getAge()`, `getEmail()` - Getters públicos
- `calculateAnnualSalary()` - Método de cálculo
- `validateEmployeeData()` - Método privado de validación

### 3. **Herencia**
- `Employee extends Person` - Herencia de clase abstracta
- `Person implements Identifiable` - Implementación de interfaz

### 4. **Excepciones**
- `InvalidEmployeeDataException` - Excepción personalizada
- Manejo con try/catch en servicios y controladores

### 5. **Interfaz**
- `Identifiable` - Define contrato para objetos identificables
- Métodos requeridos: `getName()`, `getEmail()`, `getInfo()`

### 6. **Clase Abstracta**
- `Person` - Clase base abstracta
- Método abstracto: `getInfo()`
- Métodos concretos: `getName()`, `getAge()`

### 7. **$this y parent::**
- `$this->name` - Acceso a propiedades propias
- `parent::__construct()` - Llamada a constructor padre
- `parent::getBasicInfo()` - Uso de métodos del padre

## 🗄️ Configuración Supabase

### 1. Actualizar .env
```env
DB_CONNECTION=pgsql
DB_HOST=db.tu-proyecto.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=tu-password-supabase

SUPABASE_URL=https://tu-proyecto.supabase.co
SUPABASE_ANON_KEY=tu-anon-key
SUPABASE_SERVICE_KEY=tu-service-key
```

### 2. Ejecutar SQL en Supabase
Ejecuta el archivo `database/supabase_setup.sql` en el SQL Editor de Supabase.

## 🚀 Endpoints API Disponibles

### CRUD Completo (sin CSRF)
- `GET /api/employees` - Listar todos los empleados
- `POST /api/employees` - Crear empleado
- `GET /api/employees/{id}` - Obtener empleado por ID
- `PUT /api/employees/{id}` - Actualizar empleado
- `DELETE /api/employees/{id}` - Eliminar empleado
- `GET /api/employees/statistics` - Estadísticas

### Demos OOP (sin CSRF)
- `POST /api/oop-demo/employee` - Crear empleado (demo)
- `PUT /api/oop-demo/employee` - Actualizar empleado (demo)

### Conceptos OOP (con CSRF - solo GET)
- `GET /oop-demo` - Demo completo
- `GET /oop-demo/constructor` - Constructor
- `GET /oop-demo/method` - Métodos
- `GET /oop-demo/inheritance` - Herencia
- `GET /oop-demo/exception` - Excepciones
- `GET /oop-demo/interface` - Interfaz
- `GET /oop-demo/abstract` - Clase Abstracta
- `GET /oop-demo/this-parent` - $this y parent::

## 📝 Ejemplo de uso

### Crear empleado
```bash
POST /api/employees
Content-Type: application/json

{
  "name": "Juan Pérez",
  "age": 30,
  "email": "juan.perez@empresa.com",
  "salary": 80000,
  "position": "Desarrollador Full Stack"
}
```

### Respuesta
```json
{
  "success": true,
  "data": {
    "id": 6,
    "name": "Juan Pérez",
    "age": 30,
    "email": "juan.perez@empresa.com",
    "position": "Desarrollador Full Stack",
    "salary": 80000,
    "annual_salary": 960000,
    "full_info": "Juan Pérez (30 años) - juan.perez@empresa.com - Puesto: Desarrollador Full Stack, Salario: $80,000.00",
    "created_at": "2024-01-01T10:00:00Z"
  },
  "message": "Empleado creado exitosamente",
  "concepts_used": [
    "Constructor - Crea instancia Employee",
    "Validación - Excepción si datos inválidos",
    "Métodos - calculateAnnualSalary(), getInfo()",
    "Herencia - Usa métodos de Person",
    "Base de datos - Inserción en Supabase"
  ]
}
```

## 🔧 Clases Principales

### SupabaseClient
- Cliente HTTP para comunicación con Supabase
- Métodos: `select()`, `insert()`, `update()`, `delete()`

### EmployeeModel
- Modelo de datos para empleados
- Operaciones CRUD con Supabase
- Método `getStatistics()` para análisis

### EmployeeService
- Lógica de negocio
- Validaciones y reglas empresariales
- Integración entre modelo y controlador

### EmployeeCrudController
- API REST completa
- Documentación Swagger
- Manejo de errores

## 🎯 Conceptos OOP Demostrados

1. **Encapsulación** - Propiedades privadas/protegidas
2. **Abstracción** - Clase Person abstracta
3. **Herencia** - Employee hereda de Person
4. **Polimorfismo** - Implementación de Identifiable
5. **Composición** - EmployeeService usa EmployeeModel
6. **Inyección de dependencias** - Constructor injection
7. **Manejo de excepciones** - Try/catch personalizado

## 🌐 Acceso

1. **Swagger UI**: `http://127.0.0.1:8000` (redirige automáticamente)
2. **API Base**: `http://127.0.0.1:8000/api/employees`
3. **Demos OOP**: `http://127.0.0.1:8000/oop-demo`

¡El sistema está listo para usar con Supabase y demuestra todos los conceptos OOP solicitados!
