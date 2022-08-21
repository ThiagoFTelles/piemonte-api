<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Models\ViaCEP;
use App\Repositories\Contracts\AddressRepositoryInterface;
use App\Models\Address;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AddressRepositoryInterface $model)
    {
        $addresses = $model->findAll();
        
        return response()->json([
            'status' => true,
            'addresses' => [
                'original' => $addresses
                ]
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
    
    public function postalCodeSarch($code)
    {
        $localAddress = Address::firstWhere('postal_code', $code);
        $postalCodeData = $localAddress ? ['original' => $localAddress] : ViaCEP::searchPostalCode($code);
        return response()->json([
            'status' => true,
            'address' => $postalCodeData
        ]);
    }

    public function  streetSearch($state, $city, $street)
    {
        $result = ViaCEP::searchStreet($state, $city, $street);

        return $result ? json_encode($result) : null;
    }

}
