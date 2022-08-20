<?php

namespace App\Models;

use App\Http\Requests\StoreAddressRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

class ViaCEP extends Model{
    use HasFactory;
    /**
     * Método responsável por consultar um CEP no ViaCEP
     * @param string $postal_code
     * @return array
    */
    public static function searchPostalCode(string $postal_code) {
        // INICIA O CURL
        $curl = curl_init();

        //CONFIGURAÇÕES DO CURL
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://viacep.com.br/ws/' . $postal_code . '/json/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET'
        ]);

        //RESPONSE
        $response = curl_exec($curl);

        //FECHA A CONEXÃO ABERTA
        curl_close($curl);

        //CONVERTE JSON PARA ARRAY
        $array = json_decode($response, true);

        $city = $array['localidade'];
        $complement = $array['complemento'];
        $country = 'Brasil';
        $district = $array['bairro'];
        $number = "";
        $postal_code = $array['cep'];
        $state = $array['uf'];
        $street = $array['logradouro'];

        $r = ViaCEP::addressResponse($postal_code, $street, $number, $complement, $district, $city, $state, $country);
        //RETORNA O CONTEÚDO EM ARRAY
         return isset($array['cep']) ? $r : null;
    }

    public static function searchStreet(string $state, string $city, string $street) {
        // CODIFICA A STRING PARA URL
        $city = urlencode(strtolower($city));
        $street = urlencode(strtolower($street));

        // INICIA O CURL
        $curl = curl_init();

        //CONFIGURAÇÕES DO CURL
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://viacep.com.br/ws/' . $state . '/' . $city . '/' . $street . '/json/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET'
        ]);

        //RESPONSE
        $response = curl_exec($curl);

        //FECHA A CONEXÃO ABERTA
        curl_close($curl);

        //CONVERTE JSON PARA ARRAY
        $array = json_decode($response, true);

        //RETORNA O CONTEÚDO
        return isset($array[0]['cep']) ? $array : response([],Response::HTTP_NO_CONTENT);
    }

    public static function addressResponse($postal_code, $street, $number, $complement, $district, $city, $state, $country) {
        return response()->json([
            "city" => $city,
            "complement" => $complement,
            "country" => $country,
            "district" => $district,
            "number" => $number,
            "postal_code" => $postal_code,
            "state" => $state,
            "street" => $street,
        ], 200);
        ;
    }
}
