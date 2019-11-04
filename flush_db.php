<?php

include 'config.php';

$mysql = new \mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($mysql->connect_errno) {
    echo "Connection failed\n";
    echo "Error: " . $mysql->connect_error . "\n";
    die();
}

if (!$mysql->query("DROP TABLE IF EXISTS `egtest`.`testdata`;")) {
    echo "Drop table failed\n";
    echo "Error: " . $mysql->error . "\n";
    //die();
}

$sql = "CREATE TABLE IF NOT EXISTS `egtest`.`testdata` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user` VARCHAR(45) NOT NULL,
    `type` VARCHAR(45) NOT NULL,
    `amount` INT NOT NULL,
    PRIMARY KEY (`id`));";

if (!$mysql->query($sql)) {
    echo "Create table failed\n";
    echo "Error: " . $mysql->error . "\n";
    //die();
}

// insert 10 000 000 records
$types = ['deposit','withdraw','bet','win'];
for ($t = 1; $t<100; $t++) {

    $values = [];

    for ( $i = 1; $i < 100000; $i ++ ) {
        $amount   = rand( 1, 1000 );
        $user     = 'user' . rand( 1, 50 );
        $values[] = "('{$user}','{$types[rand(0,3)]}',{$amount})";
    }

    $query = "INSERT INTO testdata (user,type,amount) VALUES " . implode( ',', $values );

    if ( ! $mysql->query( $query ) ) {
        echo "INSERT failed\n";
        echo "Error: " . $mysql->error . "\n";
        die();
    }

    $values = null;

}
echo "Database ready\n";

$mysql->close();

die();
