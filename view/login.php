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
                    <h2>Login</h2>
                </div>
                <p>Please fill this form and submit to login.</p>
                <form action="../index.php?model=user&act=login" method="post">
                    <div class="form-group <?php echo (!empty($user->username_msg)) ? 'has-error' : ''; ?>">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control"
                               value="<?php echo $user->username; ?>">
                        <span class="help-block"><?php echo $user->username_msg; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($user->password_msg)) ? 'has-error' : ''; ?>">
                        <label>Password</label>
                        <input name="password" type="password" class="form-control" value="<?php echo $user->password; ?>">
                        <span class="help-block"><?php echo $user->password_msg; ?></span>
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