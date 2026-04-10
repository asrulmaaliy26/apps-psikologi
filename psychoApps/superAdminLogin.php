<?php include 'conAdm.php';
require_once 'configSA.php';

// Jika sudah login SA, langsung ke dashboard
if (!empty($_SESSION['is_superadmin'])) {
    header('location:superAdminDashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<?php include 'headAdm.php'; ?>

<body class="hold-transition login-page" style="background:linear-gradient(135deg,#0f0c29,#302b63,#24243e);">
    <div class="login-box" style="margin-top:10vh;">
        <div class="card card-outline" style="border:none;border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,.5);background:rgba(255,255,255,.05);backdrop-filter:blur(12px);">
            <div class="card-header text-center pt-4" style="border:none;background:transparent;">
                <span style="font-size:2.5rem;">⚡</span>
                <h1 class="mt-1" style="color:#fff;font-weight:700;font-size:1.4rem;letter-spacing:.05em;">SUPER ADMIN</h1>
                <small style="color:rgba(255,255,255,.5);">Psikologi Apps — All-Access Panel</small>
            </div>
            <div class="card-body px-4 pb-4">
                <?php if (!empty($_GET['error'])): ?>
                    <div class="alert alert-danger py-2 text-center small">Username atau password salah.</div>
                <?php endif; ?>
                <form action="sformSA.php" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="sa_user" class="form-control" placeholder="Username"
                            style="background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.2);color:#fff;" required autofocus>
                        <div class="input-group-append">
                            <span class="input-group-text" style="background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.2);color:#fff;">
                                <i class="fas fa-user"></i>
                            </span>
                        </div>
                    </div>
                    <div class="input-group mb-4">
                        <input type="password" name="sa_pass" class="form-control" placeholder="Password"
                            style="background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.2);color:#fff;" required>
                        <div class="input-group-append">
                            <span class="input-group-text" style="background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.2);color:#fff;">
                                <i class="fas fa-lock"></i>
                            </span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-block" style="background:linear-gradient(135deg,#667eea,#764ba2);color:#fff;border:none;border-radius:8px;font-weight:600;padding:.6rem;margin-bottom:1rem;">
                        Masuk sebagai Super Admin
                    </button>
                    <div class="text-center">
                        <a href="../docs.php" style="color:rgba(255,255,255,.6);font-size:.85rem;text-decoration:none;"><i class="fas fa-book"></i> Baca Dokumentasi Sistem</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include 'jsAdm.php'; ?>
    <style>
        input::placeholder {
            color: rgba(255, 255, 255, .4) !important;
        }
    </style>
</body>

</html>