<?php

    function execute_migration(int $dc)
    {
        $suffixe = null;
        if($dc == 0 || $dc == 1 || $dc == 2 || $dc ==3){
            $suffixe = "01";
        }
        elseif($dc == 4 || $dc == 5 || $dc == 6){
              $suffixe = "05";
        }
        else{
            $suffixe = "07";
        }

        return $suffixe;
    } 
    echo "Bienvenu à note application de migration vers la nouvelle numérotation ivoirienne\n";
    echo "Entrez un numéro\n";
    $numero = fgets(STDIN);
    $nvo_numero = null;
    $message = null;
    // echo "Votre numero est le $numero\n";
    // echo "Le nombre de caractères de votre numéro est : ".strlen($numero)."\n";
    $longueur_numero = strlen($numero) - 2;
    $premiers_caracteres = 0;
    // echo "Les quatre premiers caractères sont ".substr($numero, 0, 4);
    if($longueur_numero == 8){
        $nvo_numero = execute_migration($numero[1]).$numero;
         $message = "Votre nouveau numéro est le $nvo_numero\n";
    }
    elseif($longueur_numero == 12){
        $premiers_caracteres = substr($numero, 0, 4);
        if($premiers_caracteres == "+225"){
            $nvo_numero = $premiers_caracteres.execute_migration($numero[5]).substr($numero, 4);
            $message = "Votre nouveau numéro est le $nvo_numero\n";
        }
        else{
            $message = "Votre numéro n'est pas un numéro ivoirien\n";
        }
    }
    elseif($longueur_numero == 13){
        $premiers_caracteres = substr($numero, 0, 5);
        if($premiers_caracteres == "00225"){
            $nvo_numero = $premiers_caracteres.execute_migration($numero[6]).substr($numero, 5);
            $message = "Votre nouveau numéro est le $nvo_numero\n";
        }
        else{
            $message = "Votre numéro n'est pas un numéro ivoirien\n";
        }
    }
    else{
        $message = "Votre numéro n'est pas un numéro ivoirien\n";
    }
    echo $message;
?>