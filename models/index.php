<?php
    $admins = array( 530 );
    // Warning: screwed up code ahead. Proceed with causion.

    // check if there is a cookie at all.
    if( !isset( $_COOKIE[ 'user' ] ) ){
        header('Location: /login.php');
        exit();
    }
    $cookie = $_COOKIE[ 'user' ];
    $parts = explode( "&", $cookie );
    // is the cookie valid?
    if( sizeof( $parts ) <= 1 || strlen( $parts[ 1 ] ) != 32 ){
        setcookie( 'user', NULL, -1 );
        header('Location: /login.php');
        exit();
    }
    $userid = $parts[ 0 ];
    $authtoken = $parts[ 1 ];
    // Connect with DB
     mysql_connect( 'localhost', 'Webseminars', 'd14c16c9afa5d58da62426fb5951ad7c' ) or die( mysql_error() );
     mysql_select_db( 'Webseminars' ) or die( mysql_error() );

     mysql_query( "SET NAMES UTF8;" );

    // Validate user
    $res = mysql_query( "SELECT * FROM student WHERE student_id='" . mysql_real_escape_string( $userid ) . "' AND student_authtoken='" . mysql_real_escape_string( $authtoken ) . "';" );

    if( !mysql_num_rows( $res ) ){
        setcookie( 'user', NULL, -1 );
        header('Location: /login.php');
        exit();
    }
    $student = mysql_fetch_object( $res );
    // Submit file, in case there is one
    $results    = "";
    $description = "Η προθεσμία για την πρώτη εργασία έχει λήξει.";
    /*
    if( time() < 1320883199 && isset( $_FILES[ 'as2' ] ) ){
        $ch = curl_init( 'http://theodosis.podzone.net/submit.php' );
        curl_setopt( $ch, CURLOPT_PORT, 2442 );
        //$ch = curl_init( 'http://192.168.0.143/submit.php' );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 300 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, array(
            'pass' => '77019bea641ff583ca2dcb801e431d53',
            'id' => $student->student_id,
            'mail' => $student->student_mail,
            'filename' => $_FILES[ 'as2' ][ 'name' ],
            'file' => '@' . $_FILES[ 'as2' ][ 'tmp_name' ]
        ) );

        $results = curl_exec( $ch );
        curl_close( $ch );
        if( $results !== false ){
            $results = json_decode( $results );
            if( !isset( $results->validation_id ) || !isset( $results->score ) ){
                $score = "";
                $description = "Υπήρξε κάποιο πρόβλημα στον Server. Παρακαλώ δοκιμάστε ξανά σε μερικά λεπτά.";
            }
            else{
                //saving result to the database
                mysql_query("INSERT INTO Submission
                                VALUES('','" . mysql_real_escape_string( $student->student_id ) . "','1',NOW(),'" .
                                    mysql_real_escape_string( $results->validation_id ) . "','" . mysql_real_escape_string( $results->score ) . "');" );
                $res_desc = mysql_query("Select validation_description from Validation_status where validation_id = '" .  mysql_real_escape_string( $results->validation_id ) . "';" );
                $obj_desc = mysql_fetch_object( $res_desc );
                $score = $results->score;
                $description = $obj_desc->validation_description;
            }
        }
        else{
            $score = "";
            $description = "Υπήρξε κάποιο πρόβλημα στον Server. Παρακαλώ δοκιμάστε ξανά σε μερικά λεπτά.";
        }
    }

    if( isset( $_FILES[ 'as3' ] ) ){
        $ch = curl_init( 'http://theodosis.podzone.net/submit3.php' );
        curl_setopt( $ch, CURLOPT_PORT, 2442 );
        //$ch = curl_init( 'http://192.168.0.143/submit.php' );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 300 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, array(
            'pass' => '77019bea641ff583ca2dcb801e431d53',
            'id' => $student->student_id,
            'mail' => $student->student_mail,
            'filename' => $_FILES[ 'as3' ][ 'name' ],
            'file' => '@' . $_FILES[ 'as3' ][ 'tmp_name' ]
        ) );

        $results = curl_exec( $ch );
        curl_close( $ch );
        $description3 = "Υπήρξε κάποιο πρόβλημα στον Server. Παρακαλώ δοκιμάστε ξανά σε μερικά λεπτά.";
        if( $results !== false ){
            $results = json_decode( $results );
            if( isset( $results->validation_id ) ){
                //saving result to the database
                mysql_query("INSERT INTO Submission
                                VALUES('','" . mysql_real_escape_string( $student->student_id ) . "','2',NOW(),'" .
                                    mysql_real_escape_string( $results->validation_id ) . "');" );
                $res_desc = mysql_query("Select validation_description from Validation_status where validation_id = '" .  mysql_real_escape_string( $results->validation_id ) . "';" );
                $obj_desc = mysql_fetch_object( $res_desc );
                $description3 = $obj_desc->validation_description;
            }
        }
    }  */
    // Fetch submission status with that awesome query, which may not work.
    $res = mysql_query("SELECT * FROM Submission as S " .
                    "INNER JOIN Validation_status as V ON S.validation_id=V.validation_id  " .
                    "where S.student_id='" . mysql_real_escape_string( $student->student_id ) . "' AND S.assignment_id='1' " .
                    "ORDER BY V.validation_id ASC LIMIT 1;");

    $config = array(
        "id" => "10",
        "status" => "Δεν έχει αποσταλεί",
    );
    if( mysql_num_rows( $res ) != 0 ){
        $obj = mysql_fetch_object( $res );
        $config[ 'id' ] = $obj->validation_id;
        $config[ 'status' ] = $obj->validation_description;
    }

    // Fetch submission status with that awesome query, which may not work.
     $res = mysql_query("SELECT * FROM Submission as S " .
                    "INNER JOIN Validation_status as V ON S.validation_id=V.validation_id  " .
                    "where S.student_id='" . mysql_real_escape_string( $student->student_id ) . "' AND S.assignment_id='2' " .
                    "ORDER BY V.validation_id ASC LIMIT 1;");

    $config2 = array(
        "id" => "10",
        "status" => "Εκκρεμεί"
    );
    if( mysql_num_rows( $res ) != 0 ){
        $obj = mysql_fetch_object( $res );
        $config2[ 'id' ] = $obj->validation_id;
        $config2[ 'status' ] = $obj->validation_description;
    }

    mysql_close();
    echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="el" lang="el">
    <head>
        <title>Web Seminar Assignment Dashboard</title>
        <link type="text/css" rel="stylesheet" href="css/global.css?1" />
    </head>
    <body>
        <form method="post" action="" id="container" enctype="multipart/form-data">
            <h1>Web Seminar Dashboard</h1>
            <span id="exit" title="Έξοδος"></span>
            <p>Καλωσήρθες στο σύστημα υποβολής εργασιών. Σε περίπτωση που επικοινωνήσεις μαζί μας, ανάφερέ μας το id σου: <?php
                echo $student->student_id;
            ?></p>
            <ul>
                <li>
                    <h2>Δεύτερη εργασία. </h2>
                    <div>Κατάσταση: <span><?php
                        echo $config[ 'status' ];
                    ?></span></div>
                </li>
                <li>
                    <h2>Τρίτη εργασία.</h2>
                    <?php /*
                    <input type="file" name="as3" /><?php
                    if( $_SERVER[ 'REQUEST_METHOD'] == "POST" && isset( $_FILES[ 'as3' ] ) ){
                        ?>
                            <div>Κατάσταση:
                                <span><?php
                                    echo $description3;
                                ?></span>
                            </div>
                        <?php
                    }
                    ?>
                    <h3>Συνολικά Αποτελέσματα.</h3>*/ ?>
                    <div>Κατάσταση: <span><?php
                        echo $config2[ 'status' ];
                    ?></span></div>
                </li>
            </ul>
        </form>
        <script type="text/javascript" src="javascript/jquery-1.6.2.min.js"></script>
        <script type="text/javascript">
            $( 'input[type=file]' ).change( function(){
                $( 'form' ).submit();
            } );
            $( '#exit' ).click( function(){
                document.cookie = 'user=';
                window.location = '/login.php';
            });
        </script>
    </body>
</html>
