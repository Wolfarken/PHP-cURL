<?php
    session_start();
?>

<!DOCTYPE html>
<html lang = "en-US">
	<head>
		<meta charset="UTF-8">
		<meta name="author" content="Vitor Yamanaka">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>My Website</title>
	</head>
	<body>
		<header></header>
		<nav></nav>
		
		<main>
			<?php
print_r($_SESSION['desc'][0]);
                
                $file = "excelAmazon.xls";

                // Declare variable 
                $html = "";
                // Table
                $html .= "<table>";
                // Header
                $html .= "<tr>";
                $html .= "<td colspan='2'><b>Table of prices / Descriptions</b></td>";
                $html .= "</tr>";
                // Columns
                $html .= "<tr>";
                $html .= "<td><b>Prices</b></td>";
                $html .= "<td><b>Description</b></td>";
                $html .= "</tr>";

                for ($i = 0; $i < count($_SESSION['price']); $i++) 
                {
                    $html .= "<tr>";
                    $html .= "<td>" . ($_SESSION['price'][$i]) . "</td>";
                    $html .= "<td></td>";
                    $html .= "</tr>";
                }
                
                for ($i = 0; $i < count($_SESSION['desc']); $i++)
                {
                    $html .= "<tr>";
                    $html .= "<td>" . ($_SESSION['desc'][$i]) . "</td><br>";
                    $html .= "<td></td>";
                    $html .= "</tr>";
                }
                
                $html .= "</table>";
                
                header("Cache-Control: no-cache, must-revalidate");
                header("Pragma: no-cache");
                header("Content-type: application/x-msexcel");
                header("Content-Disposition: attachment; filename=\"{$file}\"");
                header("Content-Description: PHP Generated Data");
                
                echo $html;
			?>
		</main>
		<footer></footer>
	</body>
</html>
