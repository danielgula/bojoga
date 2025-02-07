<?php
session_start();
require_once "config.php";
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
?>
<!DOCTYPE html>
<htm>

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>bojoga | Admin</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css" />
        <link href="js/bootstrapValidator/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="css/bjadmin.css" />
        <script type="text/javascript" src="assets/js/jquery/jquery-1.12.4.min.js"></script>

        <script src="js/bootstrapValidator/js/bootstrapValidator.min.js" type="text/javascript"></script>

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.all.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/frmai.css">
    </head>

    <body>
        <div class="main">
            <header>
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="./">
                                <img src="./assets/image/logo-bojoga.png" style="width:200px; margin-top: -7px;"
                                    class="" alt="" />
                            </a>
                        </div>
                        <div id="navbar" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">
                                <?php echo $logado == "Login" ? "" : 
                            "<li>
                                <a href='./frmregistros.php'>Registros</a>
                            </li>";
							echo "<li><a href='./frmai.php'>Postar com IA</a></li>";
                            echo "<li>
                                <a href='./frmcategorias.php'>Categorias</a>
                            </li>";
                            echo $tipo_user == "admin" ? "<li>
                                <a href='./frmbackgrounds.php'>Backgrounds</a>
                            </li><li class='active'>
                                <a href='./frmeditores.php'>Editores</a>
                            </li>" : "";
                            echo "<li>
                                <a href='./vertimeline.php'>Ver timeline</a>
                            </li>";
                            echo $tipo_user == "admin" ? "<li>
                                <a href='./frmgerartimeline.php'>Gerar Timeline</a>
                            </li>" : "";
                        ?>

                            </ul>
                            <div style="position:absolute;
                    right:20px; padding: 15px 0;">

                                <?php
                        if ($logado == "Login") {
                            ?>
                                <span><a href="login.php">
                                        <?php echo $logado ?></a>
                                </span>
                                <?php
                        } else {
                            ?>
                                <span><?php echo $logado ?> |
                                    <a href="?logout=true">sair</a>
                                </span>
                                <?php
                        }
                        ?>
                            </div>
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                    <!--/.container-fluid -->
                </nav>
            </header>
            <br />
            <div class="container">

                <div class="form-group row">
                    <div class="form-group row">

                        <div class="col-sm-12">
                            <label for="tipo_prompt">TIPO DE POST</label>
                            <select name="tipo_prompt" id="tipo_prompt" class="form-control" onchange="alteraLabel();">
                                <option value="JOGO" data-available_text="JOGO" selected>JOGO</option>
                                <option value="CONSOLE" data-available_text="CONSOLE">CONSOLE</option>
                                <option value="ARCADE" data-available_text="ARCADE">ARCADE</option>
                            </select>
                        </div>

                        <div class="col-sm-12">
                            <label for="nome_prompt" id='labelNome'>NOME DO JOGO</label>
                            <input list="nome_jogo" type="text" name="nome_prompt" id="nome_prompt" class="form-control"
                                value="bomberman" />
                        </div>

                        <div class="col-sm-12" id="div_nome_console">
                            <label for="nome_console" id='labelNome'>NOME DO CONSOLE</label>
                            <input list="consoles" type="text" name="nome_console" id="nome_console"
                                class="form-control" hidden value="Super Nintendo" />
                        </div>





                    </div>
                    <div class="grupoBotoesCinza align-middle">
                        <button onclick="getPost();" id="bt_gerar" hidden class="btn btn-primary">Refinar
                            Secionados</button>
                        <button onclick="gerarTudo();" id="bt_gerar_tudo" class="btn btn-primary">Gerar Tudo</button>
                        <button onclick="aprovarPost();" id="bt_aprovar_post" hidden class="btn btn-primary">Aprovar
                            Post</button>
                    </div>
                </div>

                <div class="col-sm-12 div-dados">
                    HISTORICO: <input onclick="selecionaRefazer();" type="checkbox" id="ck_historico"> (marque para
                    refinar)
                </div>
                <div class="dados" name="historico" id="historico"></div>


                <div class="col-sm-12 div-dados">
                    <span id="ds_nome">O JOGO: </span><input onclick="selecionaRefazer();" type="checkbox"
                        id="ck_o_jogo"> (marque para refinar)
                </div>
                <div class="dados" name="o_jogo" id="o_jogo"></div>

                <div class="col-sm-12 div-dados somenteConsole">
                    <span>ACESSÓRIOS: </span><input onclick="selecionaRefazer();" type="checkbox" id="ck_acessorios">
                    (marque para refinar)
                </div>
                <div class="acessorios somenteConsole" name="acessorios" id="acessorios"></div>

                <div class="col-sm-12 div-dados somenteConsole">
                    <span>JOGOS: </span><input onclick="selecionaRefazer();" type="checkbox" id="ck_jogos"> (marque para
                    refinar)
                </div>
                <div class="jogos somenteConsole" name="jogos" id="jogos"></div>


                <div class="col-sm-12 div-dados">
                    MERCADO: <input onclick="selecionaRefazer();" type="checkbox" id="ck_mercado"> (marque para refinar)
                </div>
                <div class="dados" name="mercado" id="mercado"></div>


                <div class="col-sm-12 div-dados">
                    CURIOSIDADES: <input onclick="selecionaRefazer();" type="checkbox" id="ck_curiosidades"> (marque
                    para refinar)
                </div>
                <div class="dados" name="curiosidades" id="curiosidades"></div>


                <div class="col-sm-12 div-dados">
                    RESUMO: <input onclick="selecionaRefazer();" type="checkbox" id="ck_resumo"> (marque para refinar)
                </div>
                <div class="dados" name="resumo" id="resumo"></div>


                <div class="col-sm-12 div-dados">
                    MÍDIA: <input onclick="selecionaRefazer();" type="checkbox" id="ck_midia"> (marque para refinar)
                </div>
                <div class="dados" name="midia" id="midia"></div>


                <div class="col-sm-12 div-dados">
                    DESENVOLVIDO POR: <input onclick="selecionaRefazer();" type="checkbox" id="ck_desenvolvido_por">
                    (marque para refinar)
                </div>
                <div class="dados" name="desenvolvido_por" id="desenvolvido_por"></div>


                <div class="col-sm-12 div-dados">
                    PUBLICADO POR: <input onclick="selecionaRefazer();" type="checkbox" id="ck_publicado_por"> (marque
                    para refinar)
                </div>
                <div class="dados" name="publicado_por" id="publicado_por"></div>


                <div class="col-sm-12 div-dados">
                    LANCADO EM: <input onclick="selecionaRefazer();" type="checkbox" id="ck_lancado_em"> (marque para
                    refinar)
                </div>
                <div class="dados" name="lancado_em" id="lancado_em"></div>


                <div class="col-sm-12 div-dados">
                    PLATAFORMAS: <input onclick="selecionaRefazer();" type="checkbox" id="ck_plataformas"> (marque para
                    refinar)
                </div>
                <div class="dados" name="plataformas" id="plataformas"></div>


                <div class="col-sm-12 div-dados">
                    DESIGNER: <input onclick="selecionaRefazer();" type="checkbox" id="ck_designer"> (marque para
                    refinar)
                </div>
                <div class="dados" name="designer" id="designer"></div>


                <div class="col-sm-12 div-dados">
                    COMPOSITOR: <input onclick="selecionaRefazer();" type="checkbox" id="ck_compositor"> (marque para
                    refinar)
                </div>
                <div class="dados" name="compositor" id="compositor"></div>


                <div class="col-sm-12 div-dados">
                    TAXONOMIA: <input onclick="selecionaRefazer();" type="checkbox" id="ck_taxonomia"> (marque para
                    refinar)
                </div>
                <div class="dados" name="taxonomia" id="taxonomia"></div>


                <div class="col-sm-12 div-dados">
                    JOGADORES: <input onclick="selecionaRefazer();" type="checkbox" id="ck_jogadores"> (marque para
                    refinar)
                </div>
                <div class="dados" name="jogadores" id="jogadores"></div>


                <div class="col-sm-12 div-dados">
                    LINKS DE REFERENCIA: <input onclick="selecionaRefazer();" type="checkbox"
                        id="ck_links_de_referencia"> (marque para refinar)</div>
                <div class="dados" name="links_de_referencia" id="links_de_referencia"></div>

                <datalist id="consoles">
                    <option value="Color TV-Game">
                    <option value="Nintendo Entertainment System">
                    <option value="Game Boy">
                    <option value="Super Nintendo Entertainment System">
                    <option value="Virtual Boy">
                    <option value="Nintendo 64">
                    <option value="Game Boy Color">
                    <option value="Game Boy Advance">
                    <option value="Nintendo GameCube">
                    <option value="Game Boy Advance SP">
                    <option value="Nintendo DS">
                    <option value="Nintendo DS Lite">
                    <option value="Wii">
                    <option value="Nintendo DSi">
                    <option value="Nintendo 3DS">
                    <option value="Wii U">
                    <option value="Nintendo 3DS XL">
                    <option value="New Nintendo 3DS">
                    <option value="Nintendo Switch">
                    <option value="Nintendo Switch Lite">
                    <option value="Nintendo Switch OLED">
                    <option value="PlayStation">
                    <option value="PlayStation 2">
                    <option value="PlayStation Portable">
                    <option value="PlayStation 3">
                    <option value="PlayStation Vita">
                    <option value="PlayStation 4">
                    <option value="PlayStation 5">
                    <option value="Xbox">
                    <option value="Xbox 360">
                    <option value="Xbox One">
                    <option value="Xbox Series X">
                    <option value="Xbox Series S">
                    <option value="SG-1000">
                    <option value="Master System">
                    <option value="Game Gear">
                    <option value="Genesis (Mega Drive)">
                    <option value="Sega CD">
                    <option value="32X">
                    <option value="Saturn">
                    <option value="Dreamcast">
                    <option value="Atari 2600">
                    <option value="Atari 5200">
                    <option value="Atari 7800">
                    <option value="Atari Jaguar">
                    <option value="Atari Lynx">
                    <option value="Magnavox Odyssey">
                    <option value="ColecoVision">
                    <option value="Intellivision">
                    <option value="TurboGrafx-16">
                    <option value="Neo Geo">
                    <option value="TurboGrafx-CD">
                    <option value="3DO Interactive Multiplayer">
                    <option value="Philips CD-i">
                    <option value="Apple Pippin">
                    <option value="Magnavox Odyssey 2">
                    <option value="Coleco Gemini">
                    <option value="Coleco Telstar">
                    <option value="Intellivision II">
                    <option value="Intellivision III">
                    <option value="Atari XEGS">
                    <option value="Sega Pico">
                    <option value="SuperGrafx">
                    <option value="Neo Geo CD">
                    <option value="Neo Geo Pocket">
                    <option value="Neo Geo Pocket Color">
                    <option value="Atari Flashback">
                    <option value="Sony PlayStation Classic">
                    <option value="HyperScan">
                    <option value="Gizmondo">
                    <option value="Tapwave Zodiac">
                    <option value="Caanoo">
                    <option value="Pandora's Box">
                    <option value="Anbernic RG351">
                    <option value="Powkiddy">
                </datalist>
                <datalist id="nome_jogo">
                    <option value="Tennis for Two">
                    <option value="Pong">
                    <option value="Spacewar!">
                    <option value="Computer Space">
                    <option value="Maze War">
                    <option value="The Game of Life">
                    <option value="Casse-Tête">
                    <option value="Monaco GP">
                    <option value="Othello">
                    <option value="Table Tennis">
                    <option value="Avoider">
                    <option value="King of the Hill">
                    <option value="Galaxy Game">
                    <option value="Star Wars (arcade)">
                    <option value="Atari Football">
                    <option value="Atari Baseball">
                    <option value="Pong Doubles">
                    <option value="Breakout">
                    <option value="Space Invaders">
                    <option value="Asteroids">
                    <option value="Lunar Lander">
                    <option value="Missile Command">
                    <option value="Tempest">
                    <option value="Centipede">
                    <option value="Dig Dug">
                    <option value="Pole Position">
                    <option value="Pac-Man">
                    <option value="Galaga">
                    <option value="Donkey Kong">
                    <option value="Galaxian">
                    <option value="Zaxxon">
                    <option value="Adventure (Atari 2600)">
                    <option value="Combat (Atari 2600)">
                    <option value="Space Race">
                    <option value="Warlords">
                    <option value="Breakout (arcade)">
                    <option value="Space Invaders (arcade)">
                    <option value="Burgertime">
                    <option value="Dragon's Lair">
                    <option value="Computer Space">
                    <option value="Pong Doubles">
                    <option value="Space Race">
                    <option value="Breakout">
                    <option value="Gun Fight">
                    <option value="Combat (Atari 2600)">
                    <option value="Adventure (Atari 2600)">
                    <option value="Space Invaders">
                    <option value="Asteroids">
                    <option value="Missile Command">
                    <option value="Centipede">
                    <option value="Galaga">
                    <option value="Dig Dug">
                    <option value="Pac-Man">
                    <option value="Galaxian">
                    <option value="Defender">
                    <option value="Pole Position">
                    <option value="Zaxxon">
                    <option value="Q*bert">
                    <option value="Donkey Kong">
                    <option value="Donkey Kong Jr.">
                    <option value="Ms. Pac-Man">
                    <option value="Joust">
                    <option value="Robotron: 2084">
                    <option value="Tron (arcade)">
                    <option value="Frogger">
                    <option value="Asteroids Deluxe">
                    <option value="Tempest">
                    <option value="Battlezone">
                    <option value="Space Invaders Part II">
                    <option value="Dig Dug II">
                    <option value="Food Fight">
                    <option value="Gyruss">
                    <option value="Moon Patrol">
                    <option value="Kaboom!">
                    <option value="Missile Command (arcade)">
                    <option value="Atari Football">
                    <option value="Atari Baseball">
                    <option value="Lunar Lander">
                    <option value="Star Wars (arcade)">
                    <option value="Donkey Kong Jr.">
                    <option value="Ms. Pac-Man">
                    <option value="Q*bert">
                    <option value="Galaga">
                    <option value="Pole Position II">
                    <option value="Centipede">
                    <option value="Dig Dug II">
                    <option value="Frogger">
                    <option value="Joust">
                    <option value="Defender">
                    <option value="Robotron: 2084">
                    <option value="Tempest">
                    <option value="Pac-Man Plus">
                    <option value="Asteroids Deluxe">
                    <option value="Moon Patrol">
                    <option value="Xevious">
                    <option value="Ms. Pac-Man">
                    <option value="Gyruss">
                    <option value="Galaxian">
                    <option value="Tetris">
                    <option value="Mario Bros.">
                    <option value="Donkey Kong 3">
                    <option value="Double Dragon">
                    <option value="Bubble Bobble">
                    <option value="R-Type">
                    <option value="Contra">
                    <option value="Mega Man">
                    <option value="Castlevania">
                    <option value="Teenage Mutant Ninja Turtles">
                    <option value="Punch-Out!!">
                    <option value="Gradius">
                    <option value="Dr. Mario">
                    <option value="Arkanoid">
                    <option value="Street Fighter">
                    <option value="1942">
                    <option value="Gauntlet">
                    <option value="Commando">
                    <option value="Track & Field">
                    <option value="Final Fight">
                    <option value="Operation Wolf">
                    <option value="Shadow Dancer">
                    <option value="Altered Beast">
                    <option value="Shinobi">
                    <option value="Out Run">
                    <option value="Space Harrier">
                    <option value="Zaxxon 3-D">
                    <option value="Gauntlet II">
                    <option value="Street Fighter II">
                    <option value="Mortal Kombat">
                    <option value="Sonic the Hedgehog 2">
                    <option value="Doom">
                    <option value="Warcraft: Orcs & Humans">
                    <option value="Secret of Mana">
                    <option value="Super Mario Kart">
                    <option value="Castlevania: Symphony of the Night">
                    <option value="EarthBound">
                    <option value="Final Fantasy VI">
                    <option value="The Legend of Zelda: Link's Awakening">
                    <option value="Donkey Kong Country">
                    <option value="Teenage Mutant Ninja Turtles IV: Turtles in Time">
                    <option value="Aladdin">
                    <option value="Gradius III">
                    <option value="Star Fox">
                    <option value="Chrono Trigger">
                    <option value="Super Metroid">
                    <option value="Duke Nukem II">
                    <option value="Monkey Island 2: LeChuck's Revenge">
                    <option value="SimCity 2000">
                    <option value="Tomb Raider">
                    <option value="System Shock">
                    <option value="Magic: The Gathering">
                    <option value="X-COM: UFO Defense">
                    <option value="Day of the Tentacle">
                    <option value="Lemmings">
                    <option value="Final Fantasy IV">
                    <option value="Dune II">
                    <option value="F-Zero">
                    <option value="Star Wars: Tie Fighter">
                    <option value="Road Rash">
                    <option value="Civilization">
                    <option value="Chrono Trigger">
                    <option value="Command & Conquer">
                    <option value="Final Fantasy VII">
                    <option value="Diablo">
                    <option value="Quake">
                    <option value="Warcraft II: Tides of Darkness">
                    <option value="Resident Evil">
                    <option value="Star Wars: Dark Forces">
                    <option value="Tomb Raider">
                    <option value="Rayman">
                    <option value="Duke Nukem 3D">
                    <option value="Tekken 3">
                    <option value="Street Fighter Alpha 2">
                    <option value="The Need for Speed">
                    <option value="Descent II">
                    <option value="Command & Conquer: Red Alert">
                    <option value="F-Zero X">
                    <option value="Magic: The Gathering">
                    <option value="Day of the Tentacle">
                    <option value="Lemmings 3D">
                    <option value="System Shock 2">
                    <option value="Myst">
                    <option value="Mortal Kombat 3">
                    <option value="SimCity 3000">
                    <option value="Dark Forces II: Jedi Knight">
                    <option value="Fallout">
                    <option value="Mega Man X3">
                    <option value="StarCraft">
                    <option value="The Legend of Zelda: Link's Awakening DX">
                    <option value="Final Fantasy VII">
                    <option value="Half-Life">
                    <option value="The Legend of Zelda: Ocarina of Time">
                    <option value="Metal Gear Solid">
                    <option value="StarCraft">
                    <option value="Gran Turismo">
                    <option value="Diablo II">
                    <option value="Baldur's Gate">
                    <option value="Age of Empires II">
                    <option value="System Shock 2">
                    <option value="Tomb Raider II">
                    <option value="Unreal Tournament">
                    <option value="Resident Evil 2">
                    <option value="Planescape: Torment">
                    <option value="Counter-Strike">
                    <option value="Halo: Combat Evolved">
                    <option value="Grand Theft Auto III">
                    <option value="The Elder Scrolls III: Morrowind">
                    <option value="Max Payne">
                    <option value="Metal Gear Solid 2: Sons of Liberty">
                    <option value="Jak and Daxter: The Precursor Legacy">
                    <option value="Halo 2">
                    <option value="Grand Theft Auto: Vice City">
                    <option value="World of Warcraft">
                    <option value="Half-Life 2">
                    <option value="Silent Hill 2">
                    <option value="Far Cry">
                    <option value="Fable">
                    <option value="Half-Life 2: Episode One">
                    <option value="Call of Duty 2">
                    <option value="God of War">
                    <option value="Resident Evil 4">
                    <option value="The Elder Scrolls IV: Oblivion">
                    <option value="BioShock">
                    <option value="Mass Effect">
                    <option value="Portal">
                    <option value="Call of Duty 4: Modern Warfare">
                    <option value="Uncharted: Drake's Fortune">
                    <option value="Assassin's Creed">
                    <option value="Super Mario Galaxy">
                    <option value="Grand Theft Auto IV">
                    <option value="Left 4 Dead">
                    <option value="Batman: Arkham Asylum">
                    <option value="Red Dead Redemption">
                    <option value="Minecraft">
                    <option value="The Elder Scrolls V: Skyrim">
                    <option value="Dark Souls">
                    <option value="Portal 2">
                    <option value="The Witcher 2: Assassins of Kings">
                    <option value="Batman: Arkham City">
                    <option value="Diablo III">
                    <option value="Far Cry 3">
                    <option value="Halo 4">
                    <option value="Tomb Raider (2013)">
                    <option value="Bioshock Infinite">
                    <option value="Grand Theft Auto V">
                    <option value="The Last of Us">
                    <option value="Assassin's Creed IV: Black Flag">
                    <option value="Watch Dogs">
                    <option value="Dark Souls II">
                    <option value="Dragon Age: Inquisition">
                    <option value="Destiny">
                    <option value="The Witcher 3: Wild Hunt">
                    <option value="Bloodborne">
                    <option value="Horizon Zero Dawn">
                    <option value="Overwatch">
                    <option value="Persona 5">
                    <option value="Dark Souls III">
                    <option value="Red Dead Redemption II">
                    <option value="Sekiro: Shadows Die Twice">
                    <option value="Death Stranding">
                    <option value="Cyberpunk 2077">
                    <option value="Ghost of Tsushima">
                    <option value="Demon's Souls (Remake)">
                    <option value="Elden Ring">
                    <option value="Resident Evil Village">
                    <option value="Ratchet & Clank: Rift Apart">
                    <option value="Returnal">
                    <option value="Hades">
                    <option value="Final Fantasy VII Remake">
                    <option value="Starfield">
                    <option value="Hogwarts Legacy">
                    <option value="Marvel's Spider-Man: Miles Morales">
                    <option value="God of War Ragnarök">
                    <option value="The Legend of Zelda: Tears of the Kingdom">
                    <option value="Baldur's Gate III">
                    <option value="Forspoken">
                    <option value="Stray">
                    <option value="Gran Turismo 7">
                    <option value="A Plague Tale: Requiem">
                    <option value="Hollow Knight: Silksong">
                    <option value="Dying Light 2">
                    <option value="Color TV-Game">
                    <option value="Nintendo Entertainment System">
                    <option value="Game Boy">
                    <option value="Super Nintendo Entertainment System">
                    <option value="Virtual Boy">
                    <option value="Nintendo 64">
                    <option value="Game Boy Color">
                    <option value="Game Boy Advance">
                    <option value="Nintendo GameCube">
                    <option value="Game Boy Advance SP">
                    <option value="Nintendo DS">
                    <option value="Nintendo DS Lite">
                    <option value="Wii">
                    <option value="Nintendo DSi">
                    <option value="Nintendo 3DS">
                    <option value="Wii U">
                    <option value="Nintendo 3DS XL">
                    <option value="New Nintendo 3DS">
                    <option value="Nintendo Switch">
                    <option value="Nintendo Switch Lite">
                    <option value="Nintendo Switch OLED">
                    <option value="PlayStation">
                    <option value="PlayStation 2">
                    <option value="PlayStation Portable">
                    <option value="PlayStation 3">
                    <option value="PlayStation Vita">
                    <option value="PlayStation 4">
                    <option value="PlayStation 5">
                    <option value="Xbox">
                    <option value="Xbox 360">
                    <option value="Xbox One">
                    <option value="Xbox Series X">
                    <option value="Xbox Series S">
                    <option value="SG-1000">
                    <option value="Master System">
                    <option value="Game Gear">
                    <option value="Genesis (Mega Drive)">
                    <option value="Sega CD">
                    <option value="32X">
                    <option value="Saturn">
                    <option value="Dreamcast">
                    <option value="Atari 2600">
                    <option value="Atari 5200">
                    <option value="Atari 7800">
                    <option value="Atari Jaguar">
                    <option value="Atari Lynx">
                    <option value="Magnavox Odyssey">
                    <option value="ColecoVision">
                    <option value="Intellivision">
                    <option value="TurboGrafx-16">
                    <option value="Neo Geo">
                    <option value="TurboGrafx-CD">
                    <option value="3DO Interactive Multiplayer">
                    <option value="Philips CD-i">
                    <option value="Apple Pippin">
                    <option value="Magnavox Odyssey 2">
                    <option value="Coleco Gemini">
                    <option value="Coleco Telstar">
                    <option value="Intellivision II">
                    <option value="Intellivision III">
                    <option value="Atari XEGS">
                    <option value="Sega Pico">
                    <option value="SuperGrafx">
                    <option value="Neo Geo CD">
                    <option value="Neo Geo Pocket">
                    <option value="Neo Geo Pocket Color">
                    <option value="Atari Flashback">
                    <option value="Sony PlayStation Classic">
                    <option value="HyperScan">
                    <option value="Gizmondo">
                    <option value="Tapwave Zodiac">
                    <option value="Caanoo">
                    <option value="Pandora's Box">
                    <option value="Anbernic RG351">
                    <option value="Powkiddy">
                </datalist>


            </div>
            <footer>
            </footer>
        </div>
    </body>
    <script src="js/frmai.js"></script>

    </html>