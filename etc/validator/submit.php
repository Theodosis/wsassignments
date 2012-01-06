<?php
    //error_reporting( E_ALL );
    if( $_SERVER[ 'REMOTE_ADDR' ] != '155.207.19.48' ){
        echo "Move away.";
        exit();
    }
    if( !isset( $_POST[ 'pass' ] ) || $_POST[ 'pass' ] != '77019bea641ff583ca2dcb801e431d53' ){
        echo "Get the HELL out of here!";
        exit();
    }
    if( !isset( $_POST[ 'id' ] ) ){
        echo json_encode( array( 
            'score' => '0',
            'validation_id' => "2" ) );
        exit();
    }
    $id = $_POST[ 'id' ];
    if( !isset( $_FILES[ 'file' ] ) || $_POST[ 'filename' ] != 'style.css' ){
        echo json_encode( array(
            'score' => '0',
            'validation_id' => "3" ) );
        exit();
    }
    mkdir( "/as/$id" );
    system( "cp /as/default/* /as/$id/" );
    
    move_uploaded_file( $_FILES[ 'file' ][ 'tmp_name' ], "/as/$id/style.css" );
    
    // by now folder /var/www/validator/id has all the contents it needs
    
    $contents = intval( file_get_contents( 'lock' ) );
    $counter = 0;
    while( $contents != 0 ){
        sleep( 1 );
        $contents = intval( file_get_contents( 'lock' ) );
        ++$counter;
        file_put_contents( 'counter', '|', FILE_APPEND | LOCK_EX );
        if( $counter > 5 ){
            echo json_encode( array(
                'score' => '0',
                'validation_id' => '2'
            ) );
        }
    }
    file_put_contents( 'lock', 1 );
    //$mail = str_replace( '@', '[at]', $_POST[ 'mail' ] );
    $mail = $_POST[ 'mail' ];
    system( "xvfb-run --server-args='-screen 0, 1280x1024x24' /system/cutycapt/CutyCapt --url=/as/$id/sandwich.html --out=/as/$id/$mail.png --min-width=1264 --min-height=948" );
    file_put_contents( 'lock', 0 );
    
    ob_start();
    system( "/system/image_diff/test.py /as/$id/out.png /as/screenshot.png" );
    $res = intval( ob_get_clean() );
    
    system( "cp /as/$id/style.css /as/$id/$res.css" );
    system( "rm /as/$id/sandwich.html" );
    system( "rm /as/$id/menu.png" );
    system( "rm /as/$id/sandwich.png" );
    
    $ret = array(
        "score" => $res,
        "validation_id" => $res >= 100 ? "0": "1"
    );
    echo json_encode( $ret );
    //echo ob_get_clean();
?>

