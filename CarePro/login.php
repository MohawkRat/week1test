<?php
include_once("sql.php");
$sql = new sql();
if (isset($_POST['email'])) {
    if (empty($_POST['email'])) {
        $response = "Please enter an email.";
    } else {
        if (empty($_POST['password'])) {
            $response = "Please enter a password.";
        } else {
            $loggedIn = $sql->login($_POST['email'], $_POST['password']);
            if ($loggedIn) {
                $response = "Successfully logged in";
                header('Location: index.php');
            } else {
                $response = "Incorrect email/password. If you need an account you can sign up <a href='Signup.php'>here</a>";
            }
        }
    }
}

?>

<!DOCTYPE html>
    <html>
        <head>
            <title>CarePro</title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        </head>
        <body>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
        <?php include_once('navbar.php');?>
            <div class="container text-center">
                <div class="row">
                    
                    <div class="col">
                        <!-- col 1 -->
                    </div>
    
                    <div class="col">
                        <!-- col 2 -->
                        <p></p>
                        <h1>Login page !</h1>
                        <p></p>

                        <form action="" method="post" novalidate>
                            <div>
                                <label for="email">Email :</label>
                                <p></p>
                                <input type="email" id ="email" name="email">
                                
                                <p></p>
                            </div>
                            <div>
                                <label for="password">Password :</label>
                                <p></p>
                                <input type="password" id ="password" name="password">
                                <p></p>
                            </div>
                            <button class="button1" style='border-radius: 30px;'>Login</button>
                        </form>
                        <p name="login"><?php if (isset($response)) {echo $response;} ?></p>
                        <p style='text-align: center;'>If you need an account you can sign up <a href='Signup.php'>here</a></p>
                    </div>
    
                    <div class="col">
                        <!-- col 3 -->
    
                    </div>
                </div>
            </div>
        </body>
    </html>
