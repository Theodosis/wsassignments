<?php
    $ch = curl_init( 'http://localhost/w3c-validator/check' );
    curl_setopt( $ch, CURLOPT_POST, true );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, array(
        'uploaded_file' => "@/as3/530/index.html;type=text/html",
        'output' => 'soap12' 
    ) );
    
    $xml = curl_exec( $ch );
    echo $xml;
?>
