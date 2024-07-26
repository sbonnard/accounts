<?php

global $dbCo;

// $RPG = fetchRPG($dbCo);
// $parties = getPartyDatas($dbCo);
// $partiesDatas = getPartyDatasOnly($dbCo);

/**
 * Generates a random token for forms to prevent from CSRF. It also generate a new token after 15 minutes.
 *
 * @return void
 */
function generateToken()
{
    if (
        !isset($_SESSION['token'])
        || !isset($_SESSION['tokenExpire'])
        || $_SESSION['tokenExpire'] < time()
    ) {
        $_SESSION['token'] = md5(uniqid(mt_rand(), true));
        $_SESSION['tokenExpire'] = time() + 60 * 15;
    }
}

/**
 * Redirect to the given URL or to the previous page if no URL is provided.
 *
 * @param string|null $url URL to redirect to. If null, redirect to the previous page.
 * @return void
 */
function redirectTo(?string $url = null): void
{
    if ($url === null) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $url = $_SERVER['HTTP_REFERER'];
        } else {
            $url = 'defaultPage.php'; // Fallback URL if HTTP_REFERER is not set
        }
    }
    header('Location: ' . $url);
    exit;
}



/**
 * Get HTML script to load front-end assets defined in the manifest.json file for entry points given.
 *
 * @param array $entries - A list of JS files to load.
 * @return string
 */
function loadAssets(array $entries): string
{
    if (!file_exists('.vite/manifest.json')) return '';

    $html = '';
    $assets = json_decode(file_get_contents('.vite/manifest.json'), true);

    foreach ($entries as $entry) {
        if (!array_key_exists($entry, $assets)) continue;

        $html .= '<script type="module" src="' . $assets[$entry]['file'] . '"></script>';
        if (isset($assets[$entry]['css']) && is_array($assets[$entry]['css'])) {
            $html .= implode(
                array_map(
                    fn ($file) => '<link rel="stylesheet" href="' . $file . '">',
                    $assets[$entry]['css']
                )
            );
        }
    }

    return $html;
}

/**
 * Checks environment dev or prod.
 *
 * @param string $file - The path to a js file to link in your <head>.
 * @return void
 */
function checkEnvironment(string $file)
{
    if ($_ENV['ENV_TYPE'] === 'dev') {
        // Developement integration for vite with run dev
        echo '<script type="module" src="http://localhost:5173/@vite/client"></script>
        <script type="module" src="http://localhost:5173/js/main.js"></script>';
    } else if ($_ENV['ENV_TYPE'] === 'prod') {
        // Production integration for vite with run build
        echo loadAssets([$file]);
        // Try this way to load assets from manifest.json
        // https://github.com/andrefelipe/vite-php-setup
    }
}

function getMyTransactions(array $transactions): string
{
    $transationList = '';
    foreach ($transactions as $transaction) {
        $transationList .=
            '<tr>
            <td width="50" class="ps-3">
            </td>
            <td>
                <time datetime="' . $transaction['date_transaction'] . '" class="d-block fst-italic fw-light">'
            . date("d-m-Y", strtotime($transaction['date_transaction'])) . '</time>'
            . $transaction['name'] .
            '</td>
            <td class="text-end">
                <span class="rounded-pill text-nowrap bg-warning-subtle px-2">'
            . $transaction['amount'] .
            ' €</span>
            </td>
            <td class="text-end text-nowrap">
                <a href="?action=modify&id=' . $transaction['id_transaction'] . '" class="btn btn-outline-primary btn-sm rounded-circle">
                    <i class="bi bi-pencil"></i>
                </a>
                <a href="#" class="btn btn-outline-danger btn-sm rounded-circle">
                    <i class="bi bi-trash"></i>
                </a>
            </td>
        </tr>';
    }
    return $transationList;
}

/**
 * Validates a date for forms.
 *
 * @param [type] $date - The date to validate.
 * @param string $format - The format of the date.
 * @return void
 */
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

/**
 * Get HTML form to modify a transaction.
 *
 * @param array $transactions - An array containing all transactions.
 * @return string - The form to modify a transaction.
 */
function getModifyForm(array $transactions): string
{
    return '
    <section id="form-modify">
    <form method="post" action="actions.php">
        <div class="mb-3">
            <label for="update-name" class="form-label">Nom de l\'opération *</label>
            <input type="text" class="form-control" name="update-name" id="update-name" placeholder="Facture d\'électricité" required value="' . $transactions[0]['name'] . '">
        </div>
        <div class="mb-3">
            <label for="update-date" class="form-label">Date *</label>
            <input type="date" class="form-control" name="update-date" id="update-date" required value="' . $transactions[0]['date_transaction'] . '">
        </div>
        <div class="mb-3">
            <label for="update-amount" class="form-label">Montant *</label>
            <div class="input-group">
                <input type="text" class="form-control" name="update-amount" id="update-amount" required value="' . $transactions[0]['amount'] . '">
                <span class="input-group-text">€</span>
            </div>
        </div>

        <div class="mb-3">
            <label for="update-category" class="form-label">Catégorie</label>
            <select class="form-select" name="update-category" id="update-category">
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

        <input type="hidden" name="id_transaction" value="'. $transactions[0]['id_transaction'] .'">
        <input type="hidden" name="action" value="modify-transaction">
        <input type="hidden" name="token" value="' . $_SESSION['token'] . '">
    </form>
</section>';
}

/**
 * Get the id value grom $_GET surperglobal.
 *
 * @param array $arrayGET - Superglobal $_GET
 * @return integer - ID number
 */
function getIdFromGet(array $arrayGET)
{
    if (!isset($arrayGET['id'])) {
        return '';
    }
    return intval($arrayGET['id']);
}
