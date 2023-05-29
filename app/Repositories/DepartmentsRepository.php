<?php

namespace App\Repositories;

use App\Models\Department;
use Exception;

class DepartmentsRepository
{
    public function departments()
    {
        $departments = Department::select('name', 'id','description') ->where('active', 1)
            ->get();
            
        return $departments;
    }

    
    public function update($id)
    {
        try {

            $deparment =  Department::find($id);

            $deparment->active = 0;

            $deparment->save();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    public function create($description, $nombre)
    {
        try {

            if ($description == null) {
                throw new Exception('Debe especificar una descripcion.', 1);
            }

            if ($nombre == null) {
                throw new Exception('Debe especificar un nombre.', 1);
            }

            $deparment = new Department([
                'description' => $description,
                'name' => $nombre

            ]);

            $deparment->save();

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
