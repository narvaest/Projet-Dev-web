<?php

function fetch_data(){
    $output = '';
    $dsn = 'sqlite:bdd.db';
    // Connect to the SQLite database
    $db = new PDO($dsn);

     // Create the table if it doesn't exist
     $createTableQuery = "
     CREATE TABLE IF NOT EXISTS your_table (
         id INTEGER PRIMARY KEY AUTOINCREMENT,
         name TEXT,
         email TEXT
     )
    ";
    $db->exec($createTableQuery);

    // Fetch data from the table
    $selectQuery = "SELECT * FROM your_table";
    $results = $db->query($selectQuery);
    // Loop through the results and generate the table rows
    while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
        $output .= '
            <tr>
                <td>'.$row["id"].'</td>
                <td>'.$row["name"].'</td>
                <td>'.$row["email"].'</td>
            </tr>
        ';
    }

    return $output;

}

ob_start(); // Start output buffering

require_once('tcpdf/tcpdf.php');

// Create new PDF document
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

// Set document information
$pdf->SetCreator('Your Website');
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('User Registration');
$pdf->SetSubject('User Details');
$pdf->SetKeywords('user, registration, details');

// Add a page
$pdf->AddPage();

// Set the font and font size
$pdf->SetFont('helvetica', '', 12);

// Output the user details
$html = '
        <table border="1">
            <tr>
                <th width="50%">Jeunes</th>
                <th width="50%">Referent</th> 
            </tr>
';

$html .= fetch_data();

$html .='</table>';
$pdf->writeHTML($html, true, 0, true, false, '');

// Output the PDF as a file or inline
$pdf->Output('user_details.pdf', 'I');  // 'D' to force download, 'I' to open in the browser

ob_end_flush(); // Flush and stop output buffering
?>
