<?php require("admin-header.php");

if (!(isset($_SESSION[$OJ_NAME.'_'.'administrator'])||
			isset($_SESSION[$OJ_NAME.'_'.'contest_creator'])
			)){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}
        if(isset($OJ_LANG)){
                require_once("../lang/$OJ_LANG.php");
        }

echo "<title>Suspect List</title>";
echo "<hr>";
echo "<center><h2>Suspect"."$MSG_LIST</h2></center>";

echo "<div class=\"container\">";
require_once("../include/set_get_key.php");
$contest_id=intval($_GET['cid']);
$sql="select * from (select count(distinct user_id) c,ip from solution where contest_id=? group by ip) suspect 
	inner join (select distinct ip,user_id from solution where contest_id=? ) u on suspect.ip=u.ip and suspect.c>1 order by c desc ,u.ip
       ";
$result=pdo_query($sql,$contest_id,$contest_id);
?>
<?php
echo "<center><table class='table table-striped' width=90% border=1>";
echo "<tr><td>IP<td>user<td>submission count<td>";
echo "</tr>";
foreach($result as $row){
        echo "<tr>";
        echo "<td>".$row['ip'];
        echo "<td><a href='../status.php?cid=$contest_id&user_id=".$row['user_id']."'>".$row['user_id']."</a>";
        echo "<td>".$row['c'];

        echo "</tr>";
}
echo "</table></center></div>";
require("../oj-footer.php");
?>