<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Doc</title>
    <style rel="stylesheet">
        *{
            margin: 0;
            padding: 0;
            font-family: Calibri, sans-serif;
            font-size: 10pt;
            line-height: 1.5;
        }
        p {
            line-height: 1.5;
            margin-bottom: 12px;
            font-size: 10pt !important;
        }
        table{
            text-align: center;
        }
        .container{
            margin-left: 3cm;
            margin-right: 1.5cm;
        }

        body {
            margin-top: 2cm;
            margin-bottom: 2cm;
        }

        header {
            position: relative;
            text-align: center;
            margin-bottom: 1.5cm;
        }

        header img {
            margin-top: 0;
            height: 2cm;
        }

        .header-text{}

        footer {
            position: absolute;
            height: 2cm;
            bottom: -2.2cm;
            text-align: center;
            margin-bottom: 1.5cm;
            width: 100%;
        }

        .qrcode img {
            position: relative;
            height: 70px;
            width: 70px;
            padding: 5px;
        }

        .memo-numero{
            margin-bottom: 20px;
        }
        .memo-data{
          text-align: right;
            margin-bottom: 20px;
        }
        .memo-destinatario{
            max-width: 80%;
            margin-bottom: 20px;
        }

        .memo-destinatario p{
            margin: -5px;
        }
        .memo-assunto{
            margin-bottom: 20px;
            font-weight: bold;
        }
        .memo-conteudo p{
            text-indent: 3cm;
            text-align: justify;
        }

        .memo-assinatura{
            font-size: 10pt;
            word-wrap: break-word;
        }
        .memo-assinatura-eletronica{
            font-size: 9px;
            text-align: center;
        }
        .memo-assinatura-nome{
            text-align: center;
        }
        .memo-assinatura-cargo{
            text-align: center;
            margin-bottom: 12px;
        }
        .container-assinaturas{
            margin-top: 30px;
            width: 100%;
            text-align: center;
            align-content: center;
        }
        .container-assinaturas-item{
            width: 250px;
            margin-left: 10px;
            display: inline-block;
        }

        .margem-2-assinatura{
            width: 125px;
        }

        .quebra-linha {
            height: 13px;
            padding: 0;
        }

        .quebra-pagina {
            page-break-before: always;
        }
    </style>
</head>
<body>
<header>
    <img src="<?= __DIR__ ?>/images/brasao.jpg" />
    <div class="header-text">
        Conselho Regional de Técnicos em Radiologia<br>
        19ª Região com Jurisdição nos Estados do Amazonas e Roraima<br>
        Serviço Público Federal
    </div>
</header>

    <div class="container">
        <div class="memo-numero">
            <?php $numeroDoc = ($memo->numeroDoc != "xxxx") ? zeroEsquerda($memo->numeroDoc): $memo->numeroDoc ?>
            <?= $tipoDoc->tipo; ?> Nº <?= $numeroDoc; ?>/<?= $memo->anoDoc ?>/<?= $tipoDoc->sigla; ?>
        </div>

        <div class="memo-data">
            Manaus, <?= strftime('%d de %B de %Y', strtotime($memo->dataDoc)); ?>.
        </div>

        <div class="memo-destinatario">
            <?= str_replace('&#13;', "<br />", $memo->destinatarioDoc); ?>
        </div>

        <div class="memo-assunto">
            Assunto: <?= $memo->assuntoDoc ?>
        </div>

        <div class="memo-conteudo">
            <?= html_entity_decode($memo->conteudoDoc); ?>
        </div>
    </div>

    <? if($memo->assinaturaNocumento()): ?>
        <div class="container-assinaturas">
            <? if(count($memo->assinaturaNocumento()) == 1): ?>
                <div class="container-assinaturas-item"></div>
            <? endif ?>
            <? if(count($memo->assinaturaNocumento()) == 2): ?>
                <div class="container-assinaturas-item margem-2-assinatura"></div>
            <? endif ?>

            <? foreach ($memo->assinaturaNocumento() as $assinatura) : ?>
                <div class="container-assinaturas-item">
                    <div class="memo-assinatura memo-assinatura-eletronica">
                        <? if ($assinatura->assinaturaEletronica !== ""): ?>
                            Assinatura: <?= $assinatura->assinaturaEletronica; ?>
                        <? endif ?>
                    </div>
                    <div class="memo-assinatura memo-assinatura-nome">
                        <?= $assinatura->nome; ?>
                    </div>
                    <div class="memo-assinatura memo-assinatura-cargo">
                        <?= $assinatura->cargo; ?>
                    </div>
                </div>
            <? endforeach ?>
        </div>
    <? endif ?>

    <footer>
            Rua Michel Fokine, N°11, QD: Q, Conj. Shangrilar IV – Parque 10 de Novembro. Telefone: (92) 3308-6914/3213-9583
            <br>CEP: 69054-739 Manaus/ AM - https://www.crtr19.gov.br E-mail: crtr19regiao@gmail.com
    </footer>



</body>
</html>

