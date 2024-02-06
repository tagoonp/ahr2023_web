<?php 
require('../config/php/config.conf.php');
require('../config/php/database.php'); 
require('../config/php/function.php'); 
require('../config/php/user.php'); 

$page_name = basename(__FILE__) ;


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

    <title>Profile</title>

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
    <link rel="stylesheet" href="../submission/assets/vendor/libs/dropzone/dropzone.css" />
    <link rel="stylesheet" href="../submission/assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet" href="../submission/assets/vendor/preload.js/dist/css/preload.css">

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../submission/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../submission/assets/vendor/libs/typeahead-js/typeahead.css" />

    <!-- Page CSS -->

    <style>
      .dn{
        display: none;
      }
    </style>

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
                  <h1>AHR-iCon 2023</h1>
                  <h2 class="mb-3">Hello, <?php echo $currentUser['fname'] . " " . $currentUser['lname']; ?></h2>
                </div>

                <div class="col-12">
                  <div class="card mb-5">
                    <div class="card-header bg-dark">
                      <h5 class="text-white mb-0">Profile</h5>
                    </div>
                    <div class="card-body pt-3">
                        <strong>Abstract form : </strong>
                        <div class="row">
                            <div class="form-group col-12 col-sm-2 pt-2">
                              <label for="">Academic Title : </label>
                              <input type="text" class="form-control" id="txtTitle" value="<?php echo $currentUser['title']; ?>">
                            </div>

                            <div class="form-group col-12 col-sm-5 pt-2">
                              <label for="">First name : <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="txtFname" value="<?php echo $currentUser['fname']; ?>">
                            </div>

                            <div class="form-group col-12 col-sm-5 pt-2">
                              <label for="">Last name : <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="txtLname" value="<?php echo $currentUser['lname']; ?>">
                            </div>

                            <div class="form-group col-12 pt-2">
                              <label for="">Institution / Affaciliation / University : <span class="text-danger">*</span></label>
                              <textarea name="txtInstitution" class="form-control" id="txtInstitution" cols="30" rows="3" required><?php echo $currentUser['institution']; ?></textarea>
                            </div>

                            <div class="form-group col-12 pt-2">
                              <label for="">Address : <span class="text-danger">*</span></label>
                              <textarea name="txtAddress" class="form-control" id="txtAddress" cols="30" rows="3" required><?php echo $currentUser['address']; ?></textarea>
                            </div>

                            <div class="form-group col-12 col-sm-4 pt-2">
                              <label for="">Country : <span class="text-danger">*</span></label>
                              <select id="txtCountry" class="form-control">
                                <option value="" selected>Select</option>
                                <?php 
                                $strSQL = "SELECT CountryID, CountryName FROM sx4_country WHERE 1";
                                $resCountry = $db->fetch($strSQL, true, true);
                                if(($resCountry) && ($resCountry['status'])){
                                  foreach($resCountry['data'] as $row){
                                    ?>
                                    <option value="<?php echo $row['CountryID']; ?>" <?php if($currentUser['country'] == $row['CountryID']) { echo "selected"; } ?>><?php echo $row['CountryName']; ?></option>
                                    <?php
                                  }
                                }
                                ?>
                              </select>
                            </div>

                            <div class="form-group col-12 col-sm-4 pt-2">
                              <label for="">Gender : <span class="text-danger">*</span></label>
                              <select id="txtGender" class="form-control">
                                <option value="" selected>Select</option>
                                <option value="Male" <?php if($currentUser['gender'] == 'Male') { echo "selected"; } ?>>Male</option>
                                <option value="Feale" <?php if($currentUser['gender'] == 'Female') { echo "selected"; } ?>>Feale</option>
                              </select>
                            </div>

                            <div class="form-group col-12 col-sm-4 pt-2">
                              <label for="">E-mail address : <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="txtEmail" value="<?php echo $currentUser['email']; ?>" disabled readonly>
                            </div>


                            <div class="form-group pt-5 text-center d-none d-sm-block">
                                <button type="button" class="btn btn-label-secondary btn-lg" onclick="window.location = './'">Back to home</button> &nbsp;
                                <button type="button" class="btn btn-danger btn-lg" onclick="authen.update()">Update</button>
                            </div>

                            <div class="d-block d-sm-none pt-4">
                              <div class="d-grid gap-2 ">
                                <button class="btn btn-primary btn-lg" type="button" onclick="authen.update()">Update</button>
                                <button class="btn btn-secondary btn-lg" type="button"  onclick="window.location = './'">Back to home</button>
                              </div>
                            </div>
                          </div>

                    </div>
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
    <script src="../submission/assets/vendor/libs/dropzone/dropzone2.js"></script>
    <script src="../submission/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="../submission/assets/vendor/preload.js/dist/js/preload.js"></script>

    <script src="../submission/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../submission/assets/js/main.js"></script>

    <script src="../../config/js/config.conf.js?v=<?php echo $dateu; ?>"></script>
    <script src="../submission/assets/custom/js/authen.js?v=<?php echo $dateu; ?>"></script>

    <script>
      $(document).ready(function(){
          preload.hide()
      })

      $(function(){
      })
    </script>
    <!-- Page JS -->
  </body>
</html>
