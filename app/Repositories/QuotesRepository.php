<?php

namespace App\Repositories;

use App\Exceptions\NotFoundModelException;
use App\Models\Item;
use App\Models\Order;
use App\Models\Quote;
use App\Models\QuoteDetail;
use App\Models\Supplier;
use Exception;
use Illuminate\Support\Facades\DB;

class QuotesRepository
{

    public function quoteNumber()
    {
        $quoteNumber = $this->newQuoteNumber();
        return $quoteNumber;
    }

    private function newQuoteNumber()
    {
        $number = rand(111111, 999999);
        $isUsed =  Quote::where('number', $number)->first();
        if ($isUsed) {
            return $this->newQuoteNumber();
        }
        return $number;
    }

    public function storeQuote($quoteNumber, $orderNumber, $quoteDetail)
    {
        try {

            //Calculando el costo total de la cotización
            $total = 0;
            foreach ($quoteDetail as $quote) {
                $total += $quote['price'];
            }

            //Objeto de cotización
            $newQuote = new Quote([
                'number' => $quoteNumber,
                'created_by' => auth()->id(),
                'total' => $total
            ]);

            $serviceOrder = Order::where('number', $orderNumber)->first();
            if ($serviceOrder != null) {
                $newQuote->order_id = $serviceOrder->id;
                $serviceOrder->status = "en espera de materiales";
                $serviceOrder->save();
            }
            $newQuote->save();

            foreach ($quoteDetail as $quote) {

                if ($quote['supplier_id'] == null) {
                    throw new Exception('Debe indicar el suplidor del artículo ' . $quote['item'] . '.');
                }

                $noSpaceWhere = DB::raw("LOWER(replace(name,' ',''))");
                $noSpaceItemName = str_replace(' ', '', $quote['item']);
                $noSpaceItemName = strtolower($noSpaceItemName);

                $newQuoteDetail = new QuoteDetail([
                    'item' => $quote['item'],
                    'reference' => $quote['reference'],
                    'quantity' => $quote['quantity'],
                    'price' => $quote['price'],
                    'supplier_id' => $quote['supplier_id'],
                ]);

                $item = Item::where($noSpaceWhere, $noSpaceItemName)
                    ?->first();

                if ($item != null) {
                    $newQuoteDetail->item_id = $item->id;
                    $newQuoteDetail->item = $item->name;
                }

                $newQuoteDetail->quote()->associate($newQuote);
                $newQuoteDetail->save();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function quoteByNumber($quoteNumber)
    {
        $quote = [];
        $quoteFound = Quote::where('number', $quoteNumber)
            ?->first();

        if (!$quoteFound) {
            throw new Exception('No existe una cotización con el número ' . $quoteNumber . '.');
        }

        if ($quoteFound?->retrieved) {
            throw new Exception('Esta cotización ya ha sido despachada.');
        }

        foreach ($quoteFound?->details as $detail) {
            array_push($quote, [
                'quote_id' => $quoteFound?->id,
                'quote_detail_id' => $detail->id,
                'number' => $quoteFound->number,
                'item' => $detail->item,
                'item_id' => $detail->item_id,
                'item' => $detail->item,
                'reference' => $detail->reference,
                'quantity' => $detail->quantity,
                'price' => $detail->price,
                'supplier' => Supplier::find($detail->supplier_id)->name,
                'supplier_id' => $detail->supplier_id,
            ]);
        }

        return $quote;
    }

    public function getActiveQuotes()
    {

        $quotes = DB::table('quotes')
            ->join('orders', 'quotes.order_id', '=', 'orders.id')
            ->join('users', 'orders.requestor', '=', 'users.id')
            ->join('employees', 'users.id', '=', 'employees.user_id')
            ->where('retrieved', '=', false)
            ->select(
                'quotes.id',
                DB::raw('DATE_FORMAT(quotes.created_at, "%d/%m/%Y %r") date'),
                'orders.number as order_number',
                DB::raw('CONCAT(employees.names, " ", employees.last_names) requestor'),
                'quotes.number as quote_number',
            )
            ->get();

        return $quotes;
    }

    public function getQuote($quoteNumber)
    {
        try {

            $quoteFound = Quote::where('number', $quoteNumber)->first();

            if (!$quoteFound) {
                throw new NotFoundModelException('No se encontró la cotización con el número ' . $quoteNumber . '.');
            }

            $quote = [
                'summary' => ['number' => 0, 'created_by' => '', 'date' => ''],
                'detail' => [],
                'totals' => ['price' => 0, 'quantity' => 0],
            ];

            $quote['summary'] = DB::table('quotes')
                ->join('users', 'quotes.created_by', 'users.id')
                ->join('employees', 'employees.user_id', 'users.id')
                ->where('quotes.number', $quoteNumber)
                ->select(
                    'quotes.number',
                    DB::raw('CONCAT(employees.names, " ", employees.last_names) created_by'),
                    DB::raw('DATE_FORMAT(quotes.created_at, "%d/%m/%Y %r") date'),
                )
                ->first();

            $quote['detail'] =  DB::table('quotes')
                ->join('quote_details', 'quotes.id', 'quote_details.quote_id')
                ->join('suppliers', 'quote_details.supplier_id', 'suppliers.id')
                ->where('quotes.number', $quoteNumber)
                ->select(
                    'suppliers.name as supplier',
                    'quote_details.item',
                    'quote_details.reference',
                    'quote_details.quantity',
                    'quote_details.price',
                )
                ->get();

            $quote['totals']['quantity'] = $quote['detail']->sum('quantity');
            $quote['totals']['price'] = $quote['detail']->sum('price');

            return $quote;
        } catch (NotFoundModelException $th) {
            throw $th;
        }
    }
}
