<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <title>Migration</title>
</head>

<body>

    <?php
    if (isset($_POST["sms"])) {
        $numero = $_POST["numero"];
        $nvo_numero = null;
        $message = null;
        $erreur = null;
        // echo "Votre numero est le $numero\n";
        // echo "Le nombre de caractères de votre numéro est : ".strlen($numero)."\n";
        if (is_numeric($numero)) {
            $longueur_numero = strlen($numero);
            $premiers_caracteres = 0;
            // echo "Les quatre premiers caractères sont ".substr($numero, 0, 4);
            if ($longueur_numero == 8) {
                $nvo_numero = execute_migration($numero[1]) . $numero;
                $erreur = true;
                $message = "Votre nouveau numéro est le <strong>$nvo_numero</strong>";
            } elseif ($longueur_numero == 12) {
                $premiers_caracteres = substr($numero, 0, 4);
                if ($premiers_caracteres == "+225") {
                    $nvo_numero = $premiers_caracteres . execute_migration($numero[5]) . substr($numero, 4);
                    $erreur = true;
                    $message = "Votre nouveau numéro est le <strong>$nvo_numero</strong>";
                } else {
                    $erreur = false;
                    $message = "Votre numéro n'est pas un numéro ivoirien";
                }
            } elseif ($longueur_numero == 13) {
                $premiers_caracteres = substr($numero, 0, 5);
                if ($premiers_caracteres == "00225") {
                    $nvo_numero = $premiers_caracteres . execute_migration($numero[6]) . substr($numero, 5);
                    $message = "Votre nouveau numéro est le <strong>$nvo_numero</strong>";
                    $erreur = true;
                } else {
                    $erreur = false;
                    $message = "Votre numéro n'est pas un numéro ivoirien";
                }
            } else {
                $message = "Votre numéro n'est pas un numéro ivoirien";
            }

            // echo "<p>$message</p>";
        } else {
            $message = "Attention !!! Le numero saisi n'est pas valide";
        }
    }

    /**
     * Représente la fonction charger de mettre les préfixe aux numéros ordinnaire
     *
     * @param integer $dc Représente 
     * @return void Renvoie l'ajoute le préfixe au numéros ordinnaires
     */
    function execute_migration(int $dc)
    {
        $suffixe = null;
        if ($dc == 0 or $dc == 1 or $dc == 2 or $dc == 3) {
            $suffixe = "01";
        } elseif ($dc == 4 or $dc == 5 or $dc == 6) {
            $suffixe = "05";
        } else {
            $suffixe = "07";
        }

        return $suffixe;
    }



    ?>
    <div class="container">
        <h1 class="bg-dark text-light text-center">Migration des numéros ordinnaires</h1>
        <?php if (isset($_POST["sms"])) : ?>
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
            <div class=" form-row mt-5">
                <div class="form-group col-md-5">
                    <label for="numero">Numero à convertir</label>
                    <input type="text" name="numero" id="numero" class="form-control"
                        value="<?php if (isset($numero)) echo $numero; ?>"
                        placeholder="Veuillez entrer un numéro de téléphone" required>
                </div>
                <div class="form-group col-md-5 mt-3">
                    <label for="nvo_numero">Nouveau numéro</label>
                    <input type="text" name="nvo_numero" id="nvo_numero" class="form-control"
                        value="<?php if ($nvo_numero != null) echo $nvo_numero;  ?>" readonly>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary mt-3" name="sms">Valider</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>