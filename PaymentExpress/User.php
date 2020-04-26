<?php

namespace PaymentExpress;

class User
{

    protected $uuid;
    protected $token;

    public function __construct(string $uuid, string $token)
    {
        $this->uuid = $uuid;
        $this->token = $token;
    }

    public function getBalance(bool $formatted = false) : string
    {

        return $this->request('balance')[$formatted ? 'text' : 'balance'];

    }

    protected function request(string $method, array $data = []) : ?array
    {

        $url = Merchant::DOMAIN . Merchant::DOMAIN_API . $method;

        $data['uuid'] = $this->uuid;
        $data['token'] = $this->token;

        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYSTATUS => false,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data)
        ]);

        $json = curl_exec($curl);
        $json = json_decode($json, true);

        curl_close($curl);

        return $json;

    }

}