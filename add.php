<?php
include 'transactions.php';
$t = new Transactions();
$error=false;
if(isset($_POST['user']) && isset($_POST['type']) && isset($_POST['amount'])){
	$result = $t->addTransaction($_POST['user'], $_POST['type'], $_POST['amount']);
	if($result == "Ready"){
		header("Location: /index.php");
	}else{
		$error = $result;
	}
}
?>
<html>
<head>
    <title>Add</title>
    <style type="text/css">
        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }
        .error{
			color: #FF0000;
		}
    </style>
</head>
<body>
<h2>Transactions module</h2>
<?if($error):?><p class="error"><?=$error?></p><?endif;?>
<form method="POST">
<table>
	<tr>
		<th>User</th>
		<td><input type="text" name="user" value="<?=isset($_POST['user'])?$_POST['user']:""?>"></td>
	</tr>
	<tr>
		<th>Type</th>
		<td>
			<select name="type">
				<option value="">Select type...</option>
				<?foreach($t->types as $type):?>
					<option value="<?=$type?>" <?if(isset($_POST['type']) && $_POST['type'] == $type):?>selected<?endif;?>><?=$type?></option>
				<?endforeach;?>
			</select>
		</td>
	</tr>
	<tr>
		<th>Amount</th>
		<td><input type="text" name="amount" value="<?=isset($_POST['amount'])?$_POST['amount']:""?>"></td>
	</tr>
	<tr>
		<th></th>
		<td><input type="submit" value="Submit"></td>
	</tr>
</table>
</form>
<p><a href="index.php">Back</a></p>
</body>
</html>
