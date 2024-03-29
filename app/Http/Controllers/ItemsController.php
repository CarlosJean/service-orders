<?php

namespace App\Http\Controllers;

use App\Exceptions\EmptyListException;
use App\Http\Controllers\Controller;
use App\Repositories\ItemsRepository;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterItemsRequest;

class ItemsController extends Controller
{
    protected $itemsRepository;

    public function __construct(ItemsRepository $itemsRepository)
    {
        $this->itemsRepository = $itemsRepository;
    }


    public function index()
    {
        return view('inventory.items');
    }


    public function store(RegisterItemsRequest $request)
    {
        try {
            $description = $request->input('descripcion');
            $nombre = $request->input('nombre');
            $medida = $request->input('medida');
            $precio = $request->input('precio');
            $cantidad = $request->input('cantidad');
            $referencia = $request->input('referencia');
            $categoria = $request->input('categoria');


            $this->itemsRepository->create($description, $nombre, $medida, $precio, $cantidad, $referencia,  $categoria);


            // return redirect('items');

            return back()->with('success',  'Registro creado!');
        } catch (\Throwable $th) {
            return back()->with('error',  $th->getMessage());
            //throw $th;
        }
    }

    public function update($id)
    {
        try {

            $this->itemsRepository->update($id);

            //  return redirect('items');

            echo json_encode(['type' => 'success', 'message' => 'Cambios aplicados correctamente!']);
        } catch (\Throwable $th) {
            echo json_encode(['type' => 'error', 'message' => $th->getMessage()]);

            //throw $th;
        }
    }

    public function getItems()
    {
        $items = $this->itemsRepository->all();
        return $items;
    }

    public function getItemsAll()
    {
        $items = $this->itemsRepository->all(true);
        return $items;
    }

    public function getAvailableItems()
    {
        $items = $this->itemsRepository
            ->available();
        return $items;
    }

    public function createDispatchMaterials($serviceOrderNumber = null)
    {
        return view('items.dispatch')->with('serviceOrderNumber', $serviceOrderNumber);
    }

    public function createDeliveryOfMaterials(Request $request)
    {
        $serviceOrderNumber = $request->input('service_order_number');
        $this->itemsRepository->serviceOrderItems($serviceOrderNumber);
        return view('items.delivery');
    }

    public function storeDispatch(Request $request)
    {
        try {
            $serviceOrderNumber = $request->input('service_order_id');
            $this->itemsRepository->dispatch($serviceOrderNumber);

            return view('items.dispatched');
        } catch (EmptyListException $ex) {
            return back()->withErrors($ex->getMessage());
        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        }
    }

    public function getItem($itemId)
    {
        try {
            $item = $this->itemsRepository->item($itemId);
            return $item;
        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        }
    }
}
