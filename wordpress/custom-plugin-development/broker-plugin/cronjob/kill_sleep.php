<?php

require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))). DIRECTORY_SEPARATOR. 'wp-load.php');

    global $objDB;

    $sql = " SELECT * FROM information_schema.processlist where `Command` = 'Sleep'";

    $rs = $objDB->query($sql);
    
    $cntTotal = 0;

    while($rs->next_record())
    {
        $sql = " KILL ".$rs->f('ID');

        $kill = $objDB->query($sql);

        $cntTotal++;
    }

    echo " KILLED MYSQL SLEEP QUERIES: ".$cntTotal;

    exit();
?>