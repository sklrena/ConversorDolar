<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Conversor do saldo em carteira</h1>
    <main>
        <?php

            //pegando o saldo digitado pelo usuario utilizando o método $_GET
            $saldo = $_GET["dinheiro"];

            //cotação do dólar consumindo a API do banco central e atualizando de 7 dias atrás até o dia atual
            $inicio = date("m-d-Y", strtotime("-7 days"));
            $fim = date("m-d-Y");
            $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\''.$inicio.'\'&@dataFinalCotacao=\''.$fim.'\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';

            $dados = json_decode(file_get_contents($url), true);

            //var_dump($dados); -> value, 0 e cotacaoCompra retirados a partir daqui

            $cotacao = $dados["value"][0]["cotacaoCompra"];
            $conversor = $saldo / $cotacao;
            $padrao = numfmt_create("pt_BR", NumberFormatter::CURRENCY);
            //biblioteca internacionalizada
            echo "Saldo em real " . numfmt_format_currency($padrao, $saldo, "BRL") . ", saldo na carteira em Dólar($) " . numfmt_format_currency($padrao, $conversor, "USD"); 
            // echo "O valor em Real na sua carteira é de R\$" . number_format($saldo, 2, ",", ".") . " reais e, equivale a \$" . number_format($conversor, 2, ",", ".") . " Dólares";
        ?>
        <br>
        
    </main>
    <button onclick="javascript:history.go(-1)">Voltar</button>
</body>
</html>