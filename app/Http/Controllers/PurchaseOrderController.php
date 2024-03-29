<?php

namespace App\Http\Controllers;

use App\Exceptions\EmptyListException;
use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseOrderRequest;
use App\Repositories\PurchaseOrderRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{

    protected $purchaseOrderRepository;
    public function __construct(PurchaseOrderRepository $purchaseOrderRepository)
    {
        $this->purchaseOrderRepository = $purchaseOrderRepository;
    }

    public function index()
    {
        return view('purchase_orders.index');
    }

    public function create($quoteNumber = null)
    {
        $purchaseOrderNumber = $this->purchaseOrderRepository
            ->purchaseOrderNumber();
        return view('purchase_orders.create')->with([
            'purchaseOrderNumber' => $purchaseOrderNumber,
            'quoteNumber' => $quoteNumber,
        ]);
    }

    public function quoteByNumber(Request $request)
    {
        $quoteNumber = $request->input('quote_number');
        var_dump($quoteNumber);
        return back()
            ->withInput()
            ->with('quoteNumber', $quoteNumber);
    }

    public function store(PurchaseOrderRequest $request)
    {

        try {
            $quoteNumber = $request->input('quote_number');
            $purchaseOrderNumber = $request->input('purchase_order_number');
            $details = $request->input('items');

            $this->purchaseOrderRepository
                ->storePurchaseOrder($quoteNumber, $purchaseOrderNumber, $details);

            return view('purchase_orders.created')->with('purchaseOrderNumber', $purchaseOrderNumber);
        } catch (ModelNotFoundException $ex) {
            return back()->withErrors($ex->getMessage());
        } catch (EmptyListException $ex) {
            return back()->withErrors($ex->getMessage());
        } catch (\Throwable $th) {
            var_dump($th);
            //throw $th;
        }
    }

    public function show($number)
    {
        $purchaseOrder = $this->purchaseOrderRepository
            ->getPurchaseOrder($number);

        return view('purchase_orders.show')->with('purchaseOrder', $purchaseOrder);
    }

    public function getPurchaseOrders()
    {
        $purchaseOrders = $this->purchaseOrderRepository
            ->getPurchaseOrders();

        foreach ($purchaseOrders as $purchaseOrder) {
            $purchaseOrder->total = 'RD$ ' . number_format($purchaseOrder->total, 2);
        }

        return $purchaseOrders;
    }
}
