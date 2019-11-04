

<?php

include 'transactions.php';

$t = new Transactions();

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

<?php
echo "<p>Transactions count: {$t->getCount()}</p>";

$list = $t->getList(50,0);
echo "<table style='border-width: 1px;'>";
echo "<tr><td>id</td><td>user</td><td>type</td><td>amount</td></tr>";
foreach ($list as $transaction) {
    echo "<tr><td>{$transaction['id']}</td><td>{$transaction['user']}</td><td>{$transaction['type']}</td><td>{$transaction['amount']}</td></tr>";
}
echo "</table>";

?>

</body>
</html>