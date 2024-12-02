<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScoutTheBesr - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/5f5e4fa545.js" crossorigin="anonymous"></script>
    <style>
        body{
            background-image: url("images/bbcourt.jpg");
            background-size: cover;
            background-repeat: no-repeat;
        }
        .login{
            background-color: rgba(0, 0, 0, 0.7); /* Use rgba for semi-transparent background */
            display:flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin:auto;
            margin-top: 150px;
            width: 500px;
            height: 400px;
            border-radius: 20px;
            color: white;
            filter : drop-shadow(0 0 0.75rem white);
        }

        .login h1{
            display: flex;
            justify-content: center;
            margin-bottom: -10px;
            margin-top: 20px;
        }

        label{
            color: white;
            display: flex;
            justify-content: center;
        }

        .rowContainer{
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }   

        .rowContainer input{
            width: 300px;
        }
        .rowContainer button{
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        p{
            color: white;
            display: flex;
            justify-content: center;
        }
        a{
            color: white;
        }
        .error{
            color: red;
            display: flex;
            justify-content: center;
        }

        @media only screen and (max-width: 1200px){
            .login{
                margin-bottom: 100px;
            }
            
        }

        @media only screen and (max-width: 900px){
            .login{
                margin-bottom: 100px ;
                margin-right: 10px;
            }
            
        }

        .fa-solid.fa-eye{
            color: white;
        }

        .fa-solid.fa-eye:hover{
            cursor: pointer;
        }

        .password-show{
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            margin-left: 20px;
        }
    </style>
</head>
<?php
include __DIR__ . '/functions/functions_users.php';
include __DIR__ . '/functions/db.php';

session_start();
$_SESSION['isLoggedIn'] = false;
$_SESSION['username'] = '';
$error = '';

if(isset($_POST["login"])){
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

    if(login($username, $password)){
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['username'] = $username;
        header('Location: view_players.php');
        exit();
    } else {
        $error = 'Invalid username or password';
    }
}

?>

<body>
    <div class="container">
        <form method="post">
            <div class="login">  
                <h1>Login</h1>
                <br>
                <div>
                    <div class="rowContainer mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="enter username" required>
                    </div>
                    <div class="rowContainer mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="password-show">
                            <input type="password" class="form-control" id="password" name="password" placeholder="enter password" required>
                            <div>
                                &nbsp;
                            </div>
                            <i class="fa-solid fa-eye"></i>
                        </div>
                    </div>
                    <?php
                        if ($error != "") {
                    ?>
                    <div class="error"><?php echo $error; ?></div>
                    <?php
                        }
                    ?>
                    <div class="rowContainer">
                        <button type="submit" name="login" value="login" class="btn btn-primary">Login</button>
                        <br>
                        <p>Don't have an Account? <a href="register.php" style="margin-left: 5px;">Register</a></p>
                        <a href="view_players.php" style="margin-left: 5px; margin-bottom: 30px;">Home</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        //allows user to see password
        const password = document.getElementById('password');
        const eye = document.querySelector('.fa-solid.fa-eye');

        eye.addEventListener('click', function(){
            if(password.type === 'password'){
                password.type = 'text';
            } else {
                password.type = 'password';
            }
        });
    </script>
</body>
</html>