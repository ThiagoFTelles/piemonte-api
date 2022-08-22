<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Models\ViaCEP;
use App\Models\Address;
use App\Services\AddressService;
use Exception;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * @var AddressService
     */
    protected $addressService;

    /**
     * AddressController Constructor
     *
     * @param AddressService $addressService
     *
     */
    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->addressService->getAll();
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAddressRequest $request)
    {
        $data = $request->only([
            "postal_code",
            "street",
            "number",
            "complement",
            "district",
            "city",
            "state",
            "country"
        ]);

        $result = ['status' => 200];

        try{
            $result['data'] = $this->addressService->saveAddressData($data);
        } catch (Exception $e){
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param number $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->addressService->getById($id);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
        return response()->json($result, $result['status']);
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
     * Update address.
     *
     * @param Request $request
     * @param number $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $data = $request->only([
            "postal_code",
            "street",
            "number",
            "complement",
            "district",
            "city",
            "state",
            "country"
        ]);

        $result = ['status' => 200];

        try {
            $result['data'] = $this->addressService->updateAddress($data, $id);

        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param number $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->addressService->deleteById($id);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
        return response()->json($result, $result['status']);
    }
    
    public function postalCodeSarch($code)
    {
        $localAddress = Address::firstWhere('postal_code', $code);
        $postalCodeData = $localAddress ? $localAddress : ViaCEP::searchPostalCode($code)->original;
        return response()->json([
            'data' => $postalCodeData,
            'status' => true
        ]);
    }

    public function  streetSearch($state, $city, $street)
    {
        $result = ViaCEP::searchStreet($state, $city, $street)->original;

        return $result ? response()->json([
            'data' => $result,
            'status' => true
        ], 200) : null;
    }

}
