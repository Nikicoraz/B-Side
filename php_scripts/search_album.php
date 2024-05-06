<?php
    /**
     * Search for an album on Spotify
     * 
     * @param string $token Spotify API token
     * @param string $album_name The name of the album to search for
     * @return array An array of information about the album, or null if there was an error
     */
    function search_album($token, $album_name){
        $curl = curl_init("https://api.spotify.com/v1/search?q=" . urlencode($album_name) . "&type=album&limit=5");

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $token));

        $ret = curl_exec($curl);
        
        if($ret == false){
            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            // Retry if token expired
            if($http_code == 401){
                include "php_scripts/grab_token";

                $token = grab_new_token();
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $token));
                $ret = curl_exec($curl);
                if($ret != false){
                    return json_decode($ret, true);
                }
            }
            // Print error and info from cURL
            echo "Errore curl: " . curl_error($curl);
            var_dump(curl_getinfo($curl));
        }

        return json_decode($ret, true);
    }

?>