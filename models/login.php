<?php
    // Warning: screwed up code ahead. Proceed with causion.

    // check if there is a cookie.
    if( isset( $_COOKIE[ 'user' ] ) ){
        header('Location: /');
        exit();
    }

    $post = false;
    if( $_SERVER[ 'REQUEST_METHOD' ] == "POST" ){
        mysql_connect( 'localhost', 'Webseminars', 'd14c16c9afa5d58da62426fb5951ad7c' ) or die( mysql_error() );
        mysql_select_db( 'Webseminars' ) or die( mysql_error() );

        mysql_query( "SET NAMES UTF8;" );

        // Validate user
        $res = mysql_query( "SELECT * FROM Student WHERE student_login='" . mysql_real_escape_string( $_POST[ 'username' ] ) . "' AND student_password='" . mysql_real_escape_string( $_POST[ 'password' ] ) . "';" );
        if( mysql_num_rows( $res ) ){
            $student = mysql_fetch_object( $res );
            $token = md5( rand() );
            mysql_query( "UPDATE Student SET student_authtoken='" . $token . "' WHERE student_id='" . $student->student_id . "';" );
            setcookie( 'user', $student->student_id . '&' . $token, time() + 3600 * 24 * 30 * 12 ); // for a month
            header('Location: /');
            exit();
        }
        $post = true;
        mysql_close();
    }

    echo '<?xml version="1.0" encoding="utf-8"?>';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="el" lang="el">
    <head>
        <title>Web Seminar Assignment Dashboard</title>
        <link type="text/css" rel="stylesheet" href="css/global.css" />
    </head>
    <body>
        <form method="post" action="" class="login<?php
            if( $post ){
                ?> error<?php
            }
        ?>">
            <div>
                <input class="text" type="text" placeholder="Όνομα" name="username" />
                <input class="text" type="password" placeholder="Κωδικός" name="password" />
                <input type="submit" value="Είσοδος" />
            </div>
            <?php
            if( $post ){
              ?><p class="message">Τα στοιχεία που εισήγαγες είναι λανθασμένα.</p><?php
            }
            ?>
        </form>
    </body>
</html>