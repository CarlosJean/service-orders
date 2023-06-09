<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundModelException;
use App\Models\Quote;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuoteRequest;
use App\Repositories\QuotesRepository;
use Illuminate\Http\Request;

class QuoteController extends Controller
{

    protected $quotesRepository;
    public function __construct(QuotesRepository $quotesRepository)
    {
        $this->quotesRepository = $quotesRepository;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('quotes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $quoteNumber = $this->quotesRepository->quoteNumber();
        return view('quotes.create')->with('quoteNumber', $quoteNumber);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuoteRequest $request)
    {
        try {
            $quoteNumber = $request->input('quote_number');
            $serviceOrderNumber = $request->input('service_order_number');
            $quotes = $request->input('quotes');

            if ($quotes == null) {
                return back()
                    ->withErrors(['no_items' => 'Debe especificar los artículos a comprar.'])
                    ->withInput();
            }
            $this->quotesRepository->storeQuote($quoteNumber, $serviceOrderNumber, $quotes);

            return view('quotes.created')->with('quoteNumber', $quoteNumber);
        } catch (\Throwable $th) {
            return back()
                ->withErrors(['exceptions' => $th->getMessage()])
                ->withInput();
        }
    }

    public function getQuoteByNumber(Request $request)
    {
        try {
            $quoteNumber = $request->input('quoteNumber');
            return $this->quotesRepository->quoteByNumber($quoteNumber);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function actives()
    {
        return $this->quotesRepository->getActiveQuotes();
    }

    public function show($quoteNumber)
    {
        try {
            $quote = $this->quotesRepository->getQuote($quoteNumber);
    
            foreach ($quote['detail'] as $detail) {
                $detail->quantity = number_format($detail->quantity, 2, '.', ',');
                $detail->price = number_format($detail->price, 2, '.', ',');
            }
    
            $quote['totals']['quantity'] = number_format($quote['totals']['quantity'], 2, '.', ',');
            $quote['totals']['price'] = number_format($quote['totals']['price'], 2, '.', ',');
            
            return view('quotes.show')->with('quote', $quote);
        } catch(NotFoundModelException){
            return view('errors.not_found')->with('redirect', './');
        }catch (\Throwable $th) {
            //throw $th;
        }
    }
}
