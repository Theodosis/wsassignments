<?php
    function getext( $name ){
        return substr( $name, stripos( $name, '.' ) + 1 );
    }
    
    //error_reporting( E_ALL );
    if( $_SERVER[ 'REMOTE_ADDR' ] != '155.207.19.48' ){
        echo "Move away.";
        exit();
    }
    if( !isset( $_POST[ 'pass' ] ) || $_POST[ 'pass' ] != '77019bea641ff583ca2dcb801e431d53' ){
        echo "Get the HELL out of here!";
        exit();
    }
    $id = $_POST[ 'id' ];
    $filename = $_POST[ 'filename' ];
    $ext = getext( $filename );
    $mail = $_POST[ 'mail' ];
    
    $counter = 1;
    while( file_exists( "/as3/$id" . "_$counter" ) ){
        ++$counter;
    }
    $name = $id . "_$counter";
    mkdir( "/as3/$name" );
    file_put_contents( "/as3/$name/mail.txt", $mail );
    if( !isset( $_FILES[ 'file' ] ) || ( getext( $_POST[ 'filename' ] ) != 'zip' && getext( $_POST[ 'filename' ] ) != 'rar' ) ){
        echo json_encode( array(
            'score' => getext( $_POST[ 'filename' ] ),
            'validation_id' => "4" ) );
        file_put_contents( "/as3/$name/report.txt", "wrong file extension.\n", FILE_APPEND );
        exit();
    }
    move_uploaded_file( $_FILES[ 'file' ][ 'tmp_name' ], "/as3/$name/try.$ext" );
    
    $command = $ext == 'zip' ? "unzip /as3/$name/try.$ext -d /as3/$name/" : "rar x /as3/$name/try.$ext -d /as3/$name/";
    ob_start();
    system( $command );
    ob_clean();
    if( !file_exists( "/as3/$name/index.html" ) || !file_exists( "/as3/$name/images" ) || !file_exists( "/as3/$name/css" ) ){
        echo json_encode( array(
            'score' => '0',
            'validation_id' => 6
        ) );
        file_put_contents( "/as3/$name/report.txt", "wrong file/folder structure.\n", FILE_APPEND );
        exit();
    }
    $ch = curl_init( 'http://localhost/w3c-validator/check' );
    curl_setopt( $ch, CURLOPT_POST, true );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, array(
        'uploaded_file' => "@/as3/$name/index.html;type=text/html",
        'output' => 'soap12' 
    ) );
    
    $xml = curl_exec( $ch );
    file_put_contents( "/as3/$name/validator_report.txt", $xml );
    if( strrpos( $xml, '<m:validity>true</m:validity>' ) === false ) { //|| strpos( $xml, '<m:warningcount>0</m:warningcount>' ) === false ){
        echo json_encode( array(
            'score' => '3',
            'validation_id' =>7
        ) );
        file_put_contents( "/as3/$name/report.txt", "Invalid" );
        exit();
    }

    $html = file_get_contents( "/as3/$name/index.html" );
    
    if( strpos( $html, 'utf-8' ) === false && strpos( $html, 'UTF-8' ) === false ){
        echo json_encode( array(
            'score' => 0,
            'validation_id' => 9
        ) );
        file_put_contents( "/as3/$name/report.txt", "No urf-8 declaration." );
        exit();
    }
    if( strpos( $html, 'XHTML 1.0 Strict' ) === false ){
        echo json_encode( array(
            'validation_id' => 10
        ) );
        file_put_contents( "/as3/$name/report.txt", "Wrong Doctype" );
        exit();
    }
    
    
    $blacklist = array( 'http://', 'https', '<script', 'embed', 'object' );
    $whitelist = array( '/http:\/\/www.w3.org\/TR\/xhtml1\/DTD\/xhtml1-strict.dtd/', '/http:\/\/www.w3.org\/1999\/xhtml/', '/\<a\ [a-zA-Z0-9-_=":#\'\/\.]*?\>/' );
    foreach( $whitelist as $rule ){
        $html = preg_replace( $rule, '', $html );
    }
    foreach( $blacklist as $rule ){
        if( strpos( $html, $rule ) !== false ){
            echo json_encode( array(
                'score' => 0,
                'validation_id' => 8
            ) );
            file_put_contents( "/as3/$name/blacklisted.txt", "$rule\n", FILE_APPEND );
            file_put_contents( "/as3/$name/report.txt", "Blacklisted" );
            exit();
        }
    }

    // by now folder has all the contents it needs, and is valid
    
    $contents = intval( file_get_contents( 'lock' ) );
    while( $contents != 0 ){
        sleep( 1 );
        $contents = intval( file_get_contents( 'lock' ) );
    }
    file_put_contents( 'lock', 1 );
    system( "xvfb-run --server-args='-screen 0, 1280x1024x24' /system/cutycapt/CutyCapt --url=/as3/$name/index.html --out=/as3/$name/$mail.png --min-width=1280" );
    file_put_contents( 'lock', 0 );
    
    system( "cp /as3/$name/$mail.png /as3x/$mail" . "_$counter" . "_$id.png" );
    //system( "rm -r /as3/$id/images" );
    //system( "rm -r /as3/$id/css" );
    system( "rm /as3/$name/try.$ext" );
    
    $ret = array(
        "score" => 0,
        "validation_id" => 0
    );
    echo json_encode( $ret );
?>

