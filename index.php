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
			<form method="get">
				<label>Amazon Product</label>
				<input type="text" name="product" placeholder="Enter product name" required>
		
				<input type="submit">
			</form>
			
			<?php
                include "simple_html_dom.php";
			
			    $product = filter_input(INPUT_GET, 'product');
			    
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://www.amazon.com.br/s?k=" . $product);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_ENCODING, '');
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
                
                $response = curl_exec($ch);
                curl_close($ch);

                //  Case of: Curl Error: SSL certificate problem: unable to get local issuer certificate
                //  Download certificate; put it on rootserver folder  
                //  https://curl.haxx.se/docs/caextract.html
                if (!$response)
                {
                    echo "Curl Error: " . curl_error($ch);
                }
                
                $html = new simple_html_dom();
                $html->load($response);
                
                $listPrices = array();
                $index = 0;
                //  foreach getting all price html elements
                foreach ($html->find('span[class^="a-price-whole"]') as $price)
                {
                    echo "<b>Price:</b> R$" . $price->plaintext . '<br>';
                    $listPrices[$index] = "R$" . $price;
// print_r($listPrices[$index] . "<br>");
                    $index++;
                }
                
                $listDescription = [];
                $index = 0;
                //  foreach getting all name/description html elements
                foreach ($html->find('span[class^="a-size-medium a-color-base a-text-normal"]') as $description)
                {
                    echo "<b>Description:</b> " . $description->plaintext . '<br>';
                    $listDescription[$index] = $description->plaintext;
// print_r($listDescription[$index] . "<br>");
                    $index++;
                }
                
                $_SESSION['price'] = $listPrices;
                $_SESSION['desc'] = $listDescription;
			?>
			
			<a href="excelGenerator.php">Excel Download</a>
		</main>
		<footer></footer>
	</body>
</html>
