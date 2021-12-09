<?php
session_start();



require '../../php/p20/function.php';

$id = $_GET["id"];

function upProfil(){

    $namaFile = $_FILES['profil']['name'];
    $ukuranFile = $_FILES['profil']['size'];
    $error = $_FILES['profil']['error'];
    $tmpFile = $_FILES['profil']['tmp_name'];
  

    // cek apakah tidak ada gambar yang diupload
   if( $error === 4 ){
        echo "<script>
            alert('gambar harus diisi!')
        </script>";
        return false;
}

    // cek apakah yang diupload oleh user adalah file gambar
    $eksGambarValid = ['jpg','png','jpeg'];
    $eksGambar = explode('.',$namaFile);
    $eksGambar = strtolower(end($eksGambar));

    // jika yang diupload bukan gambar
    if ( !in_array($eksGambar, $eksGambarValid) ){

        echo "<script>
        alert('yang anda upload bukan gambar!')
    </script>";
    return false;

    }

    // jika ukuran gambar terlalu besar
    else if( $ukuranFile > 2500000 ){
        echo "<script>
        alert('gambar yang anda upload ukuran nya terlalu besar!')
    </script>";
    return false;
    }

    // ubah nama file
    $namaBaru = uniqid();
    $namaBaru.='.';
    $namaBaru.=$eksGambar;

    // ketika lolos seleksi
    move_uploaded_file($tmpFile,'img/'.$namaBaru);
    return $namaBaru;

}




function tambahProfil(){

    global $database;

    $userid = $_GET["id"];
    $img = upProfil();

    if( !$img ){
        return false;
    }
    $profil = 'img/'.$img;

    mysqli_query($database, "INSERT INTO profil VALUES
    ('', '$userid','$profil')
    ");

$feedback = mysqli_affected_rows($database);

return $feedback;

}

if( isset($_POST["tambah"]) ){
    if ( tambahProfil($_POST) > 0 ){
       
        echo "<script>
        alert('Data berhasil ditambahkan')
    </script>";
    }

    else{
        echo "<script>
        alert('Data tidak ditambahkan')
    </script>";
    echo mysqli_error($database);
    }

}
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<a href="index.php">kembali ke halaman utama</a>

<form action="" method ="post" enctype="multipart/form-data">


<input type="file" name="profil" id="profil">
<button type = "submit" name="tambah">Tambah Profil</button>

</form>

    
</body>
</html>