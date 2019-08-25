<?php

include ("MelhorEnvio.php");

$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6Ijk5M2Q5MTMyYWQ3MjMzNjVmZjJkMTdlODQ2NjAxNDZhNmEyZjcyNDc3ZDlmOGRmNTM0OWUzZGNhZjYwOTBmNjU2N2IxNjliOThjODhmODE5In0.eyJhdWQiOiIxIiwianRpIjoiOTkzZDkxMzJhZDcyMzM2NWZmMmQxN2U4NDY2MDE0NmE2YTJmNzI0NzdkOWY4ZGY1MzQ5ZTNkY2FmNjA5MGY2NTY3YjE2OWI5OGM4OGY4MTkiLCJpYXQiOjE1NjY3NTI2OTIsIm5iZiI6MTU2Njc1MjY5MiwiZXhwIjoxNTk4Mzc1MDkyLCJzdWIiOiJlMTRlYmIwYS1lYTBkLTQ4ZTYtOTRjNS0xNWI5NjE5YmEyMzAiLCJzY29wZXMiOlsiY2FydC1yZWFkIiwiY2FydC13cml0ZSIsImNvbXBhbmllcy1yZWFkIiwiY29tcGFuaWVzLXdyaXRlIiwiY291cG9ucy1yZWFkIiwiY291cG9ucy13cml0ZSIsIm5vdGlmaWNhdGlvbnMtcmVhZCIsIm9yZGVycy1yZWFkIiwicHJvZHVjdHMtcmVhZCIsInByb2R1Y3RzLXdyaXRlIiwicHVyY2hhc2VzLXJlYWQiLCJzaGlwcGluZy1jYWxjdWxhdGUiLCJzaGlwcGluZy1jYW5jZWwiLCJzaGlwcGluZy1jaGVja291dCIsInNoaXBwaW5nLWNvbXBhbmllcyIsInNoaXBwaW5nLWdlbmVyYXRlIiwic2hpcHBpbmctcHJldmlldyIsInNoaXBwaW5nLXByaW50Iiwic2hpcHBpbmctc2hhcmUiLCJzaGlwcGluZy10cmFja2luZyIsImVjb21tZXJjZS1zaGlwcGluZyIsInRyYW5zYWN0aW9ucy1yZWFkIiwidXNlcnMtcmVhZCIsInVzZXJzLXdyaXRlIiwid2ViaG9va3MtcmVhZCIsIndlYmhvb2tzLXdyaXRlIl19.pJrfpUSw5JscCseG2x-N2oHfUhR_q15djV6gffLguVeKi8PwrdcDHuqnpDTR2T7YYc9yQf4xQuU_Qb5cSi1-PuiyOoSb_6b6dmwTxPdaO-JsGQQpstaxWVC2Ils4NKsSnw1ag0_lF9AbQr1R7MSw8kXNXmdbA-Q58zcVrYQltRkvQrVpi7V9Yhid0JiLlGKVXx6YYkuslFMq7exe5FGIkL5-0_URTLiKexYTj_5feL8mhe7oUg0Ir1xv89QcOh1yjDplk2hoWxFJLH6QwB1dgIawqPHvVYznYbcO3S8U0WGaf-spYZjkwIGhCTvsp1AWRExt8legpcHHU8ml822L_Zkmhybbko8eZn2JVAtVQ9vxNczRfxL6ubZINbeEpqvoEqqss011xhc9oJWjjzVQ_pTLqWk76CLvETHsKMffThdsY5SSf3Gxvg2azCOt4OSW51Dl4Wu5gTbNHWY3cqzeIbKy7iJHAEw70dDwHh3fG01sJp6uxpk_xX9-2T59_AZDeDjvNZ4SZrjODR-KTG7L9vYkH-9x_pd7Qr3pstskS3icKOAGGU17CLBtyxKY9mysCLcCrvY2oSmcz4W4ncJnmd4Tp4N4J1KIaOsyuFd7jnIezY00HTRur_cY0N4VVtHWrZO2-_6y4j2b5pWjSMkg3-B2u3Y7y4FB1BORJX3I79g';


$me = new MelhorEnvio($token,"https://www.melhorenvio.com.br/api/v2/me");


$from = new StdClass();

$from->cep = "";
$from->endereco = "Bairro são";
$from->numero = "";

$to = new StdClass();

$to->cep = "";
$to->endereco = "Rua joão";
$to->numero = "";


$arrP = array();

$produto = new StdClass();
$produto->peso = 0.500;
$produto->largura=12;
$produto->altura=4;
$produto->comprimento = 17;
$produto->qtd = 2;

$produto2 = new StdClass();
$produto2->peso = 5;
$produto2->largura=10;
$produto2->altura=5;
$produto2->comprimento = 14;
$produto2->qtd = 1;

array_push($arrP, $produto);
array_push($arrP, $produto2);

//echo var_dump($me->listarTransportadoras());

echo json_encode($me->calcularFrete($from, $to, $arrP,null,null));

?>