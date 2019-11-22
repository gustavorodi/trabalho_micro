<?php
use App\Controller\UsuariosController;

$nome = new UsuariosController();
$lista = $nome->index();

?>
<h1>Usuários</h1>
