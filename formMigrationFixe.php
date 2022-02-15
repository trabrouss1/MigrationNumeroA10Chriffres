<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <title>Migration Fixe</title>
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
                $nvo_numero = execute_migration($numero[2]) . $numero;
                $erreur = true;
                $message = "Votre nouveau numéro fixe est le <strong>$nvo_numero</strong>";
            } elseif ($longueur_numero == 12) {
                $premiers_caracteres = substr($numero, 0, 4);
                if ($premiers_caracteres == "+225") {
                    $nvo_numero = $premiers_caracteres . execute_migration($numero[6]) . substr($numero, 4);
                    $erreur = true;
                    $message = "Votre nouveau numéro fixe est le <strong>$nvo_numero</strong>";
                } else {
                    $erreur = false;
                    $message = "Votre numéro n'est pas un numéro fixe ivoirien";
                }
            } elseif ($longueur_numero == 13) {
                $premiers_caracteres = substr($numero, 0, 5);
                if ($premiers_caracteres == "00225") {
                    $nvo_numero = $premiers_caracteres . execute_migration($numero[7]) . substr($numero, 5);
                    $message = "Votre nouveau numéro fixe est le <strong>$nvo_numero</strong>";
                    $erreur = true;
                } else {
                    $erreur = false;
                    $message = "Votre numéro n'est pas un numéro fixe ivoirien";
                }
            } else {
                $message = "Votre numéro n'est pas un numéro fixe ivoirien";
            }

            // echo "<p>$message</p>";
        } else {
            echo "<p style='color: red'>Attention !!! <br> Le numero saisi n'est pas valide</p>";
        }
    }

    function execute_migration(int $tc)
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

    ?>
    <div class="container">
        <h1 class="bg-dark text-light text-center">Migration des numéros fixes</h1>
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
            <div class="form-row mt-5">
                <div class="form-group col-md-5">
                    <label for="numero">Numero fixe à convertir:</label>
                    <input type="text" name="numero" id="numero" class="form-control"
                        value="<?= (isset($numero)) ? $numero : '' ?>"
                        placeholder="Veuillez entrer un numéro de téléphone" required>
                </div>
                <div class="form-group col-md-5 mt-3">
                    <label for="nvo_numero">Nouveau numéro fixe:</label>
                    <input type="text" name="nvo_numero" id="nvo_numero" class="form-control"
                        value="<?= ($nvo_numero != null) ? $nvo_numero : '' ?>" readonly>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary mt-3" name="sms">Convertir</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>