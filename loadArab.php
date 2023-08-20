<?php
session_start();
$_SESSION['load'] = $_POST['laod'];

// Nom du fichier XML à charger
$filename = $_SESSION['load'] . ".xml";

// Chargement du fichier XML
$xml = simplexml_load_file($filename);

// Enregistrement des données dans des variables de session
$_SESSION['bank'] = str_replace(['#%', '%#'], '', (string)$xml->name);
$_SESSION['cols'] = (int)$xml->numberOfFiled;
$_SESSION['rows'] = (int)$xml->numberOfSimilerQuestion;
$_SESSION['Question'] = str_replace(['#%', '%#' , '1_','2_','3_','4_','5_','6_','7_','8_','9_','10_','11_','12_'], '', (string)$xml->QuestionText);
$_SESSION['answer'] = (int)$xml->numberOfAnswer;
$_SESSION['mark'] = (float)$xml->totalGrad;
$_SESSION['Reponse1'] = str_replace(['#%', '%#', '1_','2_','3_','4_','5_','6_','7_','8_','9_','10_','11_','12_'], '', (string)$xml->Answer[0]);
$_SESSION['prctg1'] = str_replace(['#%', '%#'], '', (string)$xml->Answer[0]->attributes()->value);

// Parcours des autres réponses
for ($i = 1; $i < $xml->numberOfAnswer; $i++) {
    $_SESSION['Reponse' . ($i + 1)] = str_replace(['#%', '%#', '1_','2_','3_','4_','5_','6_','7_','8_','9_','10_','11_','12_'], '', (string)$xml->Answer[$i]);
    $_SESSION['prctg' . ($i + 1)] = str_replace(['#%', '%#'], '', (string)$xml->Answer[$i]->attributes()->value);
}

// Parcours des champs similaires
// Parcourir les nœuds "Similar" du fichier XML avec une boucle for
for ($i = 0; $i < $_SESSION['rows']; $i++) {
    // Parcourir les nœuds "Field" du nœud "Similar" avec une boucle for
    for ($j = 0; $j < $_SESSION['cols']; $j++) {
        $value = str_replace(['#%', '%#'], '', (string)$xml->Similar[$i]->Field[$j]);
        // Stocker la valeur dans une variable de session avec une clé unique
        $_SESSION['similar_' . $i . '_field_' . $j] = $value;
    }
}

header('Location: chargeeArab.php');
?>
