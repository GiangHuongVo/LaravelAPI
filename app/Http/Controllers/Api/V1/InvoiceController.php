<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Invoice;
use App\Http\Requests\UpdateInvoiceRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\InvoiceResource;
use App\Http\Resources\V1\InvoiceCollection;
use App\Filters\V1\InvoicesFilter;
use Illuminate\Support\Arr;
use App\Http\Requests\V1\BulkStoreInvoiceRequest;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new InvoicesFilter();
        $queryItems = $filter->transform($request); //[['column', 'operator','value']]

        if(count($queryItems) == 0){
            return new InvoiceCollection(Invoice::paginate());
        }
        else {
            $invoices = Invoice::where($queryItems)->paginate();
            return new InvoiceCollection($invoices->appends($request->query()));

        }       
        
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\V1\BulkStoreInvoiceRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BulkStoreInvoiceRequest $request)
    {
        //
    }

    // to store very large invoces, using bulkStore method => have to change api route
    public function bulkStore (BulkStoreInvoiceRequest $request){
        // if user insert with camel case, like  Invoice::insert('billedDate') => it has an error, because it is not the data type
        // Have to validation the type data
        $bulk = collect($request->all())->map(function($arr, $key){
            return Arr::except($arr, ['customerId', 'billedDate', 'paidDate']);
        });
        //Now insert to database
        Invoice::insert($bulk->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        return new InvoiceResource($invoice);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
