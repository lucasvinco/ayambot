<?php
    require "botToken.php";
    // Armazena o token de autenticação da API do telegram
    //$botToken = "";
    // Armazena a URL do bot
    $website = "https://api.telegram.org/bot".$botToken;

    // Captura e armazena todas as ultimas atualizações
    $update = file_get_contents($website."/getupdates");

    // Converte onjetos JSON para string
    $updateArray = json_decode($update, TRUE);

    //print_r($updateArray);

    /*
    $i = 0;
    foreach ($updateArray["result"] as $aux) {
        //echo $updateArray["result"][$i]["update_id"];
        //echo "\n";
        $i++;
    }
    $i--;
    */

    // Armazena a quantidade de itens do array
    $i = count($updateArray["result"]);
    // Subtrai 1 unidade da quantidade, assim refenciando o ultimo indice do array
    $i--;

    // Armazena o ID do chat
    //$chatId = $updateArray["result"][$i]["message"]["chat"]["id"];
    // Armazena o ID da atualizacao
    $update_id = $updateArray["result"][$i]["update_id"];

    // Variavel de controle de novas atualizações, inicia com FALSE supondo que a partir daí começa a contar novas atualizações
    $atualizacao = false;
    // Laço para repetir o processo de analise de novas atualizações e respostas
    while(true){
        $update = file_get_contents($website."/getupdates");

        $updateArray = json_decode($update, TRUE);
        /*
        $i = 0;
        foreach ($updateArray["result"] as $aux) {
            //echo $updateArray["result"][$i]["update_id"];
            //echo "\n";
            $i++;
        }
        $i--;
        */

        // Armazena a quantidade de itens do array
        $i = count($updateArray["result"]);
        // Subtrai 1 unidade da quantidade, assim refenciando o ultimo indice do array
        $i--;

        // Armazena o ID do chat
        $chatId = $updateArray["result"][$i]["message"]["chat"]["id"];

        $text = $updateArray["result"][$i]["message"]["text"];

        if($update_id == $updateArray["result"][$i]["update_id"]){

        } else {
            $atualizacao = true;
            $update_id++;
        }

        if($atualizacao){
            // Comandos definidos
            if($text == "/hi"){
                file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=Hello my name is Ayam, i am a bot.");
            }
            if($text == "/good night"){
                file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=good night");
            }
            if($text == "/time"){
                date_default_timezone_set('America/Sao_Paulo');
                $time = date('H:i');
                file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=".$time);
            }
            if($text == "/date"){
                date_default_timezone_set('America/Sao_Paulo');
                $date = date('d-m-Y');
                file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=".$date);
            }
            if($text == "/datetime"){
                date_default_timezone_set('America/Sao_Paulo');
                $dateTime = date('d-m-Y H:i');
                file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=".$dateTime);
            }
            $atualizacao = false;
        }
    }
?>
