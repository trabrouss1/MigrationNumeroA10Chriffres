<?php

    echo "Bienvenu à votre application de renvoie vers l'ancienne numérotation ivoirienne\n";
    echo "Entrez un nouveau numéro\n";
    $numero = fgets(STDIN);
    $nvo_numero = null;

    if(is_numeric($numero)){
        $longueur_numero = strlen($numero) - 2;
        $premiers_caracteres = 0;

        if(($longueur_numero == 10) && (substr($numero, 0, 2) == 01 || substr($numero, 0, 2) == 05 ||substr($numero, 0, 2) == 07 
        || substr($numero, 0, 2) == 21 || substr($numero, 0, 2) == 25 || substr($numero, 0, 2) == 27)) 
        {
            $nvo_numero = substr($numero, 2);
            echo "Votre ancien numéro est le: $nvo_numero\n";
        }
        elseif(($longueur_numero == 14) && (substr($numero, 0, 6) == "+22501" || substr($numero, 0, 6) == "+22505" ||substr($numero, 0, 6) == "+22507" 
        || substr($numero, 0, 6) == "+22521" || substr($numero, 0, 6) == "+22525" || substr($numero, 0, 6) == "+22527"))
        {
            $premiers_caracteres = substr($numero, 0, 4);
            if($premiers_caracteres == "+225"){
                $nvo_numero = $premiers_caracteres.substr($numero, 6);
                echo "Votre ancien numéro est le: $nvo_numero\n";
            }
            else{
                echo "Votre numéro n'est pas un numéro ivoirien \n";
            }
        }
        elseif(($longueur_numero == 15) && (substr($numero, 0, 7) == "0022501" || substr($numero, 0, 7) == "0022505" ||substr($numero, 0, 7) == "0022507"
        || substr($numero, 0, 7) == "0022521" || substr($numero, 0, 7) == "0022525" || substr($numero, 0, 7) == "0022527"))
        {
            $premiers_caracteres = substr($numero, 0, 5);
            if($premiers_caracteres == "00225"){
                $nvo_numero = $premiers_caracteres.substr($numero, 7);
                echo "Votre ancien numéro est le: $nvo_numero\n";
            }
            else{
                echo "Votre numéro n'est pas un numéro ivoirien \n";
            }
        }
        else{
            echo "Votre numéro n'est pas un numéro ivoirien \n";
        }
    }
    else{
        echo "Attention !!! Le numero saisi n'est pas valide";
    }
        
?>