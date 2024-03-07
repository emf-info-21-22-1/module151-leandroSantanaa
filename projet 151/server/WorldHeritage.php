<?php
include_once('ctrl/LoginManager.php');
if (isset($_SERVER['REQUEST_METHOD'])) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $login = new LoginManager();
                echo $login->createAccount($_POST["username"], $_POST["password"]);
                break;
            } else {
                echo 'Paramètre de nom d\'utilisateur ou mot de passe manquant';
            }
            break;
    }
}

/*
case 'E':
if (isset($_POST['Langue']) and isset($_POST['Nom']))
{
    $deputeBD = new deputesBDManager();
    echo $deputeBD->Add($_POST['Nom'], $_POST['Langue']);
}
else{
    echo 'Paramètre Langue ou Nom manquant';
}
break;
case 'PUT':
parse_str(file_get_contents("php://input"), $vars);
//echo $vars['Langue'];

if (isset($vars['Langue']) and isset($vars['Nom']) and isset($vars['PK_Depute']))
{
    $deputeBD = new deputesBDManager();
    echo $deputeBD->Update($vars['PK_Depute'], $vars['Nom'], $vars['Langue']);
}
else{
    echo 'Paramètre PK_Depute, Langue ou Nom manquant';
}
break;
case 'DELETE':
parse_str(file_get_contents("php://input"), $vars);
if (isset($vars['PK_Depute']))
{
    $deputeBD = new deputesBDManager();
    echo $deputeBD->Delete($vars['PK_Depute']);
}
else{
    echo 'Paramètre PK_Depute manquant';
}
break;
}*/

?>