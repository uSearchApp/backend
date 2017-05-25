<?php
  header("Content-Type: application/json; charset=UTF-8",true);

  $conexao = mysqli_connect("localhost", "root", "","usearch");

  $nome = $_GET['nome'];
  $numero = $_GET['numero'];
  $rua = $_GET['rua'];
  $bairro = $_GET['bairro'];
  $cidade = $_GET['cidade'];
  $estado = $_GET['estado'];
  $pais = $_GET['pais'];
  $lat = $_GET['lat'];
  $lng = $_GET['lng'];

  $check = "INSERT INTO supermercado (nome, numero, rua, bairro, cidade, estado, pais, latitude, longitude) VALUES ('$nome', '$numero', '$rua', '$bairro', '$cidade', '$estado', '$pais', '$lat', '$lng' )";

  if (mysqli_query($conexao, $check)) {
    $result = array('success' => true);
    echo json_encode($result);
  } else {
    $result = array('success' => false);
    echo json_encode($result);
  }
mysqli_close($conexao);
?>
