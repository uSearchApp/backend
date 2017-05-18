<?php
 	header("Content-Type: text/html; charset=UTF-8",true);
   
 	$conexao = mysqli_connect("localhost", "root", "","usearch");
	
	$lat = $_GET["lat"];
	$lng = $_GET["lng"];
	$check = mysqli_query($conexao, "SELECT * FROM supermercado WHERE latitude = '$lat' AND longitude = '$lng'"); //EXEMPLO
	$row = mysqli_num_rows($check);
	if($row > 0){
		while($row=mysqli_fetch_array($check)){
			$supermercado = array();
            		$supermercado['success'] = true;
            		$supermercado['id'] = $row['id'];
            		$supermercado['nome'] = $row['nome'];
		}
		echo json_encode($supermercado,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	}else{
		$string_url_maps = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lng.'&key=AIzaSyB2M7l5HTANsZr96nZfwCUXp5R7bkrrdxk';
		  
		$cURL = curl_init($string_url_maps);
		curl_setopt($cURL, CURLOPT_TIMEOUT, 5);
		curl_setopt($cURL, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
		$resultado = curl_exec($cURL);
		$google_array = json_decode($resultado, true);
		$arrayend = array();
		$arrayend['numero'] = $google_array['results'][0]['address_components'][0]['long_name'];
		$arrayend['rua'] = $google_array['results'][0]['address_components'][1]['long_name'];
		$arrayend['bairro'] = $google_array['results'][0]['address_components'][2]['long_name'];
		$arrayend['cidade'] = $google_array['results'][0]['address_components'][3]['long_name'];
		$arrayend['estado'] = $google_array['results'][0]['address_components'][5]['long_name'];
		$arrayend['pais'] = $google_array['results'][0]['address_components'][6]['long_name'];
		
		echo json_encode($arrayend,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		curl_close($cURL);
	}	
?>