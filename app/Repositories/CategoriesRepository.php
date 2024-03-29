<?php

namespace App\Repositories;

use App\Models\Categories;
use Exception;

class CategoriesRepository{

    public function categories($all=false){
        //return Service::get();

    $model = Categories::select('name', 'id','description','active') ;
    
    if(!$all) {       
        $model = $model ->where('active',1);
    }
      
    return $model->get();

    }


    public function update($id)
    {
        try {

            $model =  Categories::find($id);


        if ($model->active == 1)
            $model->active = 0;
        else 
            $model->active = 1;

            $model->save();
        } catch (\Throwable $th) {
                       return redirect()->back() ->with('error',  $th->getMessage());

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

            $model = new Categories([
                'description' => $description,
                'name' => $nombre

            ]);

            $model->save();

        } catch (\Throwable $th) {
                       return redirect()->back() ->with('error',  $th->getMessage());

        }
    }


}
