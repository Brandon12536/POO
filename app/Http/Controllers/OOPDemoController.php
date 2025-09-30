<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidValueException;
use App\Exceptions\InvalidEmployeeDataException;
use App\OOP\Processors\AdvancedProcessor;
use App\OOP\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OOPDemoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/oop-demo",
     *     summary="Demostración completa de conceptos OOP",
     *     description="Endpoint que demuestra todos los conceptos OOP con un ejemplo de empleado real",
     *     tags={"OOP Demo"},
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             @OA\Property(property="demo_title", type="string", example="Sistema de Gestión de Empleados - Conceptos OOP"),
     *             @OA\Property(property="employee_data", type="object", example={"name": "Patricia Morales", "age": 31, "email": "patricia.morales@empresa.com", "position": "Gerente de Proyectos", "salary": 90000, "annual_salary": 1080000}),
     *             @OA\Property(property="concepts_demonstrated", type="array", @OA\Items(type="string"), example={"Constructor", "Métodos", "Herencia", "Interfaz", "Clase Abstracta", "$this y parent::"}),
     *             @OA\Property(property="full_info", type="string", example="Patricia Morales (31 años) - patricia.morales@empresa.com - Puesto: Gerente de Proyectos, Salario: $90,000.00")
     *         )
     *     )
     * )
     */
    public function show(): JsonResponse
    {
        $employee = new Employee('Patricia Morales', 31, 'patricia.morales@empresa.com', 90000, 'Gerente de Proyectos');
        return response()->json([
            'demo_title' => 'Sistema de Gestión de Empleados - Conceptos OOP',
            'employee_data' => [
                'name' => $employee->getName(),
                'age' => $employee->getAge(),
                'email' => $employee->getEmail(),
                'position' => $employee->getPosition(),
                'salary' => $employee->getSalary(),
                'annual_salary' => $employee->calculateAnnualSalary()
            ],
            'concepts_demonstrated' => [
                'Constructor',
                'Métodos',
                'Herencia',
                'Interfaz',
                'Clase Abstracta',
                '$this y parent::'
            ],
            'full_info' => $employee->getInfo()
        ]);
    }

    /**
     * @OA\Get(
     *     path="/oop-demo/constructor",
     *     summary="Demostración de Constructor",
     *     description="Muestra cómo funciona el constructor creando un empleado real",
     *     tags={"OOP Demo"},
     *     @OA\Response(
     *         response=200,
     *         description="Constructor ejecutado",
     *         @OA\JsonContent(
     *             @OA\Property(property="concept", type="string", example="Constructor"),
     *             @OA\Property(property="employee_name", type="string", example="Ana García"),
     *             @OA\Property(property="employee_age", type="integer", example=28),
     *             @OA\Property(property="employee_email", type="string", example="ana.garcia@empresa.com"),
     *             @OA\Property(property="position", type="string", example="Desarrolladora Senior"),
     *             @OA\Property(property="salary", type="number", example=75000),
     *             @OA\Property(property="description", type="string", example="Constructor inicializa todas las propiedades del objeto")
     *         )
     *     )
     * )
     */
    public function showConstructor(): JsonResponse
    {
        $employee = new Employee('Ana García', 28, 'ana.garcia@empresa.com', 75000, 'Desarrolladora Senior');
        return response()->json([
            'concept' => 'Constructor',
            'employee_name' => $employee->getName(),
            'employee_age' => $employee->getAge(),
            'employee_email' => $employee->getEmail(),
            'position' => $employee->getPosition(),
            'salary' => $employee->getSalary(),
            'description' => 'Constructor inicializa todas las propiedades del objeto'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/oop-demo/method",
     *     summary="Demostración de Métodos",
     *     description="Muestra diferentes tipos de métodos públicos y privados",
     *     tags={"OOP Demo"},
     *     @OA\Response(
     *         response=200,
     *         description="Métodos ejecutados",
     *         @OA\JsonContent(
     *             @OA\Property(property="concept", type="string", example="Método"),
     *             @OA\Property(property="public_methods", type="object", example={"getName": "Carlos Rodríguez", "getPosition": "Gerente de Ventas", "getSalary": 85000}),
     *             @OA\Property(property="calculated_method", type="number", example=1020000),
     *             @OA\Property(property="info_method", type="string", example="Carlos Rodríguez (35 años) - carlos.rodriguez@empresa.com - Puesto: Gerente de Ventas, Salario: $85,000.00")
     *         )
     *     )
     * )
     */
    public function showMethod(): JsonResponse
    {
        $employee = new Employee('Carlos Rodríguez', 35, 'carlos.rodriguez@empresa.com', 85000, 'Gerente de Ventas');
        return response()->json([
            'concept' => 'Método',
            'public_methods' => [
                'getName' => $employee->getName(),
                'getPosition' => $employee->getPosition(),
                'getSalary' => $employee->getSalary()
            ],
            'calculated_method' => $employee->calculateAnnualSalary(),
            'info_method' => $employee->getInfo()
        ]);
    }

    /**
     * @OA\Get(
     *     path="/oop-demo/inheritance",
     *     summary="Demostración de Herencia",
     *     description="Muestra cómo Employee hereda de Person",
     *     tags={"OOP Demo"},
     *     @OA\Response(
     *         response=200,
     *         description="Herencia demostrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="concept", type="string", example="Herencia"),
     *             @OA\Property(property="parent_class", type="string", example="Person"),
     *             @OA\Property(property="child_class", type="string", example="Employee"),
     *             @OA\Property(property="inherited_properties", type="object", example={"name": "María López", "age": 29, "email": "maria.lopez@empresa.com"}),
     *             @OA\Property(property="own_properties", type="object", example={"position": "Analista de Datos", "salary": 65000}),
     *             @OA\Property(property="extended_functionality", type="string", example="Employee extiende Person agregando propiedades laborales")
     *         )
     *     )
     * )
     */
    public function showInheritance(): JsonResponse
    {
        $employee = new Employee('María López', 29, 'maria.lopez@empresa.com', 65000, 'Analista de Datos');
        return response()->json([
            'concept' => 'Herencia',
            'parent_class' => 'Person',
            'child_class' => 'Employee',
            'inherited_properties' => [
                'name' => $employee->getName(),
                'age' => $employee->getAge(),
                'email' => $employee->getEmail()
            ],
            'own_properties' => [
                'position' => $employee->getPosition(),
                'salary' => $employee->getSalary()
            ],
            'extended_functionality' => 'Employee extiende Person agregando propiedades laborales'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/oop-demo/exception",
     *     summary="Demostración de Excepciones",
     *     description="Muestra el manejo de excepciones al crear empleado con datos inválidos",
     *     tags={"OOP Demo"},
     *     @OA\Response(
     *         response=422,
     *         description="Excepción capturada",
     *         @OA\JsonContent(
     *             @OA\Property(property="concept", type="string", example="Excepción"),
     *             @OA\Property(property="exception_class", type="string", example="InvalidEmployeeDataException"),
     *             @OA\Property(property="error", type="string", example="El salario debe ser mayor a 0"),
     *             @OA\Property(property="attempted_data", type="object", example={"name": "Empleado Test", "salary": -5000})
     *         )
     *     )
     * )
     */
    public function showException(): JsonResponse
    {
        try {
            $salary = -5000;
            if ($salary <= 0) {
                throw new InvalidEmployeeDataException('El salario debe ser mayor a 0');
            }
            $employee = new Employee('Empleado Test', 25, 'test@empresa.com', $salary, 'Desarrollador');
            return response()->json(['message' => 'No debería llegar aquí']);
        } catch (InvalidEmployeeDataException $e) {
            return response()->json([
                'concept' => 'Excepción',
                'exception_class' => 'InvalidEmployeeDataException',
                'error' => $e->getMessage(),
                'attempted_data' => [
                    'name' => 'Empleado Test',
                    'salary' => -5000
                ]
            ], 422);
        }
    }

    /**
     * @OA\Get(
     *     path="/oop-demo/interface",
     *     summary="Demostración de Interfaz",
     *     description="Muestra cómo se implementa la interfaz Identifiable",
     *     tags={"OOP Demo"},
     *     @OA\Response(
     *         response=200,
     *         description="Interfaz implementada",
     *         @OA\JsonContent(
     *             @OA\Property(property="concept", type="string", example="Interfaz"),
     *             @OA\Property(property="interface_name", type="string", example="Identifiable"),
     *             @OA\Property(property="required_methods", type="array", @OA\Items(type="string"), example={"getName()", "getEmail()", "getInfo()"}),
     *             @OA\Property(property="implementation_example", type="object", example={"name": "Luis Martínez", "email": "luis.martinez@empresa.com", "info": "Luis Martínez (32 años) - luis.martinez@empresa.com - Puesto: Arquitecto de Software, Salario: $95,000.00"})
     *         )
     *     )
     * )
     */
    public function showInterface(): JsonResponse
    {
        $employee = new Employee('Luis Martínez', 32, 'luis.martinez@empresa.com', 95000, 'Arquitecto de Software');
        return response()->json([
            'concept' => 'Interfaz',
            'interface_name' => 'Identifiable',
            'required_methods' => ['getName()', 'getEmail()', 'getInfo()'],
            'implementation_example' => [
                'name' => $employee->getName(),
                'email' => $employee->getEmail(),
                'info' => $employee->getInfo()
            ]
        ]);
    }

    /**
     * @OA\Get(
     *     path="/oop-demo/abstract",
     *     summary="Demostración de Clase Abstracta",
     *     description="Muestra cómo funciona la clase abstracta Person",
     *     tags={"OOP Demo"},
     *     @OA\Response(
     *         response=200,
     *         description="Clase abstracta demostrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="concept", type="string", example="Clase Abstracta"),
     *             @OA\Property(property="abstract_class", type="string", example="Person"),
     *             @OA\Property(property="concrete_class", type="string", example="Employee"),
     *             @OA\Property(property="abstract_method", type="string", example="getInfo()"),
     *             @OA\Property(property="concrete_methods", type="array", @OA\Items(type="string"), example={"getName()", "getAge()", "getEmail()"}),
     *             @OA\Property(property="implementation_result", type="string", example="Sofía Hernández (27 años) - sofia.hernandez@empresa.com - Puesto: Diseñadora UX, Salario: $70,000.00")
     *         )
     *     )
     * )
     */
    public function showAbstract(): JsonResponse
    {
        $employee = new Employee('Sofía Hernández', 27, 'sofia.hernandez@empresa.com', 70000, 'Diseñadora UX');
        return response()->json([
            'concept' => 'Clase Abstracta',
            'abstract_class' => 'Person',
            'concrete_class' => 'Employee',
            'abstract_method' => 'getInfo()',
            'concrete_methods' => ['getName()', 'getAge()', 'getEmail()'],
            'implementation_result' => $employee->getInfo()
        ]);
    }

    /**
     * @OA\Get(
     *     path="/oop-demo/this-parent",
     *     summary="Demostración de $this y parent::",
     *     description="Muestra el uso de $this para propiedades/métodos propios y parent:: para métodos del padre",
     *     tags={"OOP Demo"},
     *     @OA\Response(
     *         response=200,
     *         description="$this y parent:: demostrados",
     *         @OA\JsonContent(
     *             @OA\Property(property="concept", type="string", example="This y Parent"),
     *             @OA\Property(property="this_examples", type="object", example={"this_name": "Roberto García", "this_position": "Director de TI", "this_salary": 120000}),
     *             @OA\Property(property="parent_examples", type="object", example={"parent_constructor": "Inicializa propiedades básicas de Person", "parent_getBasicInfo": "Roberto García (45 años) - roberto.garcia@empresa.com"}),
     *             @OA\Property(property="combined_result", type="string", example="Roberto García (45 años) - roberto.garcia@empresa.com - Puesto: Director de TI, Salario: $120,000.00")
     *         )
     *     )
     * )
     */
    public function showThisParent(): JsonResponse
    {
        $employee = new Employee('Roberto García', 45, 'roberto.garcia@empresa.com', 120000, 'Director de TI');
        return response()->json([
            'concept' => 'This y Parent',
            'this_examples' => [
                'this_name' => $employee->getName(),
                'this_position' => $employee->getPosition(),
                'this_salary' => $employee->getSalary()
            ],
            'parent_examples' => [
                'parent_constructor' => 'Inicializa propiedades básicas de Person',
                'parent_getBasicInfo' => $employee->getName() . ' (' . $employee->getAge() . ' años) - ' . $employee->getEmail()
            ],
            'combined_result' => $employee->getInfo()
        ]);
    }

}
