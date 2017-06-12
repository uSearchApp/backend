<?php 
	header("Content-Type: application/json; charset=UTF-8",true);

	$conexao = mysqli_connect("localhost", "root", "","usearch");

	$produto = $_GET['produto'];
  	$lati = $_GET['lati'];
  	$long = $_GET['long'];

  	$check = "SELECT min(hp.valor), p.nome, s.nome
		FROM historico_preco hp
		INNER JOIN supermercado s ON s.id = hp.idsupermercador 
		INNER JOIN produtos p ON p.id_produto = hp.idproduto 
		WHERE p.nome LIKE '%'+'$produto'+'%' 
		AND hp.idsupermercador IN 
		(SELECT id FROM supermercado WHERE Geo('$lati', '$long', latitude, longitude) < 0.5);"

	$row = mysqli_num_rows($check);
	if($row > 0){
		$i = 0;
        $produtos = array(produto => array());
		while($row=mysqli_fetch_array($check)){
			$produtos['produto'][$i]['valor'] = $row['min(hp.valor)'];
			$produtos['produto'][$i]['nome'] = $row['nome'];
            		$produtos['produto'][$i]['supermercado'] = $row['nome'];
            		$i++;
		}
		echo json_encode($users,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }else{
        $status['success'] = False;
        echo json_encode($status);
    }
?>


