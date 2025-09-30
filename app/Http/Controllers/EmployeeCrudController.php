<?php

namespace App\Http\Controllers;

use App\Services\EmployeeService;
use App\Exceptions\InvalidEmployeeDataException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeCrudController extends Controller
{
    private EmployeeService $employeeService;

    public function __construct()
    {
        $this->employeeService = new EmployeeService();
    }

    /**
     * @OA\Get(
     *     path="/api/employees",
     *     summary="Obtener todos los empleados",
     *     description="Obtiene lista completa de empleados desde Supabase",
     *     tags={"Employee CRUD"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de empleados",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="total", type="integer", example=5)
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $employees = $this->employeeService->getAllEmployees();
            
            return response()->json([
                'success' => true,
                'data' => $employees,
                'total' => count($employees),
                'concepts_used' => [
                    'Constructor - EmployeeService y Employee',
                    'Métodos - getAllEmployees(), getName(), etc.',
                    'Herencia - Employee extiende Person',
                    'Interfaz - Implementa Identifiable'
                ]
            ]);
        } catch (InvalidEmployeeDataException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/employees",
     *     summary="Crear nuevo empleado",
     *     description="Crea un empleado en Supabase con validaciones OOP",
     *     tags={"Employee CRUD"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Ana García"),
     *             @OA\Property(property="age", type="integer", example=28),
     *             @OA\Property(property="email", type="string", example="ana.garcia@empresa.com"),
     *             @OA\Property(property="salary", type="number", example=75000),
     *             @OA\Property(property="position", type="string", example="Desarrolladora Senior")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Empleado creado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="message", type="string", example="Empleado creado exitosamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos inválidos",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="error", type="string")
     *         )
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $employee = $this->employeeService->createEmployee($request->all());
            
            return response()->json([
                'success' => true,
                'data' => $employee,
                'message' => 'Empleado creado exitosamente',
                'concepts_used' => [
                    'Constructor - Crea instancia Employee',
                    'Validación - Excepción si datos inválidos',
                    'Métodos - calculateAnnualSalary(), getInfo()',
                    'Herencia - Usa métodos de Person',
                    'Base de datos - Inserción en Supabase'
                ]
            ], 201);
        } catch (InvalidEmployeeDataException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/employees/{id}",
     *     summary="Obtener empleado por ID",
     *     description="Obtiene un empleado específico desde Supabase",
     *     tags={"Employee CRUD"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Empleado encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Empleado no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="error", type="string", example="Empleado no encontrado")
     *         )
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        try {
            $employee = $this->employeeService->getEmployeeById($id);
            
            if (!$employee) {
                return response()->json([
                    'success' => false,
                    'error' => 'Empleado no encontrado'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'data' => $employee,
                'concepts_used' => [
                    'Métodos - getEmployeeById(), getName()',
                    'Constructor - Recrea objeto Employee',
                    'Herencia - Acceso a propiedades de Person'
                ]
            ]);
        } catch (InvalidEmployeeDataException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/employees/{id}",
     *     summary="Actualizar empleado",
     *     description="Actualiza un empleado existente en Supabase",
     *     tags={"Employee CRUD"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Ana García Actualizada"),
     *             @OA\Property(property="age", type="integer", example=29),
     *             @OA\Property(property="email", type="string", example="ana.garcia.nueva@empresa.com"),
     *             @OA\Property(property="salary", type="number", example=80000),
     *             @OA\Property(property="position", type="string", example="Tech Lead")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Empleado actualizado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="message", type="string", example="Empleado actualizado exitosamente")
     *         )
     *     )
     * )
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $employee = $this->employeeService->updateEmployee($id, $request->all());
            
            return response()->json([
                'success' => true,
                'data' => $employee,
                'message' => 'Empleado actualizado exitosamente',
                'concepts_used' => [
                    'Constructor - Nueva instancia con datos actualizados',
                    'Validación - Verificación de datos e email único',
                    'Métodos - update(), getName(), getSalary()',
                    'Excepciones - InvalidEmployeeDataException'
                ]
            ]);
        } catch (InvalidEmployeeDataException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/employees/{id}",
     *     summary="Eliminar empleado",
     *     description="Elimina un empleado de Supabase",
     *     tags={"Employee CRUD"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Empleado eliminado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Empleado eliminado exitosamente")
     *         )
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->employeeService->deleteEmployee($id);
            
            return response()->json([
                'success' => true,
                'message' => 'Empleado eliminado exitosamente',
                'concepts_used' => [
                    'Métodos - deleteEmployee(), findById()',
                    'Excepciones - Validación de existencia',
                    'Base de datos - Eliminación en Supabase'
                ]
            ]);
        } catch (InvalidEmployeeDataException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/employees/statistics",
     *     summary="Estadísticas de empleados",
     *     description="Obtiene estadísticas calculadas de todos los empleados",
     *     tags={"Employee CRUD"},
     *     @OA\Response(
     *         response=200,
     *         description="Estadísticas obtenidas",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object", example={"total_employees": 5, "average_salary": 78000, "average_age": 32.4, "positions": {"Desarrollador": 2, "Gerente": 1}})
     *         )
     *     )
     * )
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = $this->employeeService->getStatistics();
            
            return response()->json([
                'success' => true,
                'data' => $stats,
                'concepts_used' => [
                    'Métodos - getStatistics(), cálculos agregados',
                    'Arrays - array_sum(), array_column()',
                    'Matemáticas - Promedios y conteos'
                ]
            ]);
        } catch (InvalidEmployeeDataException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
