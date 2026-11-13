<?php
require_once __DIR__.'/config/database.php';
require_once __DIR__.'/includes/auth.php';
$error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $email=trim($_POST['email'] ?? ''); $password=$_POST['password'] ?? '';
    $stmt=$pdo->prepare('SELECT id,name,email,password_hash,role FROM users WHERE email=? AND is_active=1 LIMIT 1');
    $stmt->execute([$email]); $u=$stmt->fetch();
    if ($u && password_verify($password,$u['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user']=['id'=>$u['id'],'name'=>$u['name'],'email'=>$u['email'],'role'=>$u['role']];
        header('Location: dashboard.php'); exit;
    }
    $error='Email atau password tidak sesuai.';
}
$page_title='Login · KlinikCare'; require __DIR__.'/includes/header.php';
?>
<main class="container"><section class="card form-card"><h1>Masuk KlinikCare</h1><p class="muted">Silakan masuk menggunakan akun Anda.</p>
<?php if($error): ?><div class="notice"><?= e($error) ?></div><?php endif; ?>
<form method="post"><div class="field"><label>Email</label><input type="email" name="email" required autocomplete="username"></div>
<div class="field"><label>Password</label><input type="password" name="password" required autocomplete="current-password"></div>
<button class="btn" type="submit">Login</button></form><p class="muted">Belum punya akun pasien? <a href="register.php">Daftar di sini</a>.</p></section></main>
<?php require __DIR__.'/includes/footer.php'; ?>