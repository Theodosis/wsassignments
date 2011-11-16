<?='<?xml version="1.0" encoding="utf-8"?>'?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="el" lang="el">
    <head>
        <title>Web Seminar Assignment Dashboard</title>
        <link type="text/css" rel="stylesheet" href="/wsass/css/global.css?1" />
    </head>
    <body>
        <form method="POST" action="/submission/create/" id="container" enctype="multipart/form-data">
            <h1>Web Seminar Dashboard</h1>
            <span id="exit" title="Έξοδος"></span>
            <?php 
                global $user;
            ?>
            <p>Καλωσήρθες στο σύστημα υποβολής εργασιών. Σε περίπτωση που επικοινωνήσεις μαζί μας, ανάφερέ μας το id σου: <?=$user[ 'id' ];?></p>
            <ul>
                <li>
                    <h2>Δεύτερη εργασία. </h2>
                    <div>Κατάσταση: <span>Δεν έχει αποσταλεί</span></div>
                </li>
                <li>
                    <h2>Τρίτη εργασία.</h2>
                    <input type="file" name="as3" />                    
                    <h3>Συνολικά Αποτελέσματα.</h3>
                    <div>Κατάσταση: <span>Η αποστολή της εργασίας ολοκληρώθηκε. Ευχαριστούμε για τη συμμετοχή σου. Σε περίπτωση απόρριψης θα σε ενημερώσουμε με email.</span></div>
                </li>
            </ul>
        </form>
        <script type="text/javascript" src="javascript/jquery-1.6.2.min.js"></script>
        <script type="text/javascript">
            $( 'input[type=file]' ).change( function(){
                $( 'form' ).submit();
            } );
            $( '#exit' ).click( function(){
                var form = document.createElement( 'form' );
                form.action = "/wsass/session/delete/";
                form.method = "POST";
                form.submit();
            });
        </script>
    </body>
</html>
