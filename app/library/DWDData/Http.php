<?php

class DWDData_Http {

    static function callback($data, $delay) { 
        usleep($delay);
        return $data;
    }

    static function PackageGetRequest( &$ch, $reques ){ 
        $path           =  http_build_query( $request['data'] );
        $reques['url'] .= '?' . $path;
        curl_setopt($ch, CURLOPT_URL, $reques['url']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_NOSIGNAL, true);
    }

    static function PackagePostRequest( &$ch, $reques ){ 
        curl_setopt($ch, CURLOPT_URL, $reques['url']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_NOSIGNAL, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $reques['data']);
    } 

    static function MutliCall($requests, $delay) {

        $queue                 = curl_multi_init();
        $map                   = array();
     
        foreach ($requests as $reqId => $request) {
            $ch                = curl_init();
            switch ( $request['method'] ) {
                case 'post':
                    self::PackageGetRequest( $ch, $request );
                    break;
                case 'get':
                    self::PackagePostRequest( $ch, $request );
                    break;
                default: break;
            }
            self::PackageGetRequest( $ch, $request );
            curl_multi_add_handle($queue, $ch);
            $map[(string) $ch] = $reqId;
        }
     
        $responses        = array();

        do {
            while (($code = curl_multi_exec($queue, $active)) == CURLM_CALL_MULTI_PERFORM) ;
     
            if ($code != CURLM_OK) { break; }
     
            // a request was just completed -- find out which one
            while ($done  = curl_multi_info_read($queue)) {
               
                // get the info and content returned on the request
                $info     = curl_getinfo($done['handle']);
                $error    = curl_error($done['handle']);
                $results  = self::callback(curl_multi_getcontent($done['handle']), $delay);
                $responses[$map[(string) $done['handle']]] = compact('info', 'error', 'results');
     
                // remove the curl handle that just completed
                curl_multi_remove_handle($queue, $done['handle']);
                curl_close($done['handle']);
            }
     
            // Block for data in / output; error handling is done by curl_multi_exec
            if ($active > 0) {
                curl_multi_select($queue, 0.5);
            }
     
        } while ($active);
     
        curl_multi_close($queue);
        return $responses;
    }

}