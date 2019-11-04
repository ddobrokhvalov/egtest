<?php

include 'transactions.php';

$t = new Transactions();
$tcount = $t->getCount();
$pagecount = ceil($tcount/50);
$pagenum = (isset($_GET["page"]) && intval($_GET["page"]))?intval($_GET["page"]):1;
$start = ($pagenum-1)*50;
?>
<html>
<head>
    <title>Main</title>
    <style type="text/css">
        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
<h2>Transactions module</h2>

<p><a href="summary.php">Summary report</a></p>
<p><a href="top.php">Top report</a></p>
<p><a href="add.php">Add transaction</a></p>

<?php
echo "<p>Transactions count: {$tcount}</p>";
$list = $t->getList(50,$start);
echo "<table style='border-width: 1px;'>";
echo "<tr><td>id</td><td>user</td><td>type</td><td>amount</td></tr>";
foreach ($list as $transaction) {
    echo "<tr><td>{$transaction['id']}</td><td>{$transaction['user']}</td><td>{$transaction['type']}</td><td>{$transaction['amount']}</td></tr>";
}
echo "</table>";
?>
<?

?>
<div class="paging">
	<a href="index.php">1</a> 
	- <a href="index.php?page=2">2</a>
	<?if($pagenum <= 4):?>
		- <a href="index.php?page=3">3</a>
		<?if($pagenum >= 3):?>- <a href="index.php?page=4">4</a><?endif;?>
		<?if($pagenum == 4):?>- <a href="index.php?page=5">5</a><?endif;?>
		... 
		
	<?elseif($pagecount - $pagenum <= 3):?>
		... 
		<?if($pagecount - $pagenum == 3):?><a href="index.php?page=<?=$pagecount-4?>"><?=$pagecount-4?></a> - <?endif;?>
		<?if($pagecount - $pagenum >= 2):?><a href="index.php?page=<?=$pagecount-3?>"><?=$pagecount-3?></a> - <?endif;?>
		<a href="index.php?page=<?=$pagecount-2?>"><?=$pagecount-2?></a> - 
	<?else:?>
		...
		<a href="index.php?page=<?=$pagenum-1?>"><?=$pagenum-1?></a>
		- <a href="index.php?page=<?=$pagenum?>"><?=$pagenum?></a>
		- <a href="index.php?page=<?=$pagenum+1?>"><?=$pagenum+1?></a>
		...
	<?endif;?>
	<a href="index.php?page=<?=$pagecount-1?>"><?=$pagecount-1?></a>
	- <a href="index.php?page=<?=$pagecount?>"><?=$pagecount?></a>
</div>
</body>
</html>
