<?php

namespace App\Http\Middleware;

use App\Enums\SystemRoles;
use App\Repositories\EmployeeRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanViewServiceOrders
{
    public function __construct(protected EmployeeRepository $employeeRepository) {}
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = auth()->id();
        $employee = $this->employeeRepository->employeeByUserId($userId);

        if (!($employee['system_role'] == SystemRoles::DepartmentManager 
        || $employee['system_role'] == SystemRoles::DepartmentSupervisor
        || $employee['system_role'] == SystemRoles::MaintenanceManager 
        || $employee['system_role'] == SystemRoles::MaintenanceSupervisor)) {
            abort(403, 'Acceso denegado');
        }

        return $next($request);
    }
}
