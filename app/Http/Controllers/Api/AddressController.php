<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostalCodeRequest;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\StreetRequest;
use App\Models\Address;
use App\Models\ViaCEP;
use Illuminate\Http\Request;

use function GuzzleHttp\Promise\all;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = Address::all();
        
        return response()->json([
            'status' => true,
            'addresses' => $addresses
        ]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAddressRequest $request)
    {
        $address = Address::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Address created succesfully.',
            'address' => $address
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAddressRequest $request, Address $address)
    {
        $address->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Address updated succesfully.',
            'address' => $address
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        $address->delete();

        return response()->json([
            'status' => true,
            'message' => 'Address deleted succesfully.'
        ], 200);
    }
    
    public function postalCodeSarch(PostalCodeRequest $request)
    {
        $postalCode = $request->input('postal_code');
        $localAddress = Address::firstWhere('postal_code', $postalCode);
        $postalCodeData = $localAddress ? $localAddress->toJson() : ViaCEP::searchPostalCode($postalCode);
        return dd($postalCodeData);
    }

    public function  streetSearch(StreetRequest $request)
    {
        $street = $request->input('street');
        return dd($street);
    }

}
