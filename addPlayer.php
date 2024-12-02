<?php
    // tHE PHP FUNCTION TO GET THE PLAYERS
    include __DIR__ . '../include/header.php';
    include __DIR__ . '../functions/function_players.php';

    //initialize the variables
    $name = "";
    $age = "";
    $position = "";
    $team = "";
    $height = "";
    $weight = "";
    $stars = "";
    $skills_rating = "";
    $potential_rating = "";
    $athletism_rating = "";
    $game_iq = "";
    $error = "";

    if(isset($_POST['name'])){
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $age = filter_input(INPUT_POST, 'age', FILTER_SANITIZE_SPECIAL_CHARS);
        $position = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_SPECIAL_CHARS);
        $team = filter_input(INPUT_POST, 'team', FILTER_SANITIZE_SPECIAL_CHARS);
        $height = filter_input(INPUT_POST, 'height', FILTER_SANITIZE_SPECIAL_CHARS);
        $weight = filter_input(INPUT_POST, 'weight', FILTER_SANITIZE_SPECIAL_CHARS);
        $stars = filter_input(INPUT_POST, 'stars', FILTER_SANITIZE_SPECIAL_CHARS);
        $skills_rating = filter_input(INPUT_POST, 'skills_rating', FILTER_SANITIZE_SPECIAL_CHARS);
        $potential_rating = filter_input(INPUT_POST, 'potential_rating', FILTER_SANITIZE_SPECIAL_CHARS);
        $athletism_rating = filter_input(INPUT_POST, 'athletism_rating', FILTER_SANITIZE_SPECIAL_CHARS);
        $game_iq = filter_input(INPUT_POST, 'gameiqid', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($name == "")
        {
            $error .= "Name is required<br>";
        }elseif(!preg_match("/^[a-zA-Z-' ]*$/", $name)){
            $error .= "Name - Only letters and white space allowed<br>";
        }

        if ($age == "")
        {
            $error .= "Age is required<br>";
        }elseif(!is_numeric($age)){
            $error .= "Age must be a number<br>";
        }

        if ($position == "")
        {
            $error .= "Position is required<br>";
        }else if (strlen($position) > 5){
            $error .= "Position must be less than 5 characters long<br>";
        }
        elseif(!preg_match('/^[A-Za-z\/]+$/', $position)){
            $error .= "Position - Only letters, /, and white space allowed<br>";
        }

        if ($team == "")
        {
            $error .= "Team is required<br>";
        }elseif(!preg_match('/^[A-Za-z\s]+$/', $team)){
            $error .= "Team - Only letters and white space allowed<br>";
        }

        if ($height == "")
        {
            $error .= "Height is required<br>";
        }elseif(!preg_match('/^[A-Za-z0-9\/-]+$/',$height)){
            $error .= "Height must be formated like ex). 6-4 <br>";
        }

        if ($weight == "")
        {
            $error .= "Weight is required<br>";
        }elseif(!is_numeric($weight)){
            $error .= "Weight must be a number<br>";
        }

        if ($stars == "")
        {
            $error .= "Stars is required<br>";
        }elseif(!is_numeric($stars)){
            $error .= "Stars must be a number<br>";
        }elseif($stars < 1 || $stars > 5){
            $error .= "Stars must be between 1 and 5<br>";
        }


        if ($skills_rating == "")
        {
            $error .= "Skills Rating is required<br>";
        }elseif(!is_numeric($skills_rating)){
            $error .= "Skills Rating must be a number<br>";
        }

        if ($potential_rating == "")
        {
            $error .= "Potential Rating is required<br>";
        }elseif(!is_numeric($potential_rating)){
            $error .= "Potential Rating must be a number<br>";
        }

        if ($athletism_rating == "")
        {
            $error .= "Athletism Rating is required<br>";
        }elseif(!is_numeric($athletism_rating)){
            $error .= "Athletism Rating must be a number<br>";
        }

        if ($game_iq == "")
        {
            $error .= "Game IQ is required<br>";
        }elseif(!is_numeric($game_iq)){
            $error .= "Game IQ must be a number<br>";
        }

        if ($error == ""){
            if (isset($_POST['addPlayer'])){
                if (addPlayer($name, $age, $position, $team, $height, $weight, $stars, $skills_rating, $potential_rating, $athletism_rating, $game_iq)){
                    header('Location: view_players.php');
                    exit();
                } else {
                    $error = "Error adding player";
                }
            } elseif (isset($_POST['updatePlayer'])){
                if (updatePlayer($name, $age, $position, $team, $height, $weight, $stars, $skills_rating, $potential_rating, $athletism_rating, $game_iq)){
                    header('Location: view_players.php');
                    exit();
                } else {
                    $error = "Error updating player";
                }
            } elseif (isset($_POST['deletePlayer'])){
                if (deletePlayer($name)){
                    header('Location: view_players.php');
                    exit();
                } else {
                    $error = "Error deleting player";
                }
            }
        }

    }
    if (isset($_GET['Action'])) {
        $action = filter_input(INPUT_GET, 'Action', FILTER_SANITIZE_SPECIAL_CHARS);
        $playername = filter_input(INPUT_GET, 'PlayerName', FILTER_SANITIZE_SPECIAL_CHARS);

        $player = getPlayer($playername);
        if ($player) {
            $name = $player['name'];
            $age = $player['age'];
            $position = $player['position'];
            $team = $player['team'];
            $height = $player['height'];
            $weight = $player['weight'];
            $stars = $player['stars'];
            $skills_rating = $player['skills_rating'];
            $potential_rating = $player['potential_rating'];
            $athletism_rating = $player['athletism_rating'];
            $game_iq = $player['game_iq'];
        }
        
    } 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScoutTheBest Add Player</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
            font-size: 48px;
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

       .first-row{
            display: flex;
            justify-content: space-between;
            width: 100%;
            padding: 20px;
            word-wrap: break-word;

       }
       .second-row{
            display: flex;
            justify-content: space-between;
            width: 100%;
            padding: 20px;
       }

       .third-row{
            display: flex;
            width: 100%;
            padding: 20px;
            justify-content: center;
            margin-left: 70px;
       }

       input.form-control {
            height: 40px;
        }

        .third-row input{
            margin-left:470px;
        }

        .third-row a{
            margin-left:470px;
        }

        .btn-edit-home{
            margin-right: 600px;
            padding: 0.25rem;
            line-height: 14px;
            width: 100px;
        }

        .btn-view-home{
            margin-right: -600px;
        }

        .error{
            display: flex;
            justify-content: center;
        }

    
        @media only screen and (max-width: 1400px){
            .content{
                width: 95%; 
                margin-left: 0px; 
            }
            
            .third-row input{
                margin-left:300px;
            }

            .third-row a{
                margin-left:300px;
            }

            .updatebutton{
                margin-left: 200px;
            }   
       
        }

        @media only screen and (max-width: 1200px){
            .content{
                width: 80%; 
                margin-left: 80px; 
            }
            p{
                margin-left: 5px;
                font-size: 36px;
            }
            .third-row input{
                margin-left:180px;
            }

            .third-row a{
                margin-left:160px;
            }

            .updatebutton{
                margin-right: -100px;
                margin-left: 300px;
            }

            .deletebutton{
                margin-left: 50px;
            }

           
        }

        @media only screen and (max-width: 992px){
            .content{
                width: 60%; 
                height: auto; 
                padding: 10px; 
                margin-left: 150px;
            }
            p{  
                font-size: 24px; 
                margin-top: 10px; 
            }
            .first-row{
                display: flex;
                flex-direction: column;
                width: 100%;
                padding: 20px;
                word-wrap: break-word;
                margin-top: -50px;
            }
            .second-row{
                display: flex;
                flex-direction: column;
                width: 100%;
                padding: 20px;
                word-wrap: break-word;
                margin-top: -40px;
            }

            .third-row{
                display: flex;
                justify-content: center;
                width: 100%;
                padding: 20px;
                flex-direction: column;
                margin-left: 120px;
            }
            .third-row input{
                margin-left:10px;
            }

            .third-row a{
                margin-left:0px;
                margin-top: 5px;
            }

            h1{
                color: white;
                display: flex;
                justify-content: center;
                margin-bottom: 30px;
                margin-left: 10px;
            }

            .updatebutton{
                margin-right: -100px;
                margin-left: -18px;
                margin-bottom: 10px;

            }

            .deletebutton{
                margin-left: -15px;
                margin-bottom: 10px;
            }

       
        }
        @media only screen and (max-width: 768px){
            .content{
                width: 60%; 
                height: auto; 
                padding: 10px; 
                margin-left: 100px;
            }
            p{
                font-size: 24px; 
                margin-top: 10px; 
            }
            .first-row{
                display: flex;
                flex-direction: column;
                width: 100%;
                padding: 20px;
                word-wrap: break-word;
                margin-top: -50px;
            }
            .second-row{
                display: flex;
                flex-direction: column;
                width: 100%;
                padding: 20px;
                word-wrap: break-word;
                margin-top: -40px;
            }

            .third-row{
                display: flex;
                width: 100%;
                padding: 20px;
                flex-direction: column;
                margin-left: 60px;
            }

            .third-row input{
                margin-left:10px;
            }
       
        }

        @media only screen and (max-width: 600px){
            .content{
                width: 60%; 
                height: auto; 
                padding: 10px; 
                margin-left: 100px;
            }
            p{
                font-size: 24px; 
                margin-top: 10px; 
            }
            .first-row{
                display: flex;
                flex-direction: column;
                width: 100%;
                padding: 20px;
                word-wrap: break-word;
                margin-top: -50px;
            }
            .second-row{
                display: flex;
                flex-direction: column;
                width: 100%;
                padding: 20px;
                word-wrap: break-word;
                margin-top: -40px;
            }

            .third-row{
                display: flex;
                width: 100%;
                padding: 20px;
                flex-direction: column;
                margin-left: 50px;
            }

            .third-row input{
                margin-left:10px;
            }
       
        }
       

    </style>

