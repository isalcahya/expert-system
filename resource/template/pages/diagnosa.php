<?php view()->render( 'pakar-header' ); ?>
	<section class="section-header pb-7 pb-lg-11 bg-soft">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-12 col-md-6 order-2 order-lg-1">
                <img src="<?php echo get_dist_directory(); ?>/assets/img/illustrations/hero-illustration.svg" alt="">
                </div>
                <div class="col-12 col-md-5 order-1 order-lg-2">
                      <h4 class="mb-3"><?php echo strtoupper( __( 'Sistem Pakar Kerusakan Mobil' ) )  ?></h4>
                      <p class="lead"><?php echo strtoupper( __( 'Isi Data Diri Anda berikut' ) ) ?></p>
                      <div class="mt-4">
                        <form action="<?php echo url(); ?>" method="post" class="d-flex flex-column mb-5 mb-lg-0">
                          <input type="hidden" name="wp_csrf_token" value="<?= csrf_token(); ?>">
                          <input class="form-control" type="text" name="diagnosa[nama]" placeholder="Nama" required>
                          <input class="form-control my-3" type="text" name="diagnosa[no]" placeholder="No hp" required>
                          <button class="btn btn-primary" type="submit"><?php _e( 'Mulai Diagnosa' ) ?></button>
                          <!--   <div class="form-group form-check mt-3">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label form-check-sign-white" for="exampleCheck1">I agree to the <a href="#">Terms & Conditions</a></label>
                            </div> -->
                        </form>
                      </div>
                  </div>
            </div>
        </div>
        <div class="pattern bottom"></div>
    </section>
<?php view()->render( 'footer-auth' ); ?>