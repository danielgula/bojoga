document.getElementById("bt_gerar").style.display = "none";
    document.getElementById("bt_aprovar_post").style.display = "none";
    ocultaTagsClasse('somenteConsole')
    ocultaTagsClasse('somenteArcade')

    var dados;
    var dadosJson;
    var primeiraExecucao = true

    function alteraLabel() {
        let e = document.getElementById("tipo_prompt");

        if (e.value == "JOGO") {
            document.getElementById('labelNome').innerHTML = "NOME DO JOGO"
            document.getElementById('ds_nome').innerText = "O JOGO: "

            document.getElementById("nome_console").style.display = "inline";
            document.getElementById("div_nome_console").style.display = "inline";
            
            ocultaTagsClasse('somenteConsole');
            ocultaTagsClasse('somenteArcade');
            
        }
        if (e.value == "CONSOLE") {
            document.getElementById('labelNome').innerHTML = "NOME DO CONSOLE"
            document.getElementById('ds_nome').innerText = "O CONSOLE: "

            document.getElementById("nome_console").style.display = "none";
            document.getElementById("div_nome_console").style.display = "none";
            
            ocultaTagsClasse('somenteArcade');
            desocultaTagsClasse('somenteConsole');

        }
        if (e.value == "ARCADE") {
            document.getElementById('labelNome').innerHTML = "NOME DO ARCADE"
            document.getElementById('ds_nome').innerText = "O ARCADE: "

            document.getElementById("nome_console").style.display = "none";
            document.getElementById("div_nome_console").style.display = "none";

            //ocultaTagsClasse('somenteConsole');
            desocultaTagsClasse('somenteArcade');
            desocultaTagsClasse('somenteConsole');

        }
    }
    
    function ocultaTagsClasse(nomeClass){
        let tam = document.getElementsByClassName(nomeClass).length
        for(i = 0; i < tam; i++){
            document.getElementsByClassName(nomeClass)[i].style.display = "none";
        }
        
    }
    
    function desocultaTagsClasse(nomeClass){
        let tam = document.getElementsByClassName(nomeClass).length
        for(i = 0; i < tam; i++){
            document.getElementsByClassName(nomeClass)[i].style.display = "inline";
        }
        
    }
    

    function getPost() {
        animLoading();

        ajaxRequest = $.ajax({
            url: 'backend/get.php', // Altere para a URL do seu endpoint
            type: 'POST',
            dataType: 'json', // Pode ser 'json', 'html', etc., conforme a resposta esperada
            data: {
                'nome_prompt': document.getElementById('nome_prompt').value,
                'tipo_prompt': document.getElementById('tipo_prompt').value,
                'nome_console': document.getElementById('nome_console').value
            },
            success: function(data) {
                // Manipule a resposta aqui
                console.log(data.choices[0].message.content);
                dados = data.choices[0].message.content;
                dadosJson = JSON.parse(dados);

            },
            error: function(xhr, status, error) {
                console.error('Erro:', error);
                console.log(error);
                Swal.close();


            },
            complete: function() {
                Swal.close();
                preencheCampos();
				delXXs()
            }
        });

        // Verificando o estado da requisição
        const checkAjaxStatus = setInterval(function() {
            if (ajaxRequest.readyState === 4) {
                clearInterval(checkAjaxStatus); // Para a verificação se já retornou
                console.log('A requisição AJAX foi completada.');
            } else {
                console.log('Aguardando resposta da requisição AJAX...');
            }
        }, 100); // Verifica a cada 100 ms

    }

    function aprovarPost() {
        animLoadingPostando();
        
        let e = document.getElementById("tipo_prompt");

        if (e.value == "JOGO") {
            ajaxRequest = $.ajax({
            url: 'backend/cria.php', // Altere para a URL do seu endpoint
            type: 'POST',
            dataType: 'text', // Pode ser 'json', 'html', etc., conforme a resposta esperada
            data: {
                'nome_prompt': document.getElementById('nome_prompt').value,
                'tipo_prompt': document.getElementById('tipo_prompt').value,
                'nome_console': document.getElementById('nome_console').value,
                'historico': dadosJson.historico,
                'o_jogo': dadosJson.o_jogo,
                'mercado': dadosJson.mercado,
                'curiosidades': dadosJson.curiosidades,
                'resumo': dadosJson.resumo,
                'midia': dadosJson.midia,
                'desenvolvido_por': dadosJson.desenvolvido_por,
                'publicado_por': dadosJson.publicado_por,
                'lancado_em': dadosJson.lancado_em,
                'plataformas': dadosJson.plataformas,
                'designer': dadosJson.designer,
                'compositor': dadosJson.compositor,
                'taxonomia': dadosJson.taxonomia,
                'jogadores': dadosJson.jogadores,
                'links_de_referencia': dadosJson.links_de_referencia
            },
            success: function(data) {
                // Manipule a resposta aqui
                console.log('Sucesso: ', data);
            },
            error: function(xhr, status, error) {
                console.error('Erro:', error);
                console.log(error);
                Swal.close();

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Erro ao criar a postagem",
                    showConfirmButton: false,
                    timer: 4000
                });


            },
            complete: function() {
                Swal.close();

                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Postagem criada",
                    showConfirmButton: false,
                    timer: 4000
                });
            }
        });
        }
        else if (e.value == "CONSOLE") {
            ajaxRequest = $.ajax({
            url: 'backend/cria.php', // Altere para a URL do seu endpoint
            type: 'POST',
            dataType: 'text', // Pode ser 'json', 'html', etc., conforme a resposta esperada
            data: {
                'nome_prompt': document.getElementById('nome_prompt').value,
                'tipo_prompt': document.getElementById('tipo_prompt').value,
                'nome_console': document.getElementById('nome_console').value,
                'historico': dadosJson.historico,
                'o_jogo': dadosJson.o_jogo,
                'acessorios': dadosJson.acessorios,
                'jogos': dadosJson.jogos,
                'mercado': dadosJson.mercado,
                'curiosidades': dadosJson.curiosidades,
                'resumo': dadosJson.resumo,
                'midia': dadosJson.midia,
                'desenvolvido_por': dadosJson.desenvolvido_por,
                'publicado_por': dadosJson.publicado_por,
                'lancado_em': dadosJson.lancado_em,
                'plataformas': dadosJson.plataformas,
                'designer': dadosJson.designer,
                'compositor': dadosJson.compositor,
                'taxonomia': dadosJson.taxonomia,
                'jogadores': dadosJson.jogadores,
                'links_de_referencia': dadosJson.links_de_referencia
            },
            success: function(data) {
                // Manipule a resposta aqui
                console.log('Sucesso: ', data);
            },
            error: function(xhr, status, error) {
                console.error('Erro:', error);
                console.log(error);
                Swal.close();

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Erro ao criar a postagem",
                    showConfirmButton: false,
                    timer: 4000
                });


            },
            complete: function() {
                Swal.close();

                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Postagem criada",
                    showConfirmButton: false,
                    timer: 4000
                });
            }
        });
        }
        else if (e.value == "ARCADE") {
            ajaxRequest = $.ajax({
            url: 'backend/cria.php', // Altere para a URL do seu endpoint
            type: 'POST',
            dataType: 'text', // Pode ser 'json', 'html', etc., conforme a resposta esperada
            data: {
                'nome_prompt': document.getElementById('nome_prompt').value,
                'tipo_prompt': document.getElementById('tipo_prompt').value,
                'nome_console': document.getElementById('nome_console').value,
                'historico': dadosJson.historico,
                'o_jogo': dadosJson.o_jogo,
                'acessorios': dadosJson.acessorios,
                'jogos': dadosJson.jogos,
                'mercado': dadosJson.mercado,
                'curiosidades': dadosJson.curiosidades,
                'resumo': dadosJson.resumo,
                'midia': dadosJson.midia,
                'desenvolvido_por': dadosJson.desenvolvido_por,
                'publicado_por': dadosJson.publicado_por,
                'lancado_em': dadosJson.lancado_em,
                'plataformas': dadosJson.plataformas,
                'designer': dadosJson.designer,
                'compositor': dadosJson.compositor,
                'taxonomia': dadosJson.taxonomia,
                'jogadores': dadosJson.jogadores,
                'links_de_referencia': dadosJson.links_de_referencia
            },
            success: function(data) {
                // Manipule a resposta aqui
                console.log('Sucesso: ', data);
            },
            error: function(xhr, status, error) {
                console.error('Erro:', error);
                console.log(error);
                Swal.close();

                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Erro ao criar a postagem",
                    showConfirmButton: false,
                    timer: 4000
                });


            },
            complete: function() {
                Swal.close();

                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Postagem criada",
                    showConfirmButton: false,
                    timer: 4000
                });
            
            resetaCheckbox();
            }
        });
        }
        
        

    }

    function animLoading() {
        let timerInterval;
        Swal.fire({
            title: "Carregando dados do Post",
            html: "Tempo estimado: <b></b> segundos.",
            timer: 60000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
                const timer = Swal.getPopup().querySelector("b");
                timerInterval = setInterval(() => {
                    timer.textContent = `${Math.round(Swal.getTimerLeft() / 1000)}`;
                }, 100);
            },
            willClose: () => {
                clearInterval(timerInterval);
            }
        }).then((result) => {});
    }

    function animLoadingPostando() {
        let timerInterval;
        Swal.fire({
            title: "Criando post no blog...",
            html: "Tempo estimado: <b></b> segundos.",
            timer: 30000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
                const timer = Swal.getPopup().querySelector("b");
                timerInterval = setInterval(() => {
                    timer.textContent = `${Math.round(Swal.getTimerLeft() / 1000)}`;
                }, 100);
            },
            willClose: () => {
                clearInterval(timerInterval);
            }
        }).then((result) => {});
    }

    function preencheCampos() {
        let e = document.getElementById("tipo_prompt");
        
        if (document.getElementById('ck_historico').checked == true || primeiraExecucao == true)
            document.getElementById('historico').innerText = dadosJson.historico
        if (document.getElementById('ck_o_jogo').checked == true || primeiraExecucao == true)
            if (e.value == "JOGO") {
                document.getElementById('o_jogo').innerText = dadosJson.o_jogo
            }
            else if (e.value == "CONSOLE") {
                dadosJson.o_jogo = dadosJson.o_console
                document.getElementById('o_jogo').innerText = dadosJson.o_console
                if (document.getElementById('ck_acessorios').checked == true || primeiraExecucao == true)
                    document.getElementById('acessorios').innerText = dadosJson.acessorios
                if (document.getElementById('ck_jogos').checked == true || primeiraExecucao == true)
                    document.getElementById('jogos').innerText = dadosJson.jogos
                    }
            else if (e.value == "ARCADE") {
                dadosJson.o_jogo = dadosJson.o_arcade
                document.getElementById('o_jogo').innerText = dadosJson.o_arcade
            }
        
        //Se for selecionado será refinado os dados.
        if (document.getElementById('ck_mercado').checked == true || primeiraExecucao == true)
            document.getElementById('mercado').innerText = dadosJson.mercado
        if (document.getElementById('ck_curiosidades').checked == true || primeiraExecucao == true)
            document.getElementById('curiosidades').innerText = dadosJson.curiosidades
        if (document.getElementById('ck_resumo').checked == true || primeiraExecucao == true)
            document.getElementById('resumo').innerText = dadosJson.resumo
        if (document.getElementById('ck_midia').checked == true || primeiraExecucao == true)
            document.getElementById('midia').innerText = dadosJson.midia
        if (document.getElementById('ck_desenvolvido_por').checked == true || primeiraExecucao == true)
            document.getElementById('desenvolvido_por').innerText = dadosJson.desenvolvido_por
        if (document.getElementById('ck_publicado_por').checked == true || primeiraExecucao == true)
            document.getElementById('publicado_por').innerText = dadosJson.publicado_por
        if (document.getElementById('ck_lancado_em').checked == true || primeiraExecucao == true)
            document.getElementById('lancado_em').innerText = dadosJson.lancado_em
        if (document.getElementById('ck_plataformas').checked == true || primeiraExecucao == true)
            document.getElementById('plataformas').innerText = dadosJson.plataformas
        if (document.getElementById('ck_designer').checked == true || primeiraExecucao == true)
            document.getElementById('designer').innerText = dadosJson.designer
        if (document.getElementById('ck_compositor').checked == true || primeiraExecucao == true)
            document.getElementById('compositor').innerText = dadosJson.compositor
        if (document.getElementById('ck_taxonomia').checked == true || primeiraExecucao == true)
            document.getElementById('taxonomia').innerText = dadosJson.taxonomia
        if (document.getElementById('ck_jogadores').checked == true || primeiraExecucao == true)
            document.getElementById('jogadores').innerText = dadosJson.jogadores
        if (document.getElementById('ck_links_de_referencia').checked == true || primeiraExecucao == true)
            document.getElementById('links_de_referencia').innerText = dadosJson.links_de_referencia
        

        if (primeiraExecucao == true)
            primeiraExecucao = false

        document.getElementById('bt_gerar').style.display = 'inline-block'
        document.getElementById('bt_aprovar_post').style.display = 'inline-block'
    }

    function gerarTudo() {
        primeiraExecucao = true
        getPost()
        resetaCheckbox();
    }

    function selecionaRefazer() {
        //função refatorada
    }
    function resetaCheckbox() {
        document.getElementById('ck_historico').checked = false
        document.getElementById('ck_o_jogo').checked = false
        document.getElementById('ck_acessorios').checked = false
        document.getElementById('ck_jogos').checked = false
        document.getElementById('ck_mercado').checked = false
        document.getElementById('ck_curiosidades').checked = false
        document.getElementById('ck_resumo').checked = false
        document.getElementById('ck_midia').checked = false
        document.getElementById('ck_desenvolvido_por').checked = false
        document.getElementById('ck_publicado_por').checked = false
        document.getElementById('ck_lancado_em').checked = false
        document.getElementById('ck_plataformas').checked = false
        document.getElementById('ck_designer').checked = false
        document.getElementById('ck_compositor').checked = false
        document.getElementById('ck_taxonomia').checked = false
        document.getElementById('ck_jogadores').checked = false
        document.getElementById('ck_links_de_referencia').checked = false
    }
	
    function removeXX(id) {
    	let str = document.getElementById(id).innerText.toString().replace(" XX_INICIO", "");
        str =  str.replace(/\b XX_INICIO\b/g, '');
    	str =  str.replace(/\bXX_INICIO\b/g, '');
    	str =  str.replace(/\b XX_FIM\b/g, '');
    	str =  str.replace(/\bXX_FIM\b/g, '');
    	document.getElementById(id).innerText = str
    }
    
    function delXXs(){
        removeXX('historico')
        removeXX('o_jogo')
        removeXX('mercado')
        removeXX('curiosidades')
        removeXX('resumo')
    }