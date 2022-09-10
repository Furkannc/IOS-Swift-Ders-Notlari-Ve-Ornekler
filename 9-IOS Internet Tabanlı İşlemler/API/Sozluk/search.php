<?php
$response = array();//Boş array oluşturduk
if( isset($_POST["kelime_tr"])){
    $kelime = $_POST["kelime_tr"];
    require_once __DIR__ . '/db_config.php';//Conf verileri alındı
    $baglanti = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);//Veritabına baglanıldı
    if(!$baglanti){//Eger baglantı yoksa
        die("Hatalı baglantı: ".mysqli_connect_error());//Hata mesaji ver
    }
    $sqlsorgu = "select * from sozluk where kelime_tr like '%$kelime%' ";//Sorguy oluşturuldu
    $result = mysqli_query($baglanti,$sqlsorgu);//Sorgu çalıştırıldı
    if(mysqli_num_rows($result)>0){//Sorgudan donen deger sayısı buyukse 0 dan 
        $response["sozluk"] = array();//Array içine kişiler keyine ait bir dizi oluşturduk
        while($row = mysqli_fetch_assoc($result)){//her bir deger row içine gelir
            $kelime = array();//kisiler adında boş array
            $kelime["kelime_id"] = $row["kelime_id"];//key value mantıgında degerler oluştrulur
            $kelime["kelime_tr"] = $row["kelime_tr"];
            $kelime["kelime_en"] = $row["kelime_en"];
            array_push($response["sozluk"],$kelime);//Array içine kelime degerleri eklenir
        }
        $response["success"] = 1;//İşlem başarı degeri
        echo json_encode($response);//ekrana json dosyası olarak yazdırırız
    }else{
        $response["success"] = 0;
        $response["message"] = "No data found";
        echo json_encode($response);
    }
}else{
    $response["success"] = 0;
    $response["message"] = "Required filed(s) is missing";
    echo json_encode($response);
}


mysqli_close($baglanti);//Baglantı kapatılır
?>
