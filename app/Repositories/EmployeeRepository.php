<?php

namespace App\Repositories;

use App\Exceptions\NoUserEmailException;
use App\Exceptions\UniqueColumnException;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use OutOfRangeException;
use PhpParser\Node\Stmt\TryCatch;

class EmployeeRepository
{

    public function employeeByUserId($userId)
    {
        $employeeModel =  Employee::where('user_id', $userId)->first();

        $employee = array(
            'id' => $employeeModel->id,
            'roleId' => $employeeModel->role_id,
            'user_id' => $employeeModel->user_id,
            'names' => $employeeModel->names,
            'last_names' => $employeeModel->last_names,
            'identification' => $employeeModel->identification,
            'email' => $employeeModel->email,
        );

        return $employee;
    }

    public function create(Employee $employee, $createUser = false)
    {

        try {

            if ($employee->id != null) {
                $this->updateEmployee($employee, $createUser);
            } else {
                $this->createEmployee($employee, $createUser);
            }
        } catch (UniqueColumnException $e) {
            throw $e;
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    private function createEmployee(Employee $employee, $createUser = false)
    {
        try {
            $emailRegistered = Employee::where('email', $employee->email)->first();

            if (isset($emailRegistered)) {
                $message = 'Ya existe un empleado con el correo ' . $employee->email . '.';
                throw new UniqueColumnException($message);
            }

            $identificationRegistered = Employee::where('identification', $employee->identification)->first();
            if (isset($identificationRegistered)) {
                $message = 'Ya existe un empleado con el documento de identificación no. ' . $employee->identification . '.';
                throw new UniqueColumnException($message);
            }

            $newEmployee = new Employee([
                'identification' => $employee->identification,
                'names' => $employee->names,
                'last_names' => $employee->last_names,
                'email' => $employee->email,
                'department_id' => $employee->department_id,
                'role_id' => $employee->role_id,
            ]);

            if ($createUser && $employee->email == null) {
                throw new NoUserEmailException();
            }

            if ($createUser) {
                $newUser = new User([
                    'name' => $employee->names . ' ' . $employee->last_names,
                    'email' => $employee->email,
                    'password' => Hash::make($employee->email),
                ]);

                $newUser->save();
            }

            $newEmployee->save();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function updateEmployee($employee, $createUser = false)
    {
        try {

            if ($createUser && $employee->email == null) {
                throw new NoUserEmailException();
            }

            $employeeIdByEmail = Employee::where('email', $employee->email)
                ?->select('id')
                ?->first()
                ?->id;

            if ($employee->email != null && $employeeIdByEmail != null && $employeeIdByEmail != $employee->id) {
                $message = 'Ya existe un empleado con el correo ' . $employee->email . '.';
                throw new UniqueColumnException($message);
            }

            $updatedEmployee = $this->employeeById($employee->id);
            $updatedEmployee->identification = $employee->identification;
            $updatedEmployee->names = $employee->names;
            $updatedEmployee->last_names = $employee->last_names;
            $updatedEmployee->email = $employee->email;
            $updatedEmployee->department_id = $employee->department_id;
            $updatedEmployee->role_id = $employee->role_id;

            if($employee->email != null){
                $user = User::find($updatedEmployee->user->id);
                $user->name = $employee->email;
                $user->email = $employee->email;
    
                $user->save();
            }
            
            $updatedEmployee->save();
        } catch (UniqueColumnException $ex) {
            throw $ex;
        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        }
    }

    public function employeeById($id): Employee
    {
        try {
            return Employee::find($id);
        } catch (\Throwable $th) {
            throw new OutOfRangeException();
        }
    }
}