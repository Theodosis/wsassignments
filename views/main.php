<?='<?xml version="1.0" encoding="utf-8"?>'?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="el" lang="el">
    <head>
        <title>Web Seminar Assignment Dashboard</title>
        <link type="text/css" rel="stylesheet" href="../css/demo_table_jui.css" />
        <link type="text/css" rel="stylesheet" href="../css/demo_table.css" />
        <link type="text/css" rel="stylesheet" href="../css/style.css" />
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
                    <select name="assnum">
                        <option value="1" selected="selected">1</option>
                    </select>
                    <input type="submit" value="Δώσε!" />
                </fieldset>
            </form>
            <table>
                <thead>
                    <tr>
                        <th class="id">Id</th>
                        <th class="name">Όνομα</th>
                        <th class="lastname">Επίθετο</th>
                        <th class="email">e-mail</th>
                        <th class="assnum">Εργασία</th>
                        <th class="accepted">Δεκτή</th>
                        <th class="answered">Απαντήθηκε</th>
                        <th class="tools">Εργαλεία</th>
                    </tr>
                </thead>
                <tbody><?php
                    for( $i = 0; $i < 400; ++$i ){
                        ?><tr id="sub_<?=$i?>">
                            <td class="id"><?=$i?></td>
                            <td class="name">Θεοδόσης</td>
                            <td class="lastname">Σουργκούνης</td>
                            <td class="email">thsourg@gmail.com</td>
                            <td class="assnum">1</td>
                            <td class="accepted">
                                <span class="hidden">Yes</span>
                                <span class="yes selected">&#10003;</span>
                                <span class="no">&#215;</span>
                            </td>
                            <td class="answered">
                                <span class="hidden"></span>
                                <span class="yes">&#10003;</span>
                                <span class="no">&#215;</span>
                            </td>
                            <td class="tools">
                                <a href="" class="edit">edit</a>
                                <a href="" class="delete">delete</a>
                                <a href="" class="showcomments">Show Comments</a>
                            </td>
                        </tr><?php
                    }
                ?></tbody>
            </table>
        </div>
        <ul class="commentpanel">
            <li><strong>Ted</strong> Hey!</li>
            <li><strong>Ted</strong> Hey!</li>
            <li><strong>Ted</strong> Hey!</li>
        </ul>
        <script type="text/javascript" src="../javascript/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="../javascript/jquery-ui-1.8.16.custom.min.js"></script>
        <script type="text/javascript" src="../javascript/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../javascript/script.js"></script>
    </body>
</html>
