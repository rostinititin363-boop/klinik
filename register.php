<?php
require_once __DIR__.'/config/database.php'; require_once __DIR__.'/includes/auth.php';
$error=''; $success='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $name=trim($_POST['name']??'');$email=trim($_POST['email']??'');$phone=trim($_POST['phone']??'');$password=$_POST['password']??'';
 if($name===''||!filter_var($email,FILTER_VALIDATE_EMAIL)||strlen($password)<8){$error='Lengkapi data. Password minimal 8 karakter.';}
 else{
  try{$pdo->beginTransaction();$s=$pdo->prepare("INSERT INTO users(name,email,password_hash,role) VALUES(?,?,?,'pasien')");$s->execute([$name,$email,password_hash($password,PASSWORD_DEFAULT)]);$uid=(int)$pdo->lastInsertId();$p=$pdo->prepare('INSERT INTO patients(user_id,phone) VALUES(?,?)');$p->execute([$uid,$phone]);$pdo->commit();$success='Pendaftaran berhasil. Silakan login.';}
  catch(PDOException $e){if($pdo->inTransaction())$pdo->rollBack();$error='Email sudah digunakan atau data gagal disimpan.';}
 }
}
$page_title='Daftar Pasien · KlinikCare';require __DIR__.'/includes/header.php';?>
<main class="container"><section class="card form-card"><h1>Daftar Pasien</h1><?php if($error):?><div class="notice"><?=e($error)?></div><?php endif;?><?php if($success):?><div class="notice success"><?=e($success)?></div><?php endif;?>
<form method="post"><div class="field"><label>Nama lengkap</label><input name="name" required></div><div class="field"><label>Email</label><input type="email" name="email" required></div><div class="field"><label>Nomor HP</label><input name="phone"></div><div class="field"><label>Password (minimal 8 karakter)</label><input type="password" name="password" minlength="8" required></div><button class="btn">Buat akun</button></form><p><a href="login.php">Kembali ke login</a></p></section></main><?php require __DIR__.'/includes/footer.php';?>