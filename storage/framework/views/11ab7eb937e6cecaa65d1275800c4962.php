

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<section class="hero text-center text-lg-start">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h3 class="fw-bold">Menghubungkan <span style="color:#009e49;">pengendara</span><br>
                    Dengan Stasiun Pengecasan Cerdas</h3>
                <p class="mt-3">KODEX TECHNOLOGY (PVT) LTD is a team of experienced mobile and web application and website builders...</p>
                <div class="mt-4">
                    <a href="#" class="btn btn-success px-4 me-2">Contact us</a>
                    <a href="#" class="btn btn-outline-dark px-4">View more</a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="<?php echo e(asset('images/car.png')); ?>" alt="Car" class="img-fluid">
            </div>
        </div>
    </div>
</section>


<div class="container car-form">
    <div class="row g-3">
        <?php for($i = 0; $i < 6; $i++): ?>
            <div class="col-md-4">
                <label class="form-label">Tipe Mobil</label>
                <select class="form-select">
                    <option>Pilih Tipe Mobil</option>
                    <option>Sedan</option>
                    <option>SUV</option>
                    <option>Sport</option>
                    <option>Elektrik</option>
                </select>
            </div>
        <?php endfor; ?>
        <div class="col-12 text-center mt-3">
            <button class="btn btn-success px-5">Cari Jadwal</button>
        </div>
    </div>
</div>


<section class="py-5 text-center">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="feature-icon bg-primary mx-auto mb-3">💻</div>
                <h6>Web Application</h6>
                <p class="text-muted small">Lorem ipsum is simply</p>
            </div>
            <div class="col-md-3">
                <div class="feature-icon bg-success mx-auto mb-3">🔍</div>
                <h6>SEO</h6>
                <p class="text-muted small">Lorem ipsum is simply</p>
            </div>
            <div class="col-md-3">
                <div class="feature-icon bg-info mx-auto mb-3">🕶️</div>
                <h6>AR/VR Solutions</h6>
                <p class="text-muted small">Lorem ipsum is simply</p>
            </div>
            <div class="col-md-3">
                <div class="feature-icon bg-warning mx-auto mb-3">📱</div>
                <h6>Mobile Applications</h6>
                <p class="text-muted small">Lorem ipsum is simply</p>
            </div>
        </div>
    </div>
</section>


<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h5 class="fw-bold">Lorem Ipsum is simply dummy text of the printing.</h5>
            <p class="text-muted">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
        </div>

        <div class="row align-items-center mb-5">
            <div class="col-md-6">
                <h6 class="text-success fw-bold">Lorem Ipsum</h6>
                <h5 class="fw-semibold">is simply dummy text of the printing.</h5>
                <p class="text-muted small">KODEX TECHNOLOGY (PVT) LTD is a team of experienced mobile and web application...</p>
            </div>
            <div class="col-md-6 text-center">
                <img src="<?php echo e(asset('images/phone.png')); ?>" class="img-fluid" alt="Phone Mockup">
            </div>
        </div>

        <div class="row align-items-center mb-5 flex-md-row-reverse">
            <div class="col-md-6">
                <h6 class="text-success fw-bold">Lorem Ipsum</h6>
                <h5 class="fw-semibold">is simply dummy text of the printing.</h5>
                <p class="text-muted small">KODEX TECHNOLOGY (PVT) LTD is a team of experienced mobile and web application...</p>
            </div>
            <div class="col-md-6 text-center">
                <img src="<?php echo e(asset('images/layers.png')); ?>" class="img-fluid" alt="Layer Design">
            </div>
        </div>

        <div class="row align-items-center mb-5">
            <div class="col-md-6">
                <h6 class="text-success fw-bold">Lorem Ipsum</h6>
                <h5 class="fw-semibold">is simply dummy text of the printing.</h5>
                <p class="text-muted small">KODEX TECHNOLOGY (PVT) LTD is a team of experienced mobile and web application...</p>
            </div>
            <div class="col-md-6 text-center">
                <img src="<?php echo e(asset('images/vr.png')); ?>" class="img-fluid" alt="VR">
            </div>
        </div>
    </div>
</section>


<section class="text-center py-5 bg-light">
    <div class="container">
        <h6 class="text-muted mb-4">You will be in good Company</h6>
        <div class="d-flex justify-content-center flex-wrap gap-5">
            <img src="<?php echo e(asset('images/logo1.png')); ?>" alt="Company 1" height="30">
            <img src="<?php echo e(asset('images/logo2.png')); ?>" alt="Company 2" height="30">
            <img src="<?php echo e(asset('images/logo3.png')); ?>" alt="Company 3" height="30">
            <img src="<?php echo e(asset('images/logo4.png')); ?>" alt="Company 4" height="30">
        </div>
    </div>
</section>


<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="text-success fw-bold">E-VOLT</h5>
                <p class="small mt-3">Lorem ipsum is simply dummy text of the printing and typesetting industry.</p>
                <p>@lorem</p>
            </div>
            <div class="col-md-4 mb-4">
                <h6>About us</h6>
                <ul class="list-unstyled small mt-3">
                    <li><a href="#">Lorem</a></li>
                    <li><a href="#">Portfolio</a></li>
                    <li><a href="#">Contacts</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6>Contact us</h6>
                <p class="small mt-3">+908 890097 890<br> lorem@company.com</p>
                <div class="d-flex gap-3">
                    <i class="bi bi-facebook"></i>
                    <i class="bi bi-instagram"></i>
                    <i class="bi bi-twitter"></i>
                </div>
            </div>
        </div>
        <hr class="mt-4">
        <p class="text-center small mb-0">Copyright © 2025 Lorem. All Rights Reserved.</p>
    </div>
</footer>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\PBL S5\evolt\resources\views\dashboard.blade.php ENDPATH**/ ?>