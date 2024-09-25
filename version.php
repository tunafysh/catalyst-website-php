<?php
    if( $_SERVER['REQUEST_METHOD'] == "GET" ) {
        $version = file_get_contents("https://cly-rs.vercel.app/version");
        exit(0);
    }
    else if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        
        $queries = array();
        if(empty($_SERVER['QUERY_STRING']) ){
            die("No parameters specified");
            exit(1);
        }
        parse_str($_SERVER['QUERY_STRING'], $queries);
        $localkey = getenv("CATALYST_KEY");
        $key = $queries["key"];
        if($key != $localkey){
            die("Invalid key");
            exit(1);
        }
        curl_setopt($ch, CURLOPT_URL, "https://cly-rs.vercel.app/version?".http_build_query($queries));
        echo curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_exec($ch);
        curl_close($ch);
        exit(0);
    }
    else{
        die("unknown http method");
        exit(1);
    }
?>