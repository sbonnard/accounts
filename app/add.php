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
    <?= fetchHead('Ajouter une opération - Mes Comptes') ?>
</head>

<body>

    <div class="container-fluid">
        <header class="row flex-wrap justify-content-between align-items-center p-3 mb-4 border-bottom">
            <?= fetchHeader('link-secondary', 'link-body-emphasis', 'link-body-emphasis', 'link-body-emphasis') ?>
        </header>
    </div>

    <div class="container">
        <section class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h1 class="my-0 fw-normal fs-4">Ajouter une opération</h1>
            </div>
            <?php
            echo getSuccessMessage($messages);
            echo getErrorMessage($errors);
            ?>
            <div class="card-body">
                <form method="post" action="actions.php">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom de l'opération *</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Facture d'électricité" required>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date *</label>
                        <input type="date" class="form-control" name="date" id="date" required>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Montant *</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="amount" id="amount" required>
                            <span class="input-group-text">€</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Catégorie</label>
                        <select class="form-select" name="category" id="category">
                            <option value="" selected>Aucune catégorie</option>
                            <option value="1">Nourriture</option>
                            <option value="2">Loisir</option>
                            <option value="3">Travail</option>
                            <option value="4">Voyage</option>
                            <option value="5">Sport</option>
                            <option value="6">Habitat</option>
                            <option value="7">Cadeaux</option>
                        </select>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Ajouter</button>
                    </div>

                    <input type="hidden" name="action" value="add-spending">
                    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                </form>
            </div>
        </section>
    </div>

    <div class="position-fixed bottom-0 end-0 m-3">
        <a href="add.php" class="btn btn-primary btn-lg rounded-circle">
            <i class="bi bi-plus fs-1"></i>
        </a>
    </div>

    <?= getAddButton() ?>
    <?= fetchFooter() ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>