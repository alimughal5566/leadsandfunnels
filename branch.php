<?php
$instances = array("branch1"=>"hotfixes", "branch2"=>"zulfi", "branch3"=>"jaz", "branch4"=>"saif", "branch5"=>"branch5");

foreach($instances as $domain => $dir){
    $stringfromfile = file('/var/www/vhosts/branches/myleads.leadpops.com/'.$dir.'/.git/HEAD', FILE_USE_INCLUDE_PATH);
    $firstLine = $stringfromfile[0]; //get the string from the array
    $explodedstring = explode("/", $firstLine, 3); //seperate out by the "/" in the string
    $branchname = $explodedstring[2]; //get the one that is always the branch name
    echo "<h3>Connectd Branch (".$domain."): ".$branchname."</h3>";

    $currentHead = trim(substr(file_get_contents('/var/www/vhosts/branches/myleads.leadpops.com/'.$dir.'/.git/HEAD'), 4));
    echo $currentHead."<br /><br />";
}