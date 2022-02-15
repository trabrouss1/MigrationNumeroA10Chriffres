<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
function execut_migration(int $tc)
{
    $prefixe = null;
    if ($tc == 8) {
        $prefixe = "21";
    } elseif ($tc == 0) {
        $prefixe = "25";
    } else {
        $prefixe = "27";
    }

    return $prefixe;
}

echo "Bienvenu à note application de migration vers la nouvelle numérotation fixe ivoirienne\n";
echo "Entrez un numéro fixe\n";
$numero = fgets(STDIN);
$nvo_numero = null;
$message = null;
// echo "Votre numero est le $numero\n";
// echo "Le nombre de caractères de votre numéro est : ".strlen($numero)."\n";
$longueur_numero = strlen($numero) - 2;
$premiers_caracteres = 0;
$premier_chiffre = ($numero[0]);
$premier = ($numero[4]);
$chiffre = ($numero[5]);
// echo "Les quatre premiers caractères sont ".substr($numero, 0, 4);
if (($longueur_numero == 8) && ($premier_chiffre == 2 || $premier_chiffre == 3)) {
    $nvo_numero = execut_migration($numero[2]) . $numero;
    $message = "Votre nouveau numéro fixe est le $nvo_numero\n";
} elseif ($longueur_numero == 12) {
    $premiers_caracteres = substr($numero, 0, 4);
    if (($premiers_caracteres == "+225") && ($premier == 2 || $premier == 3)) {
        $nvo_numero = $premiers_caracteres . execut_migration($numero[6]) . substr($numero, 4);
        $message = "Votre nouveau numéro fixe est le $nvo_numero\n";
    } else {
        $message = "Votre numéro n'est pas un numéro fixe ivoirien\n";
    }
} elseif (($longueur_numero == 13) && ($chiffre == 2 || $chiffre == 3)) {
    $premiers_caracteres = substr($numero, 0, 5);
    if ($premiers_caracteres == "00225") {
        $nvo_numero = $premiers_caracteres . execut_migration($numero[7]) . substr($numero, 5);
        $message = "Votre nouveau numéro fixe est le $nvo_numero\n";
    } else {
        $message = "Votre numéro n'est pas un numéro fixe ivoirien\n";
    }
} else {
    $message = "Votre numéro n'est pas un numéro fixe ivoirien\n";
}
echo $message;