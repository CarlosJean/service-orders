<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\ItemsRepository;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterItemsRequest;

class ItemsController extends Controller
{
    protected $itemsRepository;
    public function __construct(ItemsRepository $itemsRepository ){
        $this->itemsRepository = $itemsRepository;
    }

    
    public function index(){
        return view('inventory.items');
    }


    public function store (RegisterItemsRequest $request){    
        try {            
            $description = $request->input('descripcion');
            $nombre = $request->input('nombre');
            $medida = $request->input('medida');
            $precio = $request->input('precio');
            $cantidad = $request->input('cantidad');
            $referencia = $request->input('referencia');


            $this->itemsRepository->create($description, $nombre, $medida, $precio, $cantidad, $referencia);
            

            return redirect('items');
            
        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        }    
    }
      
    public function update ($id){    
        try {            

            $this->itemsRepository->update($id);
           
            return redirect('items');


        } catch (\Throwable $th) {          
            var_dump($th);
            //throw $th;
        }    
    } 

    public function getItems(){
        $items = $this->itemsRepository->all();
        return $items;
    }    
    
    public function getAvailableItems(){
        $items = $this->itemsRepository
            ->available();
        return $items;
    }    

    public function createDispatchMaterials(){        
        return view('items.dispatch');
    }
    
    public function createDeliveryOfMaterials(Request $request){
        $serviceOrderNumber = $request->input('service_order_number');
        $this->itemsRepository->serviceOrderItems($serviceOrderNumber);
        return view('items.delivery');
    }

    public function storeDispatch(Request $request){       
        try {
            $itemsId = $request->input('items');
            $this->itemsRepository->dispatch($itemsId);

            return view('items.dispatched');
        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        } 
    }
}
