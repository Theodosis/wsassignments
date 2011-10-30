<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="el" lang="el">
    <head>
        <title>Web Seminar Assignment Dashboard</title>
        <link type="text/css" rel="stylesheet" href="/css/style.css" />
    </head>
    <body>
        <div id="topbar">
            <h1>Web Seminar Homework Dashboard</h1>
            <div class="hello">Hello, <a href="">stranger</a></div>
        </div>
        <div id="main">
            <form method="post" action="action/create">
                <fieldset>
                    <input type="text" name="firstname" placeholder="Όνομα" />
                    <input type="text" name="lastname" placeholder="Επίθετο" />
                    <input type="text" name="email" placeholder="email" />
                    <input type="submit" value="Δώσε!" />
                </fieldset>
            </form>
            <div class="tools">
                
            </div>
            <table>
                <tr>
                    <th>Id</th>
                    <th>Όνομα</th>
                    <th>Επίθετο</th>
                    <th>e-mail</th>
                    <th>E1</th>
                </tr>
                <tr id="sub_1">
                    <td>1</td>
                    <td>Θεοδόσης</td>
                    <td>Σουργκούνης</td>
                    <td>thsourg@gmail.com</td>
                    <td>
                        <span class="correct qm">?</span>
                        <span class="answered no">X</span>
                    </td>
                </tr>
            </table>
        </div>
        <script type="text/javascript" src="/javascript/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="/javascript/jquery-ui-1.8.16.custom.min.js"></script>
        <script type="text/javascript" src="/javascript/script.js"></script>
        
    </body>
</html>
