<?php 
require('../config/php/config.conf.php');
require('../config/php/database.php'); 
require('../config/php/function.php'); 
require('../config/php/user.php'); 

$page_name = basename(__FILE__) ;
$sid = $dateu.generateRandomString(4);
?>
<input type="hidden" id="txtUid" value="<?php echo $uid; ?>">
<input type="hidden" id="txtRole" value="<?php echo $role; ?>">
<input type="hidden" id="txtToken" value="<?php echo $token; ?>">

<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-navbar-fixed layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../submission/assets/"
  data-template="vertical-menu-template-no-customizer"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Contact</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../submission/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons -->
    <link rel="stylesheet" href="../submission/assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../submission/assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../submission/assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../submission/assets/vendor/css/rtl/core.css" />
    <link rel="stylesheet" href="../submission/assets/vendor/css/rtl/theme-default.css" />
    <link rel="stylesheet" href="../submission/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../submission/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../submission/assets/vendor/libs/typeahead-js/typeahead.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../submission/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../submission/assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        
        <?php 
        require_once('./comp/menu.php');
        ?>

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="" style="padding: 0px 40px;">
              <div class="row">
                <div class="col-12 d-none d-sm-block">
                  <h2 class="mb-1">Hello, <?php echo $currentUser['fname'] . " " . $currentUser['lname']; ?></h2>
                  <h5>Institution : <?php echo $currentUser['institution'] ; ?></h5>
                </div>

                <div class="col-12 d-block d-sm-none">
                  <h2 class="mb-1 text-center">Hello, <?php echo $currentUser['fname'] . " " . $currentUser['lname']; ?></h2>
                  <h5 class="text-center mb-2"><?php echo $currentUser['institution'] ; ?></h5>
                </div>

                <div class="col-12 pt-4">
                  <div class="card">
                    <div class="card-body text-center">
                      <i class='bx bx-envelope  text-success' style="font-size: 8em;" ></i>
                      <p>If you have any questions, please feel free to contact ltippawa@hotmail.com, saina.seeyong@gmail.com</p>
                    </div>
                  </div>
                </div>
              </div>


              <div class="d-block d-sm-none">
                <div class="row mt-4">
                  <div class="d-grid gap-2 col-lg-6 mx-auto">
                    <button class="btn btn-primary btn-lg" type="button" onclick="window.location='./'">Back to home</button>
                    <button class="btn btn-danger btn-lg" type="button" onclick="window.location='<?php echo ROOT_DOMAIN . 'AHR2023/api/php/authen?stage=logout'; ?>'">Log out</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>

      <!-- Drag Target Area To SlideIn Menu On Small Screens -->
      <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../submission/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../submission/assets/vendor/libs/popper/popper.js"></script>
    <script src="../submission/assets/vendor/js/bootstrap.js"></script>
    <script src="../submission/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../submission/assets/vendor/libs/hammer/hammer.js"></script>
    <script src="../submission/assets/vendor/libs/i18n/i18n.js"></script>
    <script src="../submission/assets/vendor/libs/typeahead-js/typeahead.js"></script>

    <script src="../submission/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../submission/assets/js/main.js"></script>

    <!-- Page JS -->
  </body>
</html>
