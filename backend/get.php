<?php


session_start();
require_once "../config.php";
require_once "config_dev.php";

if ((!isset($_SESSION['login']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['login']);
    unset($_SESSION['senha']);
    header('location:../login.php');
}

$logado = $_SESSION['login'];
$tipo_user = isset($_SESSION['tipo_user']) ? $_SESSION['tipo_user'] : "";

if($tipo_user != 'admin'){
    header("location:../index.php");
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("location:../login.php");
}

// Substitua 'SUA_CHAVE_API' pela sua chave de API real.
$apiKey = 'chave-da-api-do-chatgpt';

$tipo = mysqli_real_escape_string($con_dev, $_POST['tipo_prompt']);
$nome = mysqli_real_escape_string($con_dev, $_POST['nome_prompt']);
$nome_console  = mysqli_real_escape_string($con_dev, $_POST['nome_console']);

$titulo = "Jogo ".$nome. " - Gerado por IA";

// echo "<pre>".print_r($_GET)."</pre>";

// Texto que será enviado para o ChatGPT
$prompt = "Crie um texto para um site de museu de games em português sobre o jogo $nome, do console $nome_console. Faça um texto bem rico em informações e não utilize muitos adjetivos, num estilo de escrita de artigo jornalístico. Após criar o artigo, insira novas informações para que os parágrafos fiquem maiores. Siga a seguinte estrutura e responda na formatação de JSON proposta abaixo, com os seguintes dados. Demarque o início do parágrafo com a palavra XX_INICIO e XX_FIM para um fim de parágrafo dentro das strings do JSON
{
  historico: \"Um a dois parágrafos sobre o histórico do jogo, qual ano de publicação do jogo em seu país de origem. Se ele foi ou não publicado no Brasil, e em qual ano. Traga os dados disponíveis sobre como foi o desenvolvimento do jogo e quem foram os desenvolvedores.\",
  o_jogo: \"Dois a três parágrafos falando sobre o jogo: a narrativa (se o jogo tiver); como é seu visual; seu áudio. Um parágrafo sobre como jogar: suas mecânicas, controles, progressão, se existe algum sistema de pontuação. Um parágrafo sobre seu legado: mencionando se ele foi influente o suficiente para inspirar/influenciar outros jogos e/ou mecânicas e quais foram estes jogos e mecânicas. Também mencionar neste parágrafo em quais jogos ele se baseou/inspirou.\",
  mercado: \"Dois parágrafos sobre como o jogo se encaixa na estratégia da empresa que o desenvolveu e o seu impacto nos diversos mercados: de seu país de origem, internacionalmente e no mercado brasileiro. Traga número de vendas, premiações, possíveis recordes obtidos e outros destaques que o jogo porventura tenha obtido.\"
  curiosidades: \"Um ou dois parágrafos de curiosidades sobre o jogo: fatos desconhecidos, segredos, modificações etc. Traga aqueles que forem considerados mais escandalosos, obscuros ou interessantes.\",
  resumo: \"Um parágrafo de no máximo duas frases resumindo o conteúdo deste artigo.\",
  midia: \"tipo de mídia no qual ele foi disponibilizado\",
  desenvolvido_por: \"nome da empresa que o desenvolveu\", 
  publicado_por: \"nome da empresa que o publicou\",
  lancado_em: \"ano de lançamento, mês e data se a informação estiver disponível\",
  plataformas: \"plataformas em que foi lançado\",
  designer: \"game designer creditado no desenvolvimento do jogo\",
  compositor: \"compositor da trilha sonora do jogo, caso a informação esteja disponível\",
  taxonomia: \"gêneros de jogo em que ele se encaixa\",
  jogadores: \"número de jogadores suportados pelo jogo\",
  links_de_referencia: \"apresente sites que contenham as informações sobre o jogo mencionado\"
}";

// echo "<pre>".$prompt."</pre>";

if($tipo == "CONSOLE"){
 	// Texto que será enviado para o ChatGPT
 	$titulo = "Console ".$nome. " - Gerado por IA";
 	$prompt = "Crie um texto para um site de museu de games em português sobre o console $nome. Faça um texto rico em informações, evitando muitos adjetivos, com um estilo de escrita semelhante ao de um artigo jornalístico. Siga a estrutura e a formatação de JSON proposta abaixo e demarque o início do parágrafo com a palavra XX_INICIO e XX_FIM para um fim de parágrafo dentro das strings do JSON:
{
  historico: \"Um a dois parágrafos sobre o histórico do console, incluindo o ano de lançamento em seu país de origem e, se aplicável, no Brasil. Descreva brevemente o contexto de seu desenvolvimento, as motivações da empresa criadora e os principais desafios enfrentados na criação do console.\",
  o_console: \"Dois a três parágrafos sobre o console. Inclua informações sobre seu design visual, características técnicas (como processador, memória, etc.), inovação tecnológica e funcionalidades únicas. Um parágrafo sobre a experiência do usuário: controles, interface, conectividade, tipos de jogos suportados. Um parágrafo sobre seu legado: impacto na indústria, consoles ou tecnologias que inspirou e se foi um marco histórico.\",
  acessorios: \"Uma lista dos acessórios mais comuns ou importantes do console, incluindo controles adicionais, periféricos exclusivos e expansões de hardware relevantes.\",
  jogos: \"Uma lista dos jogos mais importantes ou expressivos lançados para o console, incluindo títulos exclusivos e aqueles que foram marcos ou representativos da plataforma.\",
  mercado: \"Dois parágrafos sobre o impacto do console no mercado. Discuta como ele se encaixou na estratégia da empresa desenvolvedora, vendas globais e desempenho no mercado nacional (se aplicável). Traga dados sobre premiações, recordes e repercussão comercial ou crítica.\",
  curiosidades: \"Um ou dois parágrafos com curiosidades sobre o console, incluindo informações pouco conhecidas, edições limitadas, periféricos exclusivos ou segredos relacionados ao desenvolvimento.\",
  resumo: \"Um parágrafo de no máximo duas frases resumindo o conteúdo deste artigo.\",
  midia: \"O tipo de mídia que o console utilizava para os jogos (cartucho, CD, digital, etc.).\",
  desenvolvido_por: \"Nome da empresa que desenvolveu o console.\", 
  publicado_por: \"Nome da empresa que o publicou, caso seja diferente da desenvolvedora.\",
  lancado_em: \"Data completa de lançamento, se disponível (ano, mês e dia).\",
  plataformas: \"Plataformas ou modelos relacionados ao console.\",
  designer: \"Nome(s) do(s) designer(s) responsável(is) pelo design do console, se houver crédito específico.\",
  compositor: \"Compositor da trilha sonora dos menus ou do sistema operacional do console, caso aplicável.\",
  taxonomia: \"Categorias ou gêneros de jogos que o console suportava de maneira relevante.\",
  jogadores: \"Número de jogadores que o console suporta (local ou online).\",
  links_de_referencia: \"Links para sites confiáveis contendo informações sobre o console.\"
}";

}

if($tipo == "ARCADE"){
 	// Texto que será enviado para o ChatGPT
 	$titulo = "Arcade ".$nome. " - Gerado por IA";
 	$prompt = "Crie um texto para um site de museu de games em português sobre o arcade machine $nome. Faça um texto bem rico em informações e não utilize muitos adjetivos, num estilo de escrita de artigo jornalístico. Siga a seguinte estrutura e responda na formatação de JSON proposta abaixo, com os seguintes dados.  Demarque o início do parágrafo com a palavra XX_INICIO e XX_FIM para um fim de parágrafo dentro das strings do JSON:
{
  historico: \"Um a dois parágrafos sobre o histórico do jogo, qual ano de publicação do jogo em seu país de origem. Se ele foi ou não publicado no Brasil, e em qual ano. Traga os dados disponíveis sobre como foi o desenvolvimento do jogo e quem foram os desenvolvedores.\",
  o_arcade: \"Dois a três parágrafos falando sobre o arcade machine: a narrativa dos principais jogos do arcade machine; como é seu visual; seu áudio. Um parágrafo sobre como jogar: suas mecânicas, controles, progressão, se existe algum sistema de pontuação. Um parágrafo sobre seu legado: mencionando se deixou um legado ao inspirar outros arcade machine e em quais arcade machine se inspirou.\",
  mercado: \"Dois parágrafos sobre como o arcade machine se encaixa na estratégia da empresa que o desenvolveu e o seu impacto nos diversos mercados: de seu país de origem, internacionalmente e no mercado brasileiro. Traga número de vendas, premiações, possíveis recordes obtidos e outros destaques que o arcade machine porventura tenha obtido.\"
  curiosidades: \"Um ou dois parágrafos de curiosidades sobre o arcade machine: fatos desconhecidos, segredos, etc. Traga aqueles que forem considerados mais obscuros ou interessantes.\",
  resumo: \"Um parágrafo de no máximo duas frases resumindo o conteúdo deste artigo.\",
  midia: \"tipo de mídia no qual os jogos do arcade machine eram disponibilizados\",
  desenvolvido_por: \"nome da empresa que o desenvolveu\", 
  publicado_por: \"nome da empresa que o publicou\",
  lancado_em: \"ano de lançamento, mês e data se a informação estiver disponível\",
  plataformas: \"plataformas em que foi lançado\",
  designer: \"designer creditado no desenvolvimento do arcade machine\",
  compositor: \"compositor da trilha sonora do arcade machine, caso a informação esteja disponível\",
  taxonomia: \"gêneros de jogo em que ele se encaixa\",
  jogadores: \"número de jogadores suportados pelo arcade machine\",
  links_de_referencia: \"apresente sites que contenham as informações sobre o arcade machine mencionado\"
}";

}

// Preparando os dados da solicitação
$data = [
    'model' => 'gpt-4o',
    'messages' => [
        [
            "role" => "user",
            "max_tokens"=>"8000",
            "content" => $prompt
        ]
    ],
    'temperature' => 0.2
];

// Configuração e execução da chamada cURL para a API de chat da OpenAI
$ch = curl_init('https://api.openai.com/v1/chat/completions');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey,
]);

$response = curl_exec($ch);
curl_close($ch);

if ($response) {
	$response = str_replace("```json","",$response);  
    $response = str_replace("```","",$response);   
	echo $response;
} else {
    echo "Não foi possível obter uma resposta da OpenAI.";
}

?>