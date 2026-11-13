<?php
require_once __DIR__.'/config/database.php'; require_once __DIR__.'/includes/auth.php'; require_login();
$u=$_SESSION['user'];$role=$u['role'];$page_title='Dashboard · KlinikCare';
$counts=[];
if($role==='admin'){
 foreach(['Pasien'=>'SELECT COUNT(*) FROM patients','Dokter'=>'SELECT COUNT(*) FROM doctors','Janji temu'=>'SELECT COUNT(*) FROM appointments'] as $k=>$q)$counts[$k]=(int)$pdo->query($q)->fetchColumn();
}elseif($role==='dokter'){
 $s=$pdo->prepare('SELECT id FROM doctors WHERE user_id=?');$s->execute([$u['id']]);$doc=$s->fetch();$docId=$doc['id']??0;
 $s=$pdo->prepare("SELECT COUNT(*) FROM appointments WHERE doctor_id=? AND appointment_date>=CURDATE()");$s->execute([$docId]);$counts['Janji temu mendatang']=(int)$s->fetchColumn();
 $s=$pdo->prepare('SELECT COUNT(*) FROM appointments WHERE doctor_id=?');$s->execute([$docId]);$counts['Total kunjungan']=(int)$s->fetchColumn();
}else{
 $s=$pdo->prepare('SELECT id FROM patients WHERE user_id=?');$s->execute([$u['id']]);$pat=$s->fetch();$patId=$pat['id']??0;
 $s=$pdo->prepare('SELECT COUNT(*) FROM appointments WHERE patient_id=?');$s->execute([$patId]);$counts['Janji temu saya']=(int)$s->fetchColumn();
}
require __DIR__.'/includes/header.php';?>
<main class="container"><section class="hero"><h1>Selamat datang, <?=e($u['name'])?>!</h1><p>Dashboard <?=e(ucfirst($role))?> KlinikCare</p></section>
<nav class="menu"><a class="btn secondary" href="dashboard.php">Dashboard</a><?php if($role==='admin'):?><a class="btn secondary" href="admin/doctors.php">Data Dokter</a><a class="btn secondary" href="admin/patients.php">Data Pasien</a><a class="btn secondary" href="admin/appointments.php">Janji Temu</a><?php elseif($role==='dokter'):?><a class="btn secondary" href="doctor/appointments.php">Jadwal Pasien</a><?php else:?><a class="btn secondary" href="patient/book.php">Buat Janji Temu</a><a class="btn secondary" href="patient/history.php">Riwayat Saya</a><?php endif;?></nav>
<div class="grid"><?php foreach($counts as $label=>$value):?><article class="card"><h3><?=e($label)?></h3><div class="number"><?=$value?></div></article><?php endforeach;?></div>
<section class="card" style="margin-top:18px"><h3>Informasi</h3><p class="muted">Gunakan menu di atas untuk mengakses fitur sesuai hak akses akun Anda. Data medis hanya dapat diakses oleh pengguna yang berwenang.</p></section></main><?php require __DIR__.'/includes/footer.php';?>