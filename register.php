<?php 
    //php functions
    include __DIR__ . '../include/header.php';

    //initilize the variables
    $username = "";
    $password = "";
    $confirmpassword = "";
    $error = "";

    if (isset($_POST['addUser'])) {
       $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
       $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
       $confirmpassword = filter_input(INPUT_POST, 'confirmpassword', FILTER_SANITIZE_SPECIAL_CHARS);

       if ($username == "")
       {
         $error .= "Username is required<br>";
       }
       else if (strlen($username) < 3)
       {
         $error .= "Username must be at least 3 characters long<br>";
       }
       else if (strlen($username) > 50)
       {
         $error .= "Username must be less than 50 characters long<br>";
       }
       else if (!preg_match('/^[A-Za-z0-9@\/-]+$/',$username))
       {
         $error .= "Username must contain only letters, numbers, and @, /, - characters<br>";
       }

       if ($password == "")
       {
         $error .= "Password is required<br>";
       }
       else if (strlen($password) < 5)
       {
         $error .= "Password must be at least 5 characters long<br>";
       }
       else if (strlen($password) > 50)
       {
         $error .= "Password must be less than 50 characters long<br>";
       }
       else if (!preg_match('/^[A-Za-z0-9@\/-]+$/',$password))
       {
         $error .= "Password must contain only letters, numbers, and @, /, - characters<br>";
       }

        if ($confirmpassword == "")
        {
            $error .= "Confirm Password is required<br>";
        }
        else if ($password != $confirmpassword)
        {
            $error .= "Passwords do not match<br>";
        }

        if ($error == "" && userExists($username, $password)) {
            $error .= "User already exists<br>";
        }

        if ($error == "") {
            if (addUser($username, $confirmpassword)) {
                $_SESSION['isLoggedIn'] = true;
                $_SESSION['id'] = $db->lastInsertId();
                $_SESSION['username'] = $username;
                header('Location: view_players.php');
                exit();
            } else {
                $error = "Error adding user";
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScoutTheBest - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/5f5e4fa545.js" crossorigin="anonymous"></script>

    <!--My styles -->
    <style>
        html{
            overflow-x: hidden;
        }
        body{
            background-color: orange;
            background-size: cover;
            background-repeat: no-repeat;
            display: flex;
            flex-direction: column;
            min-height: 100vh; 
            overflow-x: hidden;
       }

       p{
            color: white;
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
            font-size: 24px;
            text-align: center;
            position: absolute;
            top: 10px;
        }

       .content{
            background-color: rgba(0, 0, 0, 0.7); 
            display:flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: auto;
            width: 500px; 
            height: 400px;
            border-radius: 20px;
            color: white;
            filter : drop-shadow(0 0 0.75rem white);
            flex: 1;
            overflow: visible;
            overflow-y: auto;
            overflow-x: hidden;
       }

       .buttons{
            display: flex;
            flex-direction: row;  
            margin-top: 30px;
       }

       .error{
            margin-top: 20px;
            display: flex;
            justify-content: center;
       }

       @media only screen and (max-width: 600px){
            .content{
                width: 300px;
            }

            p{
                font-size: 20px;
                position: absolute;
                top: 20px;
            }
            .rowContainer input{
                width: 200px;
            }
            .buttons{
                flex-direction: column;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .wrapper{
                margin-top: 30px;
                width: 95%;
            }

            .username{
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 10px;  
                margin-top: 150px;
            }
            
            #username{
                margin-top: 0 !important;  
            }

            .password, .confirm {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }

            .homebutton{
                width:120%;
                margin-bottom: 20px;
            }   

            .addbutton{
                margin-right:25px;
            }
            .addbutton input {
                width: 130%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <p>Please enter the following information to become a registered user</p>
            <div class="wrapper">
                <form method="post" class="form">
                    <div class="rowContainer username">
                        <label for="username">Username:</label>
                        <input type="text" name="username" id="username" style="margin-bottom: 20px; margin-top: 80px;" required>
                    </div>
                    <div class="rowContainer password">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" style="margin-bottom: 20px;" required>
                    </div>
                    <div class="rowContainer confirm">
                        <label for="confirmpassword">Confirm Password:</label>
                        <input type="password" name="confirmpassword" id="confirmpassword" required>
                    </div>
                    <?php if ($error): ?>
                        <div class="error alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    <div class="rowContainer buttons">
                        <div class="addbutton">
                            <input class="btn btn-primary" type="submit" name="addUser" value="Add User" style="color:white;"/>
                        </div>
                        <div class="homebutton">
                            <a href="view_players.php" class="btn btn-primary" style="color:white; margin-left:100px;">Back to Home</a>
                        </div>       
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
    //php functions
    include __DIR__ . '../include/footer.php';
?>