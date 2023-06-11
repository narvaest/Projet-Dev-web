<?php
session_start();

if ($_SESSION['connexion'] != 'jeune') {
    header('location: connexion.php');
    exit();
}

$id_jeune = $_SESSION['id'];
$nom_jeune = $_SESSION['prenom'].' '.$_SESSION['nom'];

$dsn = 'sqlite:bdd.db';
// Connect to the SQLite database
$db = new PDO($dsn);

function fetch_data()
{
    global $id_jeune;
    global $db;

    $output = '';

    $createTableQuery = 'CREATE TABLE IF NOT EXISTS referent (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        id_jeune INTEGER,
        nom TEXT NOT NULL,
        prenom TEXT NOT NULL,
        duree TEXT NOT NULL,
        mail TEXT NOT NULL,
        milieu TEXT NOT NULL,
        description TEXT NOT NULL,
        confiance INTEGER,
        bienveillance INTEGER,
        respect INTEGER,
        honnetete INTEGER,
        tolerance INTEGER,
        impartial INTEGER,
        travail INTEGER,
        equipe INTEGER,
        autonomie INTEGER,
        communication INTEGER,
        valid TEXT NOT NULL
    )';

    $db->exec($createTableQuery);

    // Fetch data from the table
    $selectQuery = "SELECT * FROM referent WHERE id_jeune = :id_jeune";
    $results = $db->prepare($selectQuery);
    $results->bindValue(':id_jeune', $id_jeune, PDO::PARAM_INT);
    $results->execute();

    // Loop through the results and generate the table rows
    while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
        $output .= '
        <tr>
            <td align="center">Referent: '.$row["prenom"].' '.$row["nom"].'</td>
            <td align="center">Milieu: '.$row["milieu"].'</td>
            <td align="center">Duree: '.$row["duree"].'</td>
            <td align="center">Mail: '.$row["mail"].'</td>
        </tr>
        <tr>
            <td align="center" colspan="4">Description: '.$row["description"].'</td>
        </tr>
        ';

        // Savoir
        $savoir = '';
        if ($row["confiance"] == 1) {
            $savoir .= ' confiance ';
        }
        if ($row["bienveillance"] == 1) {
            $savoir .= ' bienveillance ';
        }
        if ($row["respect"] == 1) {
            $savoir .= ' respect ';
        }
        if ($row["honnetete"] == 1) {
            $savoir .= ' honnetete ';
        }
        if ($row["tolerance"] == 1) {
            $savoir .= ' tolerance ';
        }
        if ($row["travail"] == 1) {
            $savoir .= ' travail ';
        }
        if ($row["autonomie"] == 1) {
            $savoir .= ' autonomie ';
        }
        if ($row["communication"] == 1) {
            $savoir .= ' communication ';
        }

        if ($savoir != '') {
            $output .= '
            <tr>
                <td align="center" colspan="4">Savoir: '.$savoir.'</td>
            </tr>';
        }

        $output .= '<br><br>';
    }

    return $output;
}

ob_start(); // Start output buffering

require_once('tcpdf/tcpdf.php');

// Create new PDF document
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

// Set document information
$pdf->SetCreator('Jeunes 6.4');
$pdf->SetAuthor('Cy-tech');
$pdf->SetTitle('Vos references');
$pdf->SetSubject('Reference');
$pdf->SetKeywords('utilisateur, reference, details');

// Add a page
$pdf->AddPage();

// Set the font and font size
$pdf->SetFont('helvetica', '', 12);

// Output the user details
$html = '
        <table border="1">
        <tr>
            <th colspan="4" align="center">Reference de '.$nom_jeune.'</th>
        </tr>
        <br><br>
';

$html .= fetch_data();

$html .= '</table>';
$pdf->writeHTML($html, true, 0, true, false, '');

// Output the PDF as a file or inline
$pdf->Output('Vos_references.pdf', 'D');  // 'D' to force download, 'I' to open in the browser

ob_end_flush(); // Flush and stop output buffering
?>
