<?php

    echo "Welcome Care Pro !!! ";

    

    $json = file_get_contents('info.json');
    $jsonData = json_decode($json);

?>