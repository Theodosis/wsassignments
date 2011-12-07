<?php
    echo '<?xml version="1.0" encoding="utf-8"?>';
    global $settings;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="el" lang="el">
    <head>
        <title>Web Seminar Assignment Dashboard</title>
        <link type="text/css" rel="stylesheet" href="/css/global.css" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <form method="POST" action="/session/create" class="login<?php
            if( isset( $login ) ){
                ?> error<?php
            }
        ?>">
            <div>
                <input class="text" type="text" placeholder="Όνομα" name="username" />
                <input class="text" type="password" placeholder="Κωδικός" name="password" />
                <input type="submit" value="Είσοδος" />
            </div>
            <?php
            if( isset( $login ) ){
              ?><p class="message">Τα στοιχεία που εισήγαγες είναι λανθασμένα..</p><?php
            }
            ?>
        </form>
    </body>
</html>
