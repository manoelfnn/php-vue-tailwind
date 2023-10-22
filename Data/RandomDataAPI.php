<?php

include "IData.php";

class RandomDataAPI implements IData
{
    const ENDPOINT = "https://random-data-api.com/api/v2";

    const USER_RESOURCE = "users";

    /**
     * getUser Retornar um ou mais usuários de forma aleatória
     *
     * @param int $limit Limite de usuários retornados
     * @return Array
     */
    public function getUser(int $limit = 1)
    {
        $result = self::_APICurl("users", ["size" => $limit]);
        $result = json_decode($result);

        return $result;
    }

    private function _APICurl(String $resource, $extras = [])
    {
        $queryString  = http_build_query($extras);

        $curl = curl_init();
        $url = self::ENDPOINT . "/$resource" . ($queryString ? "/?$queryString" : '');
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($curl);
        curl_close($curl);

        if ($output === false) {
            throw new RuntimeException("Error: " . curl_error($curl));
        }        

        return $output;
    }
}
