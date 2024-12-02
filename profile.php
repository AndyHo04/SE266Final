<?php 
    //php functions
    include __DIR__ . '../include/header.php';

    //initilize the variables
    $username = "";
    $password = "";
    $newpassword = "";
    $cnewpassword = "";
    $error = "";

     // Ensure the session ID exists
     if (!isset($_SESSION['id'])) {
        $error = "User ID not found in session. Please log in again.";
    } else {
        // Get the current user's details from the session
        $id = $_SESSION['id'];
        $user = getUser($id);

        $username = $user['username'];
        $password = $user['password'];
        
    }

    if (isset($_POST['updateUser']))
    {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
        $newpassword = filter_input(INPUT_POST, 'newpassword', FILTER_SANITIZE_SPECIAL_CHARS);
        $cnewpassword = filter_input(INPUT_POST, 'cnewpassword', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($username == "")
        {
            $error .= "Username is required<br>";
        }
        else if (strlen($username) < 4)
        {
            $error .= "Username must be at least 4 characters long<br>";
        }
        else if (strlen($username) > 50)
        {
            $error .= "Username must be less than 50 characters long<br>";
        }
        else if (!preg_match('/^[A-Za-z0-9@\/-]+$/',$username))
        {
            $error .= "Username must contain only letters, numbers, and @, /, - characters<br>";
        }

        if ($newpassword == "")
        {
            $error .= "New Password is required<br>";
        }
        else if (strlen($newpassword) < 5)
        {
            $error .= "New Password must be at least 5 characters long<br>";
        }
        else if (strlen($newpassword) > 50)
        {
            $error .= "New Password must be less than 50 characters long<br>";
        }
        else if (!preg_match('/^[A-Za-z0-9@\/-]+$/',$newpassword))
        {
            $error .= "New Password must contain only letters, numbers, and @, /, - characters<br>";
        }

        if ($cnewpassword == "")
        {
            $error .= "Confirm New Password is required<br";
        }else if ($newpassword != $cnewpassword)
        {
            $error .= "Passwords do not match<br>";
        }

        if ($error == "")
        {
            if (updateUser($username, $cnewpassword))
            {
                header('Location: view_players.php');
                exit();
            }
            else
            {
                $error = "Error updating user";
            }
        }
      
    }
    if (isset($_POST['deleteUser']))
    {
        if (deleteUser($id))
        {
            $_SESSION['isLoggedIn'] = false;
            $_SESSION['username'] = '';
            header('Location: view_players.php');
            exit();
        }
        else
        {
            $error = "Error deleting user";
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
            justify-content: center;
       }

       .error{
            margin-top: 20px;
            display: flex;
            justify-content: center;
       }
       .fa-solid.fa-eye{
            color: white;
            margin-left: 10px;
        }

        .fa-solid.fa-eye:hover{
            cursor: pointer;
        }
        .password-row {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            margin-bottom: 20px;
        }

        .password-row label {
            flex-shrink: 0;
            white-space: nowrap;
        }

        .password-input-container {
            flex-grow: 1;
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-input-container input {
            width: 100%;
            padding-right: 30px;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            color: white;
            cursor: pointer;
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

            .password-row {
                flex-direction: column;
                align-items: center;
                gap: 5px;
                
            }

            .homebutton{
                margin-right: 20px;
            }

            .buttons {
                display: flex;
                flex-direction: column; /* Stack the buttons vertically */
                align-items: center;
                gap: 10px; /* Add space between buttons */
            }
           
            .deletebutton {
                margin-right: 35px; /* Ensure the button aligns properly */
            }

            .updatebutton input,
            .deletebutton input {
                width: 100%; /* Reduce the button width */

            }

            .new {
                margin-left: 35px; /* Add space between the password fields and the buttons */
            }
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <p>This is your Profile</p>
            <div class="wrapper">
                <form method="post" class="form">
                    <div class="rowContainer username">
                        <label for="username">Username:</label>
                        <input type="text" name="username" id="username" style="margin-bottom: 20px; margin-top: 80px;" value="<?php echo htmlspecialchars($username); ?>">
                    </div>
                    <div class="rowContainer password">
                        <div class="password-row">
                            <label for="password">Current Password:</label>
                            <div class="password-input-container">
                                <input type="password" name="password" id="password" value="<?php echo htmlspecialchars($password); ?>">
                            </div>
                            <i class="fa-solid fa-eye"></i>
                        </div>
                    </div>
                    <div class="new">
                        <div class="rowContainer">
                            <label for="newpassword">New Password:</label>
                            <input type="password" name="newpassword" id="newpassword">
                        </div>
                        <div class="rowContainer" style="margin-top: 20px;">
                            <label for="cnewpassword">Confirm New Password:</label>
                            <input type="password" name="cnewpassword" id="cnewpassword">
                        </div>
                    </div>
                    <?php if ($error): ?>
                        <div class="error alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    <div class="rowContainer buttons">
                        <div class="updatebutton">
                            <input class="btn btn-success" type="submit" name="updateUser" value="Update User" style="color:white;"/>
                        </div>   
                        <div class="deletebutton">
                            <input class="btn btn-danger" type="submit" name="deleteUser" value="Delete User" style="color:white; margin-left:20px;"/>
                        </div>  
                        <div class="homebutton">
                            <a href="view_players.php" class="btn btn-primary" style="color:white; margin-left:20px;">Back to Home</a>
                        </div>  
                    </div> 
                </form>
            </div>
        </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
    //php functions
    include __DIR__ . '../include/footer.php';
?>