</head>
<body>
    <div class="container">
        <div class="content" style="margin-right: 200px;">
        <p>Please enter the following for the player<p>
            <div class="wrapper">
                <form name="addPlayer" method="post" class="form">
                    <div class="first-row">
                        <div class="form-group">
                            <div class="label">
                                <label for="nameid" style="color: white;">Name:</label>
                            </div>
                            <div>
                                <input type="text" id="nameid" name="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="label">
                                <label for="ageid" style="color: white;">Age:</label>
                            </div>
                            <div>
                                <input type="number" id="ageid" name="age" class="form-control" value="<?php echo htmlspecialchars($age); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="label">
                                <label for="positionid" style="color: white;">Position:</label>
                            </div>
                            <div>
                                <input type="text" id="positionid" name="position" class="form-control" value="<?php echo htmlspecialchars($position); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="label">
                                <label for="teamid" style="color: white;">Team:</label>
                            </div>
                            <div>
                                <input type="text" id="teamid" name="team" class="form-control" value="<?php echo htmlspecialchars($team); ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="label">
                                <label for="heightid" style="color: white;">Height:</label>
                            </div>
                            <div>
                                <input type="text" id="heightid" name="height" class="form-control" step=".01" value="<?php echo htmlspecialchars($height); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="label">
                                <label for="weightid" style="color: white;">Weight:</label>
                            </div>
                            <div>
                                <input type="number" id="weightid" name="weight" class="form-control" step=".01" value="<?php echo htmlspecialchars($weight); ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="second-row">
                        <div class="form-group">
                            <div class="label">
                                <label for="starsid" style="color: white;">Stars:</label>
                            </div>
                            <div>
                                <input type="number" id="starsid" name="stars" class="form-control" value="<?php echo htmlspecialchars($stars); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="label">
                                <label for="skills_ratingid" style="color: white;">Skills Rating:</label>
                            </div>
                            <div>
                                <input type="number" id="skills_ratingid" name="skills_rating" class="form-control" step=".01" value="<?php echo htmlspecialchars($skills_rating); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="label">
                                <label for="potential_ratingid" style="color: white;">Potential Rating:</label>
                            </div>
                            <div>
                                <input type="number" id="potential_ratingid" name="potential_rating" class="form-control" step=".01" value="<?php echo htmlspecialchars($potential_rating); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="label">
                                <label for="athletism_ratingid" style="color: white;">Athletism Rating:</label>
                            </div>
                            <div>
                                <input type="number" id="athletism_ratingid" name="athletism_rating" class="form-control" step=".01" value="<?php echo htmlspecialchars($athletism_rating); ?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="label">
                                <label for="gameiq_id" style="color: white;">Game IQ:</label>
                            </div>
                            <div>
                                <input type="number" id="gameiq_id" name="gameiqid" class="form-control" step=".01" value="<?php echo htmlspecialchars($game_iq); ?>"/>
                            </div>
                        </div>
                    </div>
                    <?php if ($error): ?>
                        <div class="error alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    <div class="third-row">
                        <?php if ($action == "Add"): ?>
                        <div>
                            <input class="btn btn-primary" type="submit" name="addPlayer" value="Add Player" style="color:white;"/>
                        </div>
                        <?php elseif ($action == "Edit"): ?>
                        <div class="updatebutton">
                            <input class="btn btn-success" type="submit" name="updatePlayer" value="Update Player" style="color:white;"/>
                        </div>
                        <div class="deletebutton">
                            <input class="btn btn-danger" type="submit" name="deletePlayer" value="Delete Player" style="color:white;"/>
                        </div>
                        <?php endif; ?>
                        <div>
                            <a href="view_players.php" class="btn btn-primary 
                                <?= ($action == 'Edit') ? 'btn-edit-home' : ''; ?>
                                <?= ($action == 'View') ? 'btn-view-home' : ''; ?>" 
                                style="color:white;">
                                Back to Home
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
<?php include __DIR__ . '../include/footer.php'?>