<?php
    require("./system.smarty.inc.php");
    require("./system.class.inc.php");
    $connobj = new ConnDB("mysql", "localhost", "root", "111", "do_database24");
    $conn = $connobj->GetConnld();
    $admindb = new AdminDB();
    $seppage = new SepPage();
    $usefun = new UseFun();
    $smarty = new SmartyProject();
    function unhtml($params){
        extract($params);
        $text = $content;
        global $usefun;
        return $usefun->UnHtml($text);
    }
    $smarty->register_function("unhtml", "unthml");
?>
