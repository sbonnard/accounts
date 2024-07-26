<?php
session_start();

require_once "includes/_config.php";
require_once "includes/_database.php";
require_once "includes/_security.php";
require_once "includes/_functions.php";
require_once "includes/_message.php";
require_once "includes/_datas.php";
require_once "includes/components/_templates.php";


generateToken();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?= fetchHead('Importer des opérations - Mes Comptes') ?>
</head>

<body>

    <div class="container-fluid">
        <header class="row flex-wrap justify-content-between align-items-center p-3 mb-4 border-bottom">
            <?= fetchHeader('link-body-emphasis', 'link-body-emphasis', 'link-body-emphasis', 'link-secondary') ?>
        </header>
    </div>

    <div class="container">
        <section class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h1 class="my-0 fw-normal fs-4">Importer des opérations</h1>
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="file" class="form-label">Fichier</label>
                        <input type="file" accept=".csv" aria-describedby="file-help" class="form-control" name="file" id="file">
                        <div id="file-help" class="form-text">Seul les fichiers CSV avec séparateur "," (virgule) sont supportés.</div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Envoyer</button>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <?= getAddButton() ?>
    <?= fetchFooter() ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>