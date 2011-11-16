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
    if( $student->student_rights < 50 ){
        header('Location: /');
        exit();
    }

    $res = mysql_query(
    /*
        HELP NEEDED HERE!
        this query should return all submission results of each student for each assignment groupped by assignment.
        On each group we need the entry with the lowest validation_id.

        Example: students with ids 1 and 2, submitted 15 times for each assignment. The first one succeded on the first assignment,
        while the second did not.
        results:
        1, X, X, X, 0, 0, : The first one succeded in the first assignment
        1, X, X, X, 3, 1, : The first one did not succeed in the second assignment
        1, X, X, X, 4, 2, : The first one did not succeed in the third assignment
        2, Y, Y, Y, 2, 0, : The second student did not succeed in the first assignment
        2, Y, Y, Y, 6, 1, : The second student did not succeed in the second assignment
        2, Y, Y, Y, 5, 2, : The second student did not succeed in the third assignment

    */
    "SELECT * FROM (
            SELECT `a`.`student_id`,`a`.`student_name`,`a`.`student_lastname`,`a`.`student_mail`,`c`.`validation_id`,`c`.`validation_description`, `b`.`assignment_id`
            FROM student AS a
            CROSS JOIN submission AS b
                ON a.student_id=b.student_id
            CROSS JOIN validation_status as c
                ON b.validation_id=c.validation_id
            WHERE
                b.assignment_id=2
            ORDER BY b.validation_id ASC
            ) as query
        GROUP BY student_id
        ORDER BY student_id;"
    );
    $students = array();
    while( $row = mysql_fetch_object( $res ) ){
        $students[] = $row;
    }

    mysql_close();
    echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="el" lang="el">
    <head>
        <title>Web Seminar Assignment Dashboard</title>
        <link type="text/css" rel="stylesheet" href="media/css/demo_table.css" />
        <style tyle="text/css">
            table{
                width: 100%;
            }

        </style>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Όνομα</th>
                    <th>Επίθετο</th>
                    <th>e-mail</th>
                    <th>validation</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach( $students as $a ){
                    ?><tr><td><?php
                        echo $a->student_id;
                    ?></td><td><?php
                        echo $a->student_name;
                    ?></td><td><?php
                        echo $a->student_lastname;
                    ?></td><td><?php
                        echo $a->student_mail;
                    ?></td><td title="<?php
                        $all = explode( ' ', $a->validation_description );
                        $slice = array_slice( $all, 0, 8 );
                        $txt = implode( ' ', $slice );
                        echo $a->validation_description;
                    ?>"><?php
                        echo $txt;
                        if( sizeof( $all ) > sizeof( $slice ) ){
                            echo "...";
                        }
                    ?></td></tr><?php
                }
            ?>
            </tbody>
        </table>
        <script type="text/javascript" src="javascript/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="javascript/jquery.dataTables.min.js"></script>
        <script type="text/javascript">
            $( '#exit' ).click( function(){
                document.cookie = 'user=';
                window.location = '/login.php';
            });
            $( 'table' ).dataTable();
        </script>
    </body>
</html>
