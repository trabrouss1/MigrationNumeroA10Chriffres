<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <title>Migration : 8 à 10</title>
</head>

<body>
    <?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    if (isset($_POST["cvt"])) {


        function validated($path)
        {
            $path = trim($path);
            $path = str_replace(" ", "", $path);
            $path = str_replace("-", "", $path);
            $path = str_replace(".", "", $path);
            return $path;
        }

        $numero = validated($_POST["numero"]);
        $nvo_numero = null;
        $message = null;
        $erreur = null;
        if (is_numeric($numero)) {
            $longueur_numero = strlen($numero);
            $premiers_caracteres = 0;
            $premier_chiffre = ($numero[0]);
            $premier = ($numero[4]);
            $chiffre = ($numero[5]);

            // Numerotation Fixe
            if (($longueur_numero == 8) && ($premier_chiffre == 2 || $premier_chiffre == 3)) {
                $nvo_numero = numero_fixe($numero[2]) . $numero;
                $erreur = true;
                $message = "Votre nouveau numéro fixe est le <strong>$nvo_numero</strong>";
            } elseif (($longueur_numero == 12) && ($premier === 2 || $premier === 3)) {
                $premiers_caracteres = substr($numero, 0, 4);
                if ($premiers_caracteres == "+225") {
                    $nvo_numero = $premiers_caracteres . numero_fixe($numero[6]) . substr($numero, 4);
                    $erreur = true;
                    $message = "Votre nouveau numéro fixe est le <strong>$nvo_numero</strong>";
                } else {
                    $erreur = false;
                    $message = "Votre numéro n'est pas un numéro ivoirien\n";
                }
            } elseif (($longueur_numero == 13) && ($chiffre == 2 || $chiffre == 3)) {
                $premiers_caracteres = substr($numero, 0, 5);
                if ($premiers_caracteres == "00225") {
                    $nvo_numero = $premiers_caracteres . numero_fixe($numero[7]) . substr($numero, 5);
                    $message = "Votre nouveau numéro fixe est le $nvo_numero\n";
                    $erreur = true;
                } else {
                    $erreur = false;
                    $message = "Votre numéro n'est pas un numéro ivoirien\n";
                }
            }

            //Numerotation ordinaire 

            elseif ($longueur_numero == 8) {
                $nvo_numero = numero_ordinaire($numero[1]) . $numero;
                $erreur = true;
                $message = "Votre nouveau numéro est le $nvo_numero\n";
            } elseif ($longueur_numero == 12) {
                $premiers_caracteres = substr($numero, 0, 4);
                if ($premiers_caracteres == "+225") {
                    $nvo_numero = $premiers_caracteres . numero_ordinaire($numero[5]) . substr($numero, 4);
                    $erreur = true;
                    $message = "Votre nouveau numéro est le $nvo_numero\n";
                } else {
                    $erreur = false;
                    $message = "Votre numéro n'est pas un numéro ivoirien";
                }
            } elseif ($longueur_numero == 13) {
                $premiers_caracteres = substr($numero, 0, 5);
                if ($premiers_caracteres == "00225") {
                    $nvo_numero = $premiers_caracteres . numero_ordinaire($numero[6]) . substr($numero, 5);
                    $message = "Votre nouveau numéro est le $nvo_numero\n";
                    $erreur = true;
                } else {
                    $erreur = false;
                    $message = "Votre numéro n'est pas un numéro ivoirien\n";
                }
            } else {
                $message = "Votre numéro n'est pas un numéro ivoirien\n";
            }
            // echo $message;
        } else {
            $message = "Attention !!!  Le numero saisi n'est pas valide";
        }
    }

    // fonction numero fixe
    function numero_fixe(int $tc)
    {
        $prefixe = null;
        // $tc troisieme chiffres
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
        //  $dc deuxieme chiffres
        if ($dc == 0 || $dc == 1 || $dc == 2 || $dc == 3) {
            $suffixe = "01";
        } elseif ($dc == 4 || $dc == 5 || $dc == 6) {
            $suffixe = "05";
        } else {
            $suffixe = "07";
        }
        return $suffixe;
    }

    // echo "Les quatre premiers caractères sont ".substr($numero, 0, 4);
    //echo "le septieme caracteres est ($numero[6])\n";
    // echo "Le nombre de caractères de votre numéro est : ".strlen($numero)."\n";
    // echo "Votre numero est le $numero\n";
    // echo "Le premier chiffre est : ($numero[0])\n";
    // echo "Le troisieme caractere est: ($numero[2])\n";

    ?>
    <div class="container">
        <h1 class="bg-dark text-light text-center">Migration totale des numéros ordinnaires et fixes</h1>
        <?php if (isset($_POST["cvt"])) : ?>
        <?php if ($erreur == false) : ?>
        <div class="alert alert-danger">
            <?= $message; ?>
        </div>
        <?php else : ?>
        <div class="alert alert-success">
            <?= $message; ?>
        </div>
        <?php endif; ?>
        <?php endif; ?>
        <form action="" method="post">
            <div class="form-row mt-5">
                <div class="form-group col-md-5">
                    <label for="numero">Numero à convertir</label>
                    <input type="text" name="numero" id="numero" class="form-control"
                        value="<?php if (isset($numero)) echo $numero; ?>"
                        placeholder="Veuillez entrer un numéro de téléphone" required>
                </div>
                <div class="form-group col-md-5 mt-3">
                    <label for="nvo_numero">Nouveau numéro</label>
                    <input type="text" name="nvo_numero" id="nvo_numero" class="form-control"
                        value="<?php if (!empty($nvo_numero)) echo $nvo_numero;  ?>" readonly>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary mt-3" name="cvt">Valider</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>