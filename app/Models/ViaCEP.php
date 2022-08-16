<?php

namespace App\WebService;

class ViaCEP{
    /**
     * Método responsável por consultar um CEP no ViaCEP
     * @param string $postal_code
     * @return array
    */
    public static function searchPostalCode($postal_code) {
        // INICIA O CURL
        $curl = curl_init();

        //CONFIGURAÇÕES DO CURL
        curl_setopt_array($curl, [
            CURLOPT_URL => 'HTTPS://viacep.com.br/ws/' . $postal_code . '/json/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET'
        ]);

        //RESPONSE
        $response = curl_exec($curl);

        //FECHA A CONEXÃO ABERTA
        curl_close($curl);

        dd($response);
    }
}
