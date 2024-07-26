<?php

/////////////////////////////// HEAD //////////////////////////////////////////////////////////
/**
 * Get HTML head content.
 *
 * @param string $headTitle - The title in the head element.
 * @return string - A string of HTML elements.
 */
function fetchHead(string $headTitle):string
{
    return 
        '
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>' . $headTitle . '</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
            <link rel="stylesheet" href="../css/style.css">
        ';
}

/////////////////////////////// HEADER //////////////////////////////////////////////////////////

/**
 * Get a template for header.
 *
 * @param string $firstLink - The class for first link.
 * @param string $secondLink - The class for second link.
 * @param string $thirdLink - The class for third link.
 * @param string $fourthLink - The class for fourth link.
 * @return string - A string containing a css class for active links.
 */
function fetchHeader(
    string $firstLink = 'link-body-emphasis', 
    string $secondLink = 'link-body-emphasis', 
    string $thirdLink = 'link-body-emphasis', 
    string $fourthLink = 'link-body-emphasis'):string {
        return '
            <a href="index.php" class="col-1">
                <i class="bi bi-piggy-bank-fill text-primary fs-1"></i>
            </a>
            <nav class="col-11 col-md-7">
                <ul class="nav">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link '. $firstLink . '" aria-current="page">Opérations</a>
                    </li>
                    <li class="nav-item">
                        <a href="summary.php" class="nav-link '. $secondLink . '">Synthèses</a>
                    </li>
                    <li class="nav-item">
                        <a href="categories.php" class="nav-link '. $thirdLink . '">Catégories</a>
                    </li>
                    <li class="nav-item">
                        <a href="import.php" class="nav-link '. $fourthLink . '">Importer</a>
                    </li>
                </ul>
            </nav>
            <form action="" class="col-12 col-md-4" role="search">
                <div class="input-group">
                    <input id="suggestionsField" type="text" class="form-control" placeholder="Rechercher..." aria-describedby="button-search">
                        <div class="suggestions__list">
                            <div class="suggestions" id="suggestions"></div>
                        </div>
                    <button class="btn btn-primary" type="submit" id="button-search">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>';
    }


/////////////////////////////// ADD BUTTON //////////////////////////////////////////////////////////

/**
 * Get add transaction button.
 *
 * @return string - HTML for add button.
 */
function getAddButton():string {
    return '
    <div class="position-fixed bottom-0 end-0 m-3">
        <a href="add.php" class="btn btn-primary btn-lg rounded-circle">
        <i class="bi bi-plus fs-1"></i>
        </a>
    </div>';
}


/////////////////////////////// FOOTER //////////////////////////////////////////////////////////

/**
 * Get a template of the footer.
 *
 * @return string - HTML for footer.
 */
function fetchFooter():string {
    return '
    <footer class="py-3 mt-4 border-top">
        <p class="text-center text-body-secondary">© 2023 Mes comptes</p>
    </footer>
    ';
}