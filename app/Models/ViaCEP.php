<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

        //RETORNA O CONTEÚDO EM ARRAY
        return isset($array['cep']) ? $array : null;
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

        //RETORNA O CONTEÚDO EM ARRAY
        return isset($array[0]['cep']) ? $array : null;
    }
}
