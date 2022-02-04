<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Formulaire</title>
        <link rel="stylesheet" href="style.css">

    </head>
    <header>
        <div id="Présentation">
            <a href='connexion.php'><img id="Logo" src="res/deezify.png" alt="Logo Deezify"></a>
            <h1>Deezify</h1>
            <button id="" href="connexion.php">Connexion</button>
        </div>
    </header>

    <body>

        <form method="POST">
            <input type="text" name='name' placeholder='Nom' />
            <input type="text" name='surname' placeholder='Prénom' />
            <input type="text" name='usernameSub' placeholder='Pseudo' required/>
            <input type="password" name='password' placeholder='Mot de passe' required/>
            <input type="password" name="adminToken" placeholder="Token administrateur (optionnel)"/>
            <input type="text" name="type" value="subscribe" hidden/>
            <input type="submit" value="Submit"/>

        </form>
        
        <?php


        if(isset($_POST["usernameSub"])){

            $ini_array = parse_ini_file("config.ini");

            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $username = $_POST['usernameSub'];
            $pwd = $_POST['password'];
            $type = $_POST['type'];

            
            if($_POST["adminToken"]==$ini_array["ADMIN_TOKEN"]){

                $admin=1;
            }
            elseif ($_POST["adminToken"]=="") {
                $admin = 0;
            }
            else{
                echo "Mauvais Token";
            }

            $pwd_hash = hash('sha256', $pwd, false);

            $token = $ini_array["PROJECT_TOKEN"];
            $projectName = $ini_array["PROJECT_NAME"];


            $postdata = http_build_query(
                array(
                    'ProjectToken' => $token,
                    'ProjectName' => $projectName,
                    'name' => $name,
                    'surname' => $surname,
                    'username' => $username,
                    'pwd' => $pwd_hash,
                    'admin' => $admin
                    )
            );

            

            $opts = array('http' =>
                array(
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postdata
                    )
                );


                $context = stream_context_create($opts);
                if($_POST["adminToken"]==$ini_array["ADMIN_TOKEN"] or $_POST["adminToken"]==""){
                    $result = file_get_contents('https://testpack.emerginov2home.nohost.me/inscription', false, $context);
                    echo "Compte créé avec succès";
                }
                
        }

        ?>
        
        <a href="/connexion.php"><button>Hello</button></a>
    
    </body>
</html>
