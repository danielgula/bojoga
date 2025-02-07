<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once "../config.php";
require_once "config_dev.php";

if ((!isset($_SESSION['login']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['login']);
    unset($_SESSION['senha']);
    header('location:login.php');
}

$logado = $_SESSION['login'];
$tipo_user = isset($_SESSION['tipo_user']) ? $_SESSION['tipo_user'] : "";

if($tipo_user != 'admin'){
    header("location:index.php");
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("location:login.php");
}

$historico = "EM BRANCO";
$o_jogo = "EM BRANCO";
$mercado = "EM BRANCO";
$curiosidades = "EM BRANCO";
$resumo = "EM BRANCO";
$midia = "EM BRANCO";
$desenvolvido_por = "EM BRANCO";
$publicado_por = "EM BRANCO";
$lancado_em = "EM BRANCO";
$plataformas = "EM BRANCO";
$designer = "EM BRANCO";
$compositor = "EM BRANCO";
$taxonomia = "EM BRANCO";
$jogadores = "EM BRANCO";
$links_de_referencia = "EM BRANCO";


$tipo = $_POST['tipo_prompt'];
$nome = $_POST['nome_prompt'];
$nome_console  = $_POST['nome_console'];
$resumo = $_POST['resumo'];


$titulo = "Jogo ".$nome. " - Gerado por IA";
if($tipo == "CONSOLE")
    $titulo = "Console ".$nome. " - Gerado por IA";
if($tipo == "ARCADE")
    $titulo = "Arcade ".$nome. " - Gerado por IA";

$postagem = "";

if(isset($_POST["resumo"]))
	$resumo = $_POST["resumo"];


if(isset($_POST["historico"]))
	$postagem .= retornaEmH1("Histórico").retornaEmP($_POST["historico"]);
if(isset($_POST["o_jogo"]))
	$postagem .= retornaEmH1("Introdução").retornaEmP($_POST["o_jogo"]);
if(isset($_POST["mercado"]))
	$postagem .= retornaEmH1("Mercado").retornaEmP($_POST["mercado"]);
if(isset($_POST["acessorios"])){
    $postagem .= retornaEmH1("Acessórios");
    
    //Inicia lista UL
	$postagem .= "<ul>";
    foreach($_POST["acessorios"] as $itens) {
	        $postagem .= retornaEmLI( $itens);
    }
	//Finaliza lista UL
	$postagem .= "</ul>";
}
if(isset($_POST["jogos"])){
    $postagem .= retornaEmH1("jogos");
    
    //Inicia lista UL
	$postagem .= "<ul>";
    foreach($_POST["jogos"] as $itens) {
	        $postagem .= retornaEmLI( $itens);
    }
	//Finaliza lista UL
	$postagem .= "</ul>";
}
if(isset($_POST["modelo3d"]))
	$postagem .= retornaEmH1("Modelo 3D").retornaEmP($_POST["modelo3d"]);
if(isset($_POST["galeria"]))
	$postagem .= retornaEmH1("Galeria").retornaEmP($_POST["galeria"]);
	
$postagem .= retornaEmH1("Ficha Técnica");
//Inicia lista UL
$postagem .= "<ul>";
if(isset($_POST["desenvolvido_por"]))
	$postagem .= retornaEmLI(retornaEmStrong("Desenvolvido Por: ").$_POST["desenvolvido_por"]);
if(isset($_POST["publicado_por"]))
	$postagem .= retornaEmLI(retornaEmStrong("Publicado Por: ").$_POST["publicado_por"]);
if(isset($_POST["midia"]))
	$postagem .= retornaEmLI(retornaEmStrong("Mídia: ").$_POST["midia"]);
if(isset($_POST["lancado_em"]))
	$postagem .= retornaEmLI(retornaEmStrong("Lançado Em: ").$_POST["lancado_em"]);
if(isset($_POST["plataformas"]))
	$postagem .= retornaEmLI(retornaEmStrong("Plataformas: ").$_POST["plataformas"]);
if(isset($_POST["designer"]))
	$postagem .= retornaEmLI(retornaEmStrong("Designer: ").$_POST["designer"]);
if(isset($_POST["compositor"]))
	$postagem .= retornaEmLI(retornaEmStrong("Compositor: ").$_POST["compositor"]);
if(isset($_POST["taxonomia"]))
	$postagem .= retornaEmLI(retornaEmStrong("Taxonomia: ").$_POST["taxonomia"]);
if(isset($_POST["jogadores"]))
	$postagem .= retornaEmLI(retornaEmStrong("Jogadores: ").$_POST["jogadores"]);
//Finaliza lista UL
$postagem .= "</ul>";

if(isset($_POST["curiosidades"]))
	$postagem .= retornaEmH1("Curiosidades").retornaEmP($_POST["curiosidades"]);
if(isset($_POST["referencias"]))
	$postagem .= retornaEmH1("Referências").retornaEmP($_POST["referencias"]);
if(isset($_POST["links_de_referencia"])){
	$postagem .= retornaEmH1("Links de Referencia");
	
	//Inicia lista UL
	$postagem .= "<ul>";
    foreach($_POST["links_de_referencia"] as $link) {
	        $postagem .= retornaEmLI( retornaEmLink($link));
    }
	//Finaliza lista UL
	$postagem .= "</ul>";
}

//troca o XX_INICIO/FIM por <p> e </p>, usado para sanar problemas no get.php
$postagem = str_replace("XX_INICIO","<p>",$postagem);  
$postagem = str_replace("XX_FIM","</p>",$postagem);

$postagemTratada = $postagem;

$state = $conn_dev_stmt->prepare("INSERT INTO wp_8_posts (post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt, post_status, comment_status, ping_status, post_password, post_name, to_ping, pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid, menu_order, post_type, post_mime_type, comment_count)
		  VALUES
		  (85, NOW(), NOW(), ?, ?, ?, 'pending', 'open', 'open', '', 'slug-da-postagem', '', '', NOW(), NOW(), '', 0, 'https://bojoga.com.br/?p=', 0, 'post', '', 0);");
$state->bind_param("sss", $postagemTratada, $titulo, $resumo);


if ($state->execute() and $state->affected_rows > 0) {
    echo "Registro inserido com sucesso!";
} else {
    echo "Erro ao inserir: " . $state->error;
}

	
echo "<pre>". print_r($_POST)."</pre>";
echo "<br><br>";
echo "<pre>". $postagemTratada."</pre>";

$state->close();

function retornaEmH1($texto){   return "<h1>".$texto."</h1>". PHP_EOL;}

function retornaEmP($texto){   return "<p>".$texto."</p>". PHP_EOL;}

function retornaEmStrong($texto){   return "<strong>".$texto."</strong>";}

function retornaEmLI($texto){   return "<li>".$texto."</li>";}

function retornaEmLink($texto){   return "<a href=\"$texto\">$texto</a>";}

?>