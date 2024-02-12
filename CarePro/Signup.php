<?php
    include_once ('sql.php');
    $sql = new sql();
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
                        <h1>Signup page !</h1>
                        <p></p>

                        <form action="" method="post" novalidate>
                            <div>
                                <label for="Username">Username :</label>
                                <p></p>
                                <input type="text" id ="Username" name="Username">
                                <p></p>
                            </div>
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
                            <div>
                                <label for="retype_password">Retype password :</label>
                                <p></p>
                                <input type="password" id ="retype_password" name="retype_password">
                                <p></p>
                                <p></p>
                            </div>
                            <div>
                                <p></p>
                                <input type="checkbox" id="Termsandconditions" name="Termsandconditions" value="1">
                                <label for="Termsandconditions"> Agree to the <a href="Termsandconditions.php">terms and conditions</a></label><br>
                                <p></p> 
                                <button class="button1">Signup</button>
                            </div>

                        </form>
                    </div>
    
                    <div class="col">
                        <!-- col 3 -->
    
                    </div>
                </div>
            </div>
        </body>
    </html>

    <?php

        if (isset($_POST['Username'])) {
            if (empty($_POST['Username']))
            {
                echo ("Please enter a Username.");
            }
            elseif (strlen($_POST["Username"]) < 2)
            {
                echo ("Please enter a Username more that 2 characters.");
            }

            else
            {
                if (isset($_POST['email'])) {
                    if ($sql->checkEmail($_POST['email']) == "email exists") {
                        echo "email exists please use a different email";
                    }
                    else
                    {
                        if (! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
                        {
                            echo ("Please enter a real email.");     
                        }

                        else 
                        {
                            if (strlen($_POST["password"]) <= 8)
                            {
                                echo ("Your password is less than 8 characters.");

                            }
                            elseif (! preg_match("/[a-z]/i", $_POST["password"]))
                            {
                                echo ("Your password needs at least one character.");
                            }
                            elseif (! preg_match("/[0-9]/i", $_POST["password"]))
                            {
                                echo ("Your password needs at least one number.");
                            }

                            else
                            {
                                if ($_POST["password"] !== $_POST["retype_password"])
                                {
                                    echo ("Your password is was typed incorrectly.</font color>");
                                }
                                elseif (isset($_POST['Termsandconditions'])) 
                                {
                                    $sql->registerUser($_POST ['Username'], $_POST['email'], $_POST ['password']);
                                    header('Location: index.php');
                                }
                                else
                                {
                                    // Checkbox is not checked
                                    // Perform actions or logic for unchecked checkbox
                                    echo ('Please check the terms and conditions');
                                }
                            }
                        }
                    }
                }   
            }
        } 
    ?>