

<?php

include 'transactions.php';

$t = new Transactions();

?>

<html>
<head>
    <title>Summary</title>
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
<?php
$list = $t->getTop();
echo "<table style='border-width: 1px;'>";
echo "<tr><td>user</td><td>amount</td></tr>";
foreach ($list as $result) {
    echo "<tr><td>{$result['user']}</td><td>{$result['amount']}</td></tr>";
}
echo "</table>";

?>

<p><a href="index.php">Back</a></p>

</body>
</html>