<?php
    // tHE PHP FUNCTION TO GET THE PLAYERS
    include __DIR__ . '../include/header.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScoutTheBest - About</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/5f5e4fa545.js" crossorigin="anonymous"></script>
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

        h2{
            color: white;
            display: flex;
            justify-content: center;
            font-size: 60px;
            text-align: center;
            align-items: center;
            margin-bottom: 50px;
        }

        p{
            color: white;
            display: flex;
            font-size: 24px;
            text-align: center;
            align-items: center;
            margin-top: 50px;
            margin-right: 10px;
            margin-left:10px;
        }

        .balls{
            display: flex;
            justify-content: space-around;


        }

       .content{
            background-color: rgba(0, 0, 0, 0.7); 
            display:flex;
            flex-direction: column;
            justify-content: center;
            margin-left: -50px; 
            width: 1400px; 
            height: 450px;
            border-radius: 20px;
            color: white;
            filter : drop-shadow(0 0 0.75rem white);
            flex: 1;
            overflow: visible;
            overflow-y: auto;
            overflow-x: hidden;
       }


    
        @media only screen and (max-width: 1400px){
           .content{
                width: 1000px;
                margin-left: 40px;
           }
       
        }

        @media only screen and (max-width: 1200px){
            
           .content{
                width: 900px;
                margin-left: 20px;
           }
           p{
                font-size: 20px;
           }
           
        }

        @media only screen and (max-width: 992px){
            .content{
                width: 600px;
                margin-left: 60px;

            }
            h2{
                font-size: 40px;
                margin-top: 30px;
            }

       
        }
        @media only screen and (max-width: 768px){
            .content{
                width: 400px;
                margin-left: 80px;
            }
            h2{
                font-size: 30px;
                margin-bottom: 10px;
                margin-top: 50px;
            }
            .ball2{
                display: none;
            }
            .ball4{
                display: none;
            }
            .balls{
                font-size: 1rem;
            }
       
        }

        @media only screen and (max-width: 600px){
            .content{
                width: 300px;
                margin-left:100px;
            }
            h2{
                font-size: 25px;
                margin-bottom: 10px;
                margin-top: 100px;
            }
            .ball2{
                display: none;
            }
            .ball4{
                display: none;
            }
            .balls{
                font-size: 0.8rem;
            }
        }

       

    </style>


</head>
<body>
    <div class="container">
        <div class="content">
            <h2>About ScoutTheBest</h2>
            <div class="balls">
                 <i class="fa-solid fa-basketball fa-4x"></i>
                 <i class="ball2 fa-solid fa-basketball fa-4x"></i>
                 <i class="fa-solid fa-basketball fa-4x"></i>
                 <i class="ball4 fa-solid fa-basketball fa-4x"></i>
                 <i class="fa-solid fa-basketball fa-4x"></i>
            </div>
            <div>
                <p>ScoutTheBest is a platform that allows you to scout the best basketball players in the world. Players from middle school high school, college, professional, and even your local rec leagueYou can view the players, add new players, update player information and delete players. You can also view the player's profile and see their stats. </p>
            </div>       
        </div>
    </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
</body>
</html>
<?php include __DIR__ . '../include/footer.php'?>