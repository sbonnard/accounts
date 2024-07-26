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

$currentTransactions = fetchAllTransactions($dbCo, $_GET);
$monthTransactions = fetchMonthTransactions($dbCo, '2024-07');
$balance = calculateBalance($dbCo);

if (isset($_REQUEST['id']) && $_REQUEST['action'] === 'delete' && intval($_REQUEST['id'])) {
    deleteTransaction($dbCo);
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?= fetchHead('Opérations de Juillet 2023 - Mes Comptes'); ?>
</head>

<body>

    <div class="container-fluid">
        <header class="row flex-wrap justify-content-between align-items-center p-3 mb-4 border-bottom">
            <?= fetchHeader('link-secondary') ?>
        </header>
    </div>

    <div class="container">
        <section class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h2 class="my-0 fw-normal fs-4">Solde aujourd'hui</h2>
            </div>
            <div class="card-body">
                <p class="card-title pricing-card-title text-center fs-1">
                    <?= implode($balance[0]) ?>
                    €</p>
            </div>
        </section>

        <?php
        echo getSuccessMessage($messages);
        echo getErrorMessage($errors);
        if (isset($_GET['action']) && $_GET['action'] === 'modify' && isset($_GET['id']) && intval($_GET['id']))
            echo getModifyForm($currentTransactions);
        ?>


        <section class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
                <h1 class="my-0 fw-normal fs-4">Opérations de Juillet 2023</h1>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th scope="col" colspan="2">Opération</th>
                            <th scope="col" class="text-end">Montant</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= getMyTransactions($dbCo, $monthTransactions); ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <nav class="text-center">
                    <ul class="pagination d-flex justify-content-center m-2">
                        <li class="page-item disabled">
                            <span class="page-link">
                                <i class="bi bi-arrow-left"></i>
                            </span>
                        </li>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="index.php">Juillet 2023</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="juin-2023.php">Juin 2023</a>
                        </li>
                        <li class="page-item">
                            <span class="page-link">...</span>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="index.php">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </section>
    </div>

    <?= getAddButton() ?>
    <?= fetchFooter() ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="js/suggestion-bar.js"></script>

</body>

</html>