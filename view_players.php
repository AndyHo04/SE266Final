<?php
    // tHE PHP FUNCTION TO GET THE PLAYERS
    include __DIR__ . '../include/header.php';
    include __DIR__ . '../functions/function_players.php';


    $players = getPlayers();

    $name = "";
    $age = "";
    $position = "'";
    $stars = "";

    if (isset($_POST['searchPlayer'])) {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $age = filter_input(INPUT_POST, 'age', FILTER_SANITIZE_SPECIAL_CHARS);
        $position = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_SPECIAL_CHARS);
        $stars = filter_input(INPUT_POST, 'stars', FILTER_SANITIZE_SPECIAL_CHARS);

        $players = searchPlayer($name, $age, $position, $stars);
    }
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScoutTheBesr - View Players</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!--My styles -->
    <style>
       body{
        background-color: orange;
        background-size: cover;
        background-repeat: no-repeat;
        display: flex;
        flex-direction: column;
        min-height: 100vh; 
        margin: 0;        
       }

       h1{
        color: white;
       }

       .content{
            background-color: rgba(0, 0, 0, 0.7); 
            display:flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin:auto;
            width: 80%; 
            max-height: 450px; 
            border-radius: 20px;
            color: white;
            filter : drop-shadow(0 0 0.75rem white);
            overflow: auto; 
            flex: 1;
       }


       .wrapper{
            width:95%;
            display: flex;
            padding: 1rem;
            background-color: rgba(248, 111, 0, 0.8);
            align-items: center;
            justify-content: space-between;
            border-radius: 20px;
            margin-left:30px;
       }

       .table-container {
            width: 100%; 
            overflow-x: auto; 
            display: flex;
            justify-content: center;

        }

       .table {
            width: 90%;
            table-layout:fixed;
            word-wrap: break-word; 
        }

        .table th, 
        .table td {
            padding: 10px;
            text-align: center;
        }

        th,td {
            word-wrap: break-word;
        }
        .content table{
            overflow-y: auto;
        }

        .table a {
            color: white;
            text-decoration: none;
        }
        /* Custom colors for table-danger and table-primary */
        .table-danger {
            background-color: #dc3545 !important; /* Darker red */
        }

        .table-primary {
            background-color: #007bff !important; /* Darker blue */
        }

        .addbutton{
            margin-top: 24px;
            padding: 0.25rem;
            line-height: 14px;
        }


        /*Responsive design */  
        @media only screen and (max-width: 1200px){
            .content{
                width: 80%; 
                max-height: 350px; 
            }
            .wrapper{
                width: 100%;
                display: flex;
                padding: 1rem;
                background-color: rgba(248, 111, 0, 0.8);
                align-items: center;
                justify-content: space-between;
                border-radius: 20px;
                margin-left:0px;
            }
            
        }
        
    </style>

</head>
<body>
    <div class="container">
       <div class="content">
       <h1>Welcome <?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) :''; ?></h1>
        <!--The table that will show the records-->
        <form method="POST" name="searchPlayer">
           <div class="wrapper">
                <div class="form-group">
                    <div class="label">
                        <label for="nameid" style="color: white;">Name:</label>
                    </div>
                     <div>
                        <input type="text" id="nameid" name="name" class="form-control" />
                    </div>
                </div>
                <div>
                    &nbsp;
                </div>
                <div class="form-group">
                    <div class="label">
                        <label for="ageid" style="color: white;">Age:</label>
                    </div>
                    <div>
                        <input type="number" id="ageid" name="age" class="form-control" />
                    </div>
                </div>
                <div>
                    &nbsp;
                </div>
                <div class="form-group">
                    <div class="label">
                        <label for="positionid" style="color: white;">Position:</label>
                    </div>
                    <div>
                        <input type="text" id="positionid" name="position" class="form-control" />
                    </div>
                </div>
                <div>
                    &nbsp;
                </div>
                <div class="form-group">
                    <div class="label">
                        <label for="starsid" style="color: white;">Stars:</label>
                    </div>
                    <div>
                        <input type="number" id="starsid" name="stars" class="form-control" />
                    </div>
                </div>
                <div>
                    &nbsp;
                </div>
                <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']): ?>
                   <a href="addPlayer.php?Action=Add" class="addbutton btn btn-primary" style="color:white;">Add Player</a>
                <?php endif; ?>
                <div>
                    &nbsp;
                </div>
                <div>
                    <input class="btn btn-primary" type="submit" name="searchPlayer" value="Search" style="margin-top: 1.5rem; color:white;"/>
                    
                 </div>  

            </div>
        </form>
        <div>
             &nbsp;
        </div>
        <div class="table-container">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Position</th>
                        <th>Team</th>
                        <th>Height</th>
                        <th>Stars</th>
                        <th>View</th>
                        <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']): ?>
                            <th>Edit</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($players as $players): ?>
                        <tr>
                            <td class="table-danger" style="color: white;"><?= $players['name'] ?></td>
                            <td class="table-primary" style="color: white;"><?= $players['age'] ?></td>
                            <td class="table-danger" style="color: white;"><?= $players['position'] ?></td>
                            <td class="table-primary" style="color: white;"><?= $players['team'] ?></td>
                            <td class="table-danger" style="color: white;"><?= $players['height'] ?></td>
                            <td class="table-primary" style="color: white;"><?= $players['stars'] ?></td>
                            <td class="table-danger"><a href="addPlayer.php?Action=View&PlayerName=<?= $players['name']; ?>">View</a></td>
                            <?php if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']): ?>
                                <td class="table-primary"><a href="addPlayer.php?Action=Edit&PlayerName=<?= $players['name']; ?>">Edit</a></td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
       </div>
    </div>
      

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>
<?php include __DIR__ . '../include/footer.php'?>