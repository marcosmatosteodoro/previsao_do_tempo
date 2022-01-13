<br>
<?php

$iTOKEN = '7adcabfd03b95ef772e1d934c986064d';
$iCIDADE = '7564';
$json = "http://apiadvisor.climatempo.com.br/api/v1/forecast/locale/$iCIDADE/days/15?token=$iTOKEN";
$json_file = file_get_contents($json);   
$json_str = json_decode($json_file, true);


for ($indice = 0; $indice <= 6; $indice++) {

    $cidade = $json_str["name"];
    $estado = $json_str["state"];
    $pais = $json_str["country"];
    $data = $json_str["data"][$indice]["date_br"];
    $umidade_min = $json_str["data"][$indice]["humidity"]["min"];
    $umidade_max = $json_str["data"][$indice]["humidity"]["max"];
    $umidade_media = ($umidade_max + $umidade_min)/2;
    $chuva_proba = $json_str["data"][$indice]["rain"]["probability"];
    $chuva_preci = $json_str["data"][$indice]["rain"]["precipitation"];
    $vento = $json_str["data"][$indice]["wind"]["velocity_avg"];
    $uv = $json_str["data"][$indice]["uv"]["max"];
    $temperatura_min = $json_str["data"][$indice]["temperature"]["min"];
    $temperatura_max = $json_str["data"][$indice]["temperature"]["max"];
    $temperatura_media = (int)(($temperatura_max + $temperatura_min)/2);
    $previsao_geral = $json_str["data"][$indice]["text_icon"]["text"]["pt"];
    $img = $json_str["data"][$indice]["text_icon"]["icon"]["day"];
    $hoje = false;

    if((date("d/m/Y")) == $data){
        $data = "HOJE";
        $hoje = true;

        echo "
        <div class='container' style='width:1000px'>

            <div class='card'>
                <div class='card-header'>
                    <h1 class='card-title text-center'>Previsão de Hoje</h1>
                </div>
            </div>

            <div class='card-group'>
            ";

        for ($i=1; $i<=3; $i++){

            if ($i == 1){
                $periodo = "morning";
                $periodo_pt = "Manhã";
            }
            if ($i == 2){
                $periodo ="afternoon";
                $periodo_pt = "Tarde";
            }
            if ($i == 3){
                $periodo = "night";
                $periodo_pt = "Noite";
            }
            $umidade_p_min = $json_str["data"][$indice]["humidity"][$periodo]["min"];
            $umidade_p_max = $json_str["data"][$indice]["humidity"][$periodo]["max"];
            $temperatura_p_min = $json_str["data"][$indice]["temperature"][$periodo]["min"];
            $temperatura_p_max = $json_str["data"][$indice]["temperature"][$periodo]["max"];
            $vento_p = $json_str["data"][$indice]["wind"][$periodo]["velocity_avg"];
            $previsao_p = $json_str["data"][$indice]["text_icon"]["text"]["phrase"][$periodo];
            $img_p = $json_str["data"][$indice]["text_icon"]["icon"][$periodo];


            echo "
            <div class='card'>
                    <div class='card-header'>
                        <h3 class='card-title text-center' style='margin:0'>$periodo_pt</h3>
                    </div>
                    
                    <div class='card-footer'>
                        <div class='row'>
                            <div class='col'>
                                <img class='card-img-left' style='width:100px; height:100px; margin-bottom:0'  alt='Card image cap'
                                src='vendor/img/$img_p.png'>
                            </div>
                            <div class='col'>
                                <small class='text-muted'>$previsao_p</small>
                                <hr style='margin:0'>
                                <small class='text-muted'>Temperatura $temperatura_p_max - $temperatura_p_min" . "º</small><br>
                                <small class='text-muted'>umidade $umidade_p_max% - $umidade_p_min%</small><br>
                                <small class='text-muted'>Vento $vento_p km/h</small><br>
                            </div>

                        </div>
                    </div>
                </div>
                ";
        }

        echo "
            </div>
        </div>";

    }

    echo "
    <div class='container' style='width:1000px'>
        <div class='card'>
            <div class='card-body'>
                <div class='row'>
                    <div class='col-2'>
                        <img class='card-img-left' style='width:100px; height:100px; margin-bottom:0'  alt='Card image cap'
                        src='vendor/img/$img.png'>
                    </div>
                    <div class='col-2'>
                        <span style='margin-bottom:0'>
                            <span class='display-1'>$temperatura_media</span>
                            <span class='align-top h4' style='color: rgb(150,150,150)'>ºC</span>
                        </span>
                    </div>
                    <div class='col'>
                        <small style='margin-bottom:0; color: rgb(150,150,150)'>Umidade $umidade_media%</small><br>
                        <small style='margin-bottom:0; color: rgb(150,150,150)'>Chuva $chuva_proba%</small><br>
                        <small style='margin-bottom:0; color: rgb(150,150,150)'>Vento $vento km/h</small><br>
                        <small style='margin-bottom:0; color: rgb(150,150,150)'>UV $uv</small>
                    </div>
                    <div class='col'>
                        <h2 style='margin-bottom:0'>$cidade - $estado</h2>
                        <p style='margin-bottom:0; color: rgb(150,150,150)'>$previsao_geral</p>
                        <p style='margin-bottom:0; color: rgb(150,150,150)'>$data</p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    ";

    if($hoje){
        echo "<br>";
    }
}

?>
