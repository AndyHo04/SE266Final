<?php
    ob_start();
    session_start();
    
    include __DIR__ . '/../functions/db.php';
    include __DIR__ . '/../functions/functions_users.php';


    if (isset($_POST['logout'])) {
        logout();
    }

   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScoutTheBest Header</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
        }
        header{
            width: 100%;
            height:100px;
            background-color: black;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            color: white;
            margin-bottom: auto;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        header h1{
            color: white;
            display: flex;
            align-items: center;
        }
        footer{
            width: 100%;
            height: 100px;
            background-color: black;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            margin-top: auto;
            text-align: center;

        }
        .intro{
            display: flex;
            justify-content: flex-start;
            align-items: center;
            
        }

        .hamburger{
            display: none;
            flex-direction: column;
            justify-content: space-around;
            width: 30px;
            height: 30px;
            cursor: pointer;
        }

        .nav-bar ul{
            display:flex;
        }

        .nav-bar ul li a{
            color: white;
            display: block;
            font-size: 20px;
            padding: 5px 10px;
            border-radius: 5px;
            transition: 0.2s; /*transition: effect;*/
            margin: 0 5px;
            text-decoration: none;
            list-style: none;
        }

       .nav-bar ul li a:hover{
            background-color: white;
            color: black;
        }
        .nav-bar ul li a.active{
            background-color: white;
            color: black;
        }

        .nav-bar ul li{
            list-style: none;
        }

        .btn-link{
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 0;
            font-size: 20px;
        }

        .footer-margin-top{
            margin-top: 50px;

        }
       

        @media only screen and (max-width: 1400px){
            header{
                padding: 0 50px;
            }

       
        }
        @media only screen and (max-width: 1200px){
            header{
                padding: 0 30px;
            }

            header h1{
                margin-top: 10px;
            }
            
        }
        @media only screen and (max-width: 1100px){
            header{
                padding: 0 25px;
            }

            header h1{
                margin-top: 15px;
            }
            
        }

        @media only screen and (max-width: 900px){
            header{
                padding: 0 20px;
            }
            header h1{
                margin-top: 30px;
            }
            .hamburger{
                display: block;
                cursor: pointer;
            }
            .hamburger .line{
                width: 30px;
                height: 3px;
                background-color: white;
                margin: 6px 0;
            }

            .nav-bar{
                height:0px;
                position: absolute;
                top: 100px;
                left: 0;
                right: 0;
                background-color: black;
                width: 100vw;
                transition: 0.5s;
                
            }

            .nav-bar.active{
                height: 400px;
                
            }
                header.overlap {
                margin-bottom: 450px; 
            }

            .nav-bar ul{
                display: block;
                width: fit-content;
                margin: 50px auto 0 auto;
                text-align: center;
                opacity: 0;
            }

            .nav-bar.active ul{
                opacity: 1;
                transition: 0.5s;
            }

            .nav-bar ul li{
                margin-bottom: 20px;
                margin-right:30px;
            }

            .first-row{
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .second-row{
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            
        }
        
    </style>
</head>

<body>
    <!--Navigation bar for every single page-->
    <header>
        <div class="intro">
            <img src="/ScoutTheBest/images/ball.webp" alt="ScoutTheBest ball" width="70px" height="70px">
            <h1 style="margin-left: 10px; margin-right:100px;">ScoutTheBest</h1>
        </div>
        <div class="hamburger">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <nav class="nav-bar">
            <ul>
                <li><a href="view_players.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']): ?>
                    <li><a href="profile.php">Manage Profile</a></li>
                    <li>
                        <form method="post" >
                            <a href="view_players.php"><button type="submit" name="logout" class="btn-link"style="text-decoration: none;">Logout</button></a>
                        </form>
                    </li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
