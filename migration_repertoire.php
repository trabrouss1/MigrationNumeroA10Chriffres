<?php

//fonction numero fixe
/**
 * Représente la fonction de l'ajouote des préfixe des numéros fixes
 *
 * @param integer $tc 
 * @return void Renvoie le numéro entrer précédé du préfixe
 */
function numero_fixe(int $tc)
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

// fonction numero ordinaire
function numero_ordinaire(int $dc)
{
    $suffixe = null;
    if ($dc == 0 || $dc == 1 || $dc == 2 || $dc == 3) {
        $suffixe = "01";
    } elseif ($dc == 4 || $dc == 5 || $dc == 6) {
        $suffixe = "05";
    } else {
        $suffixe = "07";
    }
    return $suffixe;
}

function execute_migration($numero_a_migrer)
{
    $nvo_numero = null;
    $message = null;
    $erreur = null;
    if (is_numeric($numero_a_migrer)) {
        $longueur_numero = strlen($numero_a_migrer);
        $premiers_caracteres = 0;
        $premier_chiffre = $numero_a_migrer[0];
        $premier = $numero_a_migrer[4];
        $chiffre = $numero_a_migrer[5];

        // Numerotation Fixe

        if (($longueur_numero == 8) && ($premier_chiffre == 2 || $premier_chiffre == 3)) {
            $nvo_numero = numero_fixe($numero_a_migrer[2]) . $numero_a_migrer;
            $message = "Votre nouveau numéro fixe est le $nvo_numero\n";
        } elseif (($longueur_numero == 12) && ($premier == 2 || $premier == 3)) {
            $premiers_caracteres = substr($numero_a_migrer, 0, 4);
            if ($premiers_caracteres == "+225") {
                $nvo_numero = $premiers_caracteres . numero_fixe($numero_a_migrer[6]) . substr($numero_a_migrer, 4);
                $message = "Votre nouveau numéro fixe est le $nvo_numero\n";
            } else {
                $message = "Votre numéro n'est pas un numéro fixe ivoirien\n";
            }
        } elseif (($longueur_numero == 13) && ($chiffre == 2 || $chiffre == 3)) {
            $premiers_caracteres = substr($numero_a_migrer, 0, 5);
            if ($premiers_caracteres == "00225") {
                $nvo_numero = $premiers_caracteres . numero_fixe($numero_a_migrer[7]) . substr($numero_a_migrer, 5);
                $message = "Votre nouveau numéro fixe est le $nvo_numero\n";
            } else {
                $message = "Votre numéro n'est pas un numéro fixe ivoirien\n";
            }
        }

        //Numerotation ordinaire 

        elseif ($longueur_numero == 8) {
            $nvo_numero = numero_ordinaire($numero_a_migrer[1]) . $numero_a_migrer;
            $erreur = true;
            $message = "Votre nouveau numéro est le $nvo_numero\n";
        } elseif ($longueur_numero == 12) {
            $premiers_caracteres = substr($numero_a_migrer, 0, 4);
            if ($premiers_caracteres == "+225") {
                $nvo_numero = $premiers_caracteres . numero_ordinaire($numero_a_migrer[5]) . substr($numero_a_migrer, 4);
                $erreur = true;
                $message = "Votre nouveau numéro est le $nvo_numero\n";
            } else {
                $erreur = false;
                $message = "Votre numéro n'est pas un numéro ivoirien\n";
            }
        } elseif ($longueur_numero == 13) {
            $premiers_caracteres = substr($numero_a_migrer, 0, 5);
            if ($premiers_caracteres == "00225") {
                $nvo_numero = $premiers_caracteres . numero_ordinaire($numero_a_migrer[6]) . substr($numero_a_migrer, 5);
                $message = "Votre nouveau numéro est le $nvo_numero\n";
                $erreur = true;
            } else {
                $erreur = false;
                $message = "Votre numéro n'est pas un numéro ivoirien\n";
                $nvo_numero = $numero_a_migrer;
            }
        } else {
            $message = "Votre numéro n'est pas un numéro ivoirien\n";
            $nvo_numero = $numero_a_migrer;
        }
        // echo $message;
    } else {
        $nvo_numero = $numero_a_migrer;
        // echo "Attention !!! Le numero saisi n'est pas valide";
    }
    return $nvo_numero;
}
// Executable en invite de cmd
echo "Bienvenu à votre application de migration vers la nouvelle numérotation ivoirienne\n";
// echo "Entrez un numéro\n";
$repertoire = ["0022503699875", "+22508731251", "20852332", "0033789647575", "45789664", "1013158", "256fgr5668", "21094575"];
// $numero = fgets(STDIN);
$nvo_repertoire = [];
$nbr_migre = 0;
$nbr_non_migre = 0;
foreach ($repertoire as $numero) {
    $version_migre =  execute_migration($numero);
    // condition pour une seul instruction 
    $version_migre == $numero ? $nbr_non_migre++ :  $nbr_migre++;
    // if ($version_migre == $numero){
    //     $nbr_non_migre++;
    // }else{
    //     $nbr_migre++;
    // }
    //$nvo_repertoire[] = execute_migration($numero);
    $nvo_repertoire[] = $version_migre;
}

echo "Le nouveau répertoire est le suivant :";
print_r($nvo_repertoire);
echo "Il y a eu $nbr_migre migrations et $nbr_non_migre inchangés.\n";

$version
?>