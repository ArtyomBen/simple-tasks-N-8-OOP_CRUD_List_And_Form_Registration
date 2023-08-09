<?php
require '../model/user.php';
session_start();
$user = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : new user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="../libs/bootstrap.css">
    <style type="text/css">
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Register</h2>
                </div>
                <p>Please fill this form and submit to register a new user.</p>
                <form action="../index.php?model=user&act=register" method="post"> <?php #"../index.php?model=user&act=register"?>
                    <div class="form-group <?= (!empty($user->username_msg)) ? 'has-error' : ''; ?>">
                        <label>Username</label>
                        <span class="help-block"><?= $user -> repeatUsername_msg ?></span>
                        <input type="text" name="username" class="form-control"
                               value="<?= $user->username; ?>">
                        <span class="help-block"><?php echo $user->username_msg; ?></span>
                    </div>
                    <div class="form-group <?= (!empty($user->password_msg)) ? 'has-error' : ''; ?>">
                        <label>Password</label>
                        <input name="password" type="password" class="form-control" value="<?php echo $user->password; ?>">
                        <span class="help-block"><?= $user->password_msg; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($user->repeat_password_msg)) ? 'has-error' : ''; ?>">
                        <label>Repeat Password</label>
                        <input name="repeat_password" type="password" class="form-control" value="<?php echo $user->repeat_password; ?>">
                        <span class="help-block"><?php echo $user->repeat_password_msg; ?></span>
                    </div>
                    <input type="submit" name="addbtn" class="btn btn-primary" value="Submit">
                    <a href="../index.php" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>