<?php

$baglan= new PDO('mysql:host=localhost;dbname=ammar','root','');
error_reporting(0);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="odev2.css"/>
	<link rel="stylesheet" href="bootstrap.min.css"/>  
	<title></title>
</head>
<body>
  <div class="kutu">
  	<form action="odev2.php" method="POST" enctype="multipart/form-data" >
  	  <div class="form-group">
  	   <div class="row">
  	    <div class="col">
  	   		<label>Adınız</label>
  	      <input type="text" name="adi" id="adi" class="form-control" >
  	    </div>
  	    <div class="col">
  	    	<label>Soyadınız</label>
  	      <input type="text" name="soyadi" id="soyadi" class="form-control" >
  	    </div>
  	  </div>
  	    <div class="form-group">
  	    <label for="exampleFormControlFile1">yüklemek istediğiniz dosyayı seçin</label>
  	    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="dosya">
  	  </div>
  	  <button type="submit" class="btn btn-primary">Submit</button>
  	</form>
    <br>
    <?php


    $file=$_FILES['dosya'];
    $DosyaAdi=$file["name"];
    $GeciciDosyaYeri=$file["tmp_name"];
    $DosyaYolu="dosya/".$DosyaAdi;
    if (move_uploaded_file($GeciciDosyaYeri,$DosyaYolu)) 
    {
      echo "dosya başarlı bir şekilde yüklendi <br>";}
    $ekle=$baglan->prepare("INSERT INTO Dosyalar(Adi,SoyAdi,DosyaAdi)VALUES(?,?,?)");
    $adi=$_POST['adi'];
    $soyadi=$_POST['soyadi'];
    $ekle->execute(array($adi,$soyadi,$DosyaAdi));

    ?>

  </div>
</div>
<h2>Dosyalarınız</h2>
          <div class="table-responsive">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th>Adı</th>
                  <th>Soyadı</th>
                  <th>Dosya Adı</th>
                  <th>Yükleme Tarihi</th>
                  <th>İşlemler</th>
                </tr>
              </thead>
              <?php 
                $query=$baglan->prepare("select Adi,SoyAdi,DosyaAdi,YuklemeTarihi from dosyalar");
                $query->execute();
                foreach ($query as $row) {
              ?>
              <tbody>
                <tr>
                  <td><?=$row['Adi'] ?></td>
                  <td><?=$row['SoyAdi'] ?></td>
                  <td><?=$row['DosyaAdi'] ?></td>
                  <td><?=$row['YuklemeTarihi'] ?></td>
                  <td><a href="dosya/<?=$row['DosyaAdi'] ?>" download="">Dosyayı İndir</a><br>
                    <a href="dosya/<?=$row['DosyaAdi'] ?>" target="_blank" example >Dosyayı Görüntüle</a>

                  </td>
                </tr>
              </tbody>
              <?php  } ?>
            </table>
          </div>
<script type="text/javascript" src="bootstrap.min.js"></script>
</body>
</html>