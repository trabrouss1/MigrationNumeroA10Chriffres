<?php

    //fonction numero fixe
    function numero_fixe(int $tc)
    {
        $prefixe = null;
        if($tc == 8){
            $prefixe = "21";
        }
        elseif($tc == 0){
              $prefixe = "25";
        }
        else{
            $prefixe = "27";
        }
        return $prefixe;
    }

    // fonction numero ordinaire
    function numero_ordinaire(int $dc)
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

        // Executable en invite de cmd
        echo "Bienvenu à votre application de migration vers la nouvelle numérotation ivoirienne\n";
        echo "Entrez un numéro\n";
        $numero = fgets(STDIN);
        $nvo_numero = null;
        $message = null;
        $erreur = null;
        if(is_numeric($numero)){
            $longueur_numero = strlen($numero) - 2;
            $premiers_caracteres = 0;
            $premier_chiffre = ($numero[0]);
            $premier = ($numero[4]);
            $chiffre = ($numero[5]);
            
            // Numerotation Fixe

            if(($longueur_numero == 8) && ($premier_chiffre == 2 || $premier_chiffre == 3)){
                $nvo_numero = numero_fixe($numero[2]).$numero;
                 $message = "Votre nouveau numéro fixe est le $nvo_numero\n";
            }
            elseif(($longueur_numero == 12) && ($premier == 2 || $premier == 3)){
                $premiers_caracteres = substr($numero, 0, 4);
                if($premiers_caracteres == "+225"){
                    $nvo_numero = $premiers_caracteres.numero_fixe($numero[6]).substr($numero, 4);
                    $message = "Votre nouveau numéro fixe est le $nvo_numero\n";
                }
                else{
                    $message = "Votre numéro n'est pas un numéro fixe ivoirien\n";
                }
            }
            elseif(($longueur_numero == 13) && ($chiffre == 2 || $chiffre == 3)){
                $premiers_caracteres = substr($numero, 0, 5);
                if($premiers_caracteres == "00225"){
                    $nvo_numero = $premiers_caracteres.numero_fixe($numero[7]).substr($numero, 5);
                    $message = "Votre nouveau numéro fixe est le $nvo_numero\n";
                }
                else{
                    $message = "Votre numéro n'est pas un numéro fixe ivoirien\n";
                }
            }

            //Numerotation ordinaire 

            elseif($longueur_numero == 8){
                $nvo_numero = numero_ordinaire($numero[1]).$numero;
                $erreur = true;
                $message = "Votre nouveau numéro est le $nvo_numero\n";
            }
            elseif($longueur_numero == 12){
                $premiers_caracteres = substr($numero, 0, 4);
                if($premiers_caracteres == "+225"){
                    $nvo_numero = $premiers_caracteres.numero_ordinaire($numero[5]).substr($numero, 4);
                    $erreur = true;
                    $message = "Votre nouveau numéro est le $nvo_numero\n";
                }
                else{
                    $erreur = false;
                    $message = "Votre numéro n'est pas un numéro ivoirien\n";
                }
            }
            elseif($longueur_numero == 13){
                $premiers_caracteres = substr($numero, 0, 5);
                if($premiers_caracteres == "00225"){
                    $nvo_numero = $premiers_caracteres.numero_ordinaire($numero[6]).substr($numero, 5);
                    $message = "Votre nouveau numéro est le $nvo_numero\n";
                    $erreur = true;
                }
                else{
                    $erreur = false;
                    $message = "Votre numéro n'est pas un numéro ivoirien\n";
                }
            }
            
            else{
                $message = "Votre numéro n'est pas un numéro ivoirien\n";
            }
            echo $message;
        }
        else{
            echo "Attention !!! Le numero saisi n'est pas valide";
        }
        
?>