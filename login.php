<?php
require 'config.php';

if ( isset( $_POST['email'])) {
    $email = $_POST['email'];

    // query user info
    $sql = "SELECT id, email FROM `users` WHERE email = '$email' ";
    $stmt = $db->query($sql);

    // if user exist, then login
    // else insert a new user
    if ($stmt->rowCount() == 1) {
        // login a new user
        $row = $stmt->fetch();
        $_SESSION['user'] = [
            'id' => $row['id'],
            'email'=> $row['email']
        ];
        // redirect to wallet
        header('Location:index.php');
    } else {
        // insert a new user
        $sql = "INSERT INTO `users` (`email`) VALUES('$email')";
        $stmt = $db->query($sql);

        if ( $stmt) {
            $_SESSION['user'] = [
                'id' => $db->lastInsertId(),
                'email' => $email
            ];
            
            // create user wallet
            $user = $_SESSION['user']['id'];
            $sql = "INSERT INTO `wallets` (`user`, `amount`) VALUES($user, '0.00')";
            $stmt = $db->query($sql);

            // redirect to wallet
            header('Location:index.php'); 
        } else {
            die ('Error. Contact the developer');
        }
    }
}
?>

<form action="login.php" method="post">
    <label>Email</label>
    <input type="text" name="email" id="email">
    <button type="submit">Login</button>
</form>

