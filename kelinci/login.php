<?php
session_start();


require '../../php/p20/function.php';


// cek apakah masih ada cookie
if( isset($_COOKIE["id"]) && isset($_COOKIE["key"]) && $_COOKIE["user"]){

    $id = $_COOKIE["id"];
    $key = $_COOKIE["key"];
    $user = $_COOKIE["user"];
    $_SESSION["nama"] = $user;


    // ambil username berdasarkan id
    $hasil = mysqli_query($database, "SELECT username FROM users WHERE id = $id");

    $userNama = mysqli_fetch_assoc($hasil);

    // cek cookie dan username
    if ( $key === hash('sha256',$userNama["username"]) ){
        $_SESSION["login"] = true;
    }
}


   



    


if ( isset($_SESSION["login"]) ){

    
    header("Location: index.php");
}

if( isset($_POST["login"]) ){

    $username = $_POST["username"];
    $password = $_POST["password"];
    $_SESSION["nama"] = $username;
    
   
    $cekusername = mysqli_query($database, "SELECT * FROM users WHERE username = '$username'");

         // cek apakah username ada dalam databasxe
    if( mysqli_num_rows($cekusername) === 1 ){

        // cek apakah password benar  atau tidak
        $data = mysqli_fetch_assoc($cekusername);
        if( password_verify($password, $data["password"]) ){
            $_SESSION["login"] = true;
           
            // set cookie
            if( isset($_POST["remember"]) ){

                setcookie('id',$data['id'], time()+3600*20);
                setcookie('key', hash('sha256',$data["username"]), time()+3600*20);
                setcookie('user',$data["username"], time()+3600*20);
                

            }
            header("Location: index.php");
            exit;
        }  
    }

    
        echo "<script>
        alert('USERNAME ATAU PASSWORD SALAHHHHHHH!!!!!!!')
    </script>";
    



}




?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>login</title>
</head>
<body>
    <div class="form">
    <h1>halaman login</h1>
    

    <a href="index.php">Login nanti</a>
    <div class="login">
    <div class="isi">
    <form action="" method="post" >

    <ul>
    <li class="username">
        <label for="username">username</label><br>
        <input type="text" name="username" id="username"  required value="">
    </li>
    <li class="pass">
        <label for="password">password</label><br>
        <input type="password" name="password" id="password" required value="">
    </li>
    <li>
        <input type="checkbox" name="remember" id="remember">
        <label for="remember">remember me</label>
    </li>
    <li class="button">
        <button type="submit" name="login">Login</button>
    </li>
    </ul>
 
    </form>
    </div>
    </div>
    <a href="register.php" class="register"><p color="darkblue">buat akun sekarang</p></a>
    </div>
    
</body>
</html>