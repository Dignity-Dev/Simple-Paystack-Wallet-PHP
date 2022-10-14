<?php
require 'config.php';

if ( !isset( $_SESSION['user'])) {
    header('Location:login.php');
}

$user = $_SESSION['user']['id']; // user id
$sql = "SELECT amount FROM `wallets` WHERE user = $user "; // stmt
$stmt = $db->query($sql); // query amount
$wallet = $stmt->fetch();

?>

<h1><?php echo $wallet['amount']; ?></h1>

<form action="fund.php" method="post">
    <input type="text" name='amount' placeholder='Amount'>
    <button type="submit"> Fund Wallet</button>
</form>