<?php 
require('../../config/php/config.conf.php');
require('../../config/php/database.php'); 
require('../../config/php/function.php'); 
require('../../config/php/mailer.php'); 

$page_name = basename(__FILE__) ;

?>
<!DOCTYPE html>

<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="./assets/"
  data-template="horizontal-menu-template"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>AHR-iCon 2023 : Register</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="./assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons -->
    <link rel="stylesheet" href="./assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="./assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="./assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="./assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="./assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="./assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="./assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="./assets/vendor/libs/typeahead-js/typeahead.css" />
    <!-- Vendor -->
    <link rel="stylesheet" href="./assets/vendor/libs/bs-stepper/bs-stepper.css" />
    <link rel="stylesheet" href="./assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="./assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="./assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" />
    <link rel="stylesheet" href="./assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet" href="./assets/vendor/preload.js/dist/css/preload.css">

    <!-- Page CSS -->

    <!-- Page -->
    <link rel="stylesheet" href="./assets/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="./assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="./assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="./assets/js/config.js"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="authentication-wrapper authentication-cover">
      <div class="authentication-inner row m-0">
        <!-- Left Text -->
        <div class="d-none d-lg-flex col-lg-4 align-items-center justify-content-end p-5 pe-0">
          <div class="w-px-400">
            <img
              src="./assets/img/illustrations/create-account-light.png"
              class="img-fluid"
              alt="multi-steps"
              width="600"
              data-app-dark-img="illustrations/create-account-dark.png"
              data-app-light-img="illustrations/create-account-light.png"
            />
          </div>
        </div>
        <!-- /Left Text -->

        <!--  Multi Steps Registration -->
        <div class="d-flex col-lg-8 align-items-center authentication-bg p-sm-5 p-3">
          <div class="w-px-700 mx-auto">
            <div id="multiStepsValidation" class="bs-stepper shadow-none">

              <div class="mb-3" style="padding-left: 20px;">
                <h3 class="mb-1">Registration form</h3>
                <span>Enter Your Account Details</span>
              </div>
              <div class="bs-stepper-header border-bottom-0">
                <div class="step" data-target="#accountDetailsValidation">
                  <button type="button" class="step-trigger">
                    <span class="bs-stepper-circle"><i class="bx bx-home-alt"></i></span>
                    <span class="bs-stepper-label mt-1">
                      <span class="bs-stepper-title">Account</span>
                      <span class="bs-stepper-subtitle">Account details</span>
                    </span>
                  </button>
                </div>
                <div class="line">
                  <i class="bx bx-chevron-right"></i>
                </div>
                <div class="step" data-target="#personalInfoValidation">
                  <button type="button" class="step-trigger">
                    <span class="bs-stepper-circle"><i class="bx bx-user"></i></span>
                    <span class="bs-stepper-label mt-1">
                      <span class="bs-stepper-title">Personal</span>
                      <span class="bs-stepper-subtitle">Enter information</span>
                    </span>
                  </button>
                </div>
                <div class="line">
                  <i class="bx bx-chevron-right"></i>
                </div>
                <div class="step" data-target="#billingLinksValidation">
                  <button type="button" class="step-trigger">
                    <span class="bs-stepper-circle"><i class="bx bx-detail"></i></span>
                    <span class="bs-stepper-label mt-1">
                      <span class="bs-stepper-title">Other</span>
                      <span class="bs-stepper-subtitle">Other required details</span>
                    </span>
                  </button>
                </div>
              </div>
              <div class="bs-stepper-content">
                <form id="multiStepsForm" onsubmit="return false;" autocomplete="off">
                  <!-- Account Details -->
                  <div id="accountDetailsValidation" class="content">
                    <div class="row g-3">
                      <div class="col-sm-12">
                        <label class="form-label" for="multiStepsEmail">Email : <span class="text-danger">*</span></label>
                        <input
                          type="email"
                          name="multiStepsEmail"
                          id="multiStepsEmail"
                          class="form-control"
                          placeholder="john.doe@email.com"
                          aria-label="john.doe"
                        />
                      </div>
                      <div class="col-sm-6 form-password-toggle">
                        <label class="form-label" for="multiStepsPass">Password : <span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                          <input
                            type="password"
                            id="multiStepsPass"
                            name="multiStepsPass"
                            class="form-control"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="multiStepsPass2"
                          />
                          <span class="input-group-text cursor-pointer" id="multiStepsPass2"
                            ><i class="bx bx-hide"></i
                          ></span>
                        </div>
                      </div>
                      <div class="col-sm-6 form-password-toggle">
                        <label class="form-label" for="multiStepsConfirmPass">Confirm Password : <span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                          <input
                            type="password"
                            id="multiStepsConfirmPass"
                            name="multiStepsConfirmPass"
                            class="form-control"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="multiStepsConfirmPass2"
                          />
                          <span class="input-group-text cursor-pointer" id="multiStepsConfirmPass2"
                            ><i class="bx bx-hide"></i
                          ></span>
                        </div>
                      </div>
                      <div class="col-12 d-flex justify-content-between">
                        <button class="btn btn-label-secondary btn-prev" disabled>
                          <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                          <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </button>
                        <button class="btn btn-primary btn-next">
                          <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Next</span>
                          <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <!-- Personal Info -->
                  <div id="personalInfoValidation" class="content">
                    <div class="row g-3">
                      <div class="col-sm-6">
                        <label class="form-label" for="multiStepsTitle">Academic title : </label>
                        <input
                          type="text"
                          id="multiStepsTitle"
                          name="multiStepsTitle"
                          class="form-control"
                          placeholder="Mr. , Prof., etc."
                        />
                      </div>
                      <div class="col-sm-6">
                        <label class="form-label" for="multiGender">Gender : <span class="text-danger">*</span></label>
                        <select id="multiGender" class="form-control" required>
                          <option value="">Select</option>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                        </select>
                      </div>
                      <div class="col-sm-6">
                        <label class="form-label" for="multiStepsFirstName">First Name : <span class="text-danger">*</span></label>
                        <input
                          type="text"
                          id="multiStepsFirstName"
                          name="multiStepsFirstName"
                          class="form-control"
                          placeholder="John"
                        />
                      </div>
                      <div class="col-sm-6">
                        <label class="form-label" for="multiStepsLastName">Last Name : <span class="text-danger">*</span></label>
                        <input
                          type="text"
                          id="multiStepsLastName"
                          name="multiStepsLastName"
                          class="form-control"
                          placeholder="Doe"
                        />
                      </div>
                      <div class="col-sm-12">
                        <label class="form-label" for="multiStepsUniversity">University / Institution / Affiliation : <span class="text-danger">*</span></label>
                        <input
                          type="text"
                          id="multiStepsUniversity"
                          name="multiStepsUniversity"
                          class="form-control"
                          placeholder="Name of affiliation"
                        />
                      </div>
                      <div class="col-md-12">
                        <label class="form-label" for="multiStepsAddress">Address  : <span class="text-danger">*</span></label>
                        <input
                          type="text"
                          id="multiStepsAddress"
                          name="multiStepsAddress"
                          class="form-control"
                          placeholder="Address"
                        />
                      </div>
                      <div class="col-sm-12">
                        <label class="form-label" for="multiStepsState">Country</label>
                        <select id="multiStepsState" class=" select2 form-select" required>
                          <option value="" >Select</option>
                          <?php 
                          $strSQL = "SELECT CountryID, CountryName FROM sx4_country WHERE 1";
                          $resCountry = $db->fetch($strSQL, true, true);
                          if(($resCountry) && ($resCountry['status'])){
                            foreach($resCountry['data'] as $row){
                              ?>
                              <option value="<?php echo $row['CountryID']; ?>"><?php echo $row['CountryName']; ?></option>
                              <?php
                            }
                          }
                          ?>
                        </select>
                      </div>
                      <div class="col-12 d-flex justify-content-between">
                        <button class="btn btn-primary btn-prev">
                          <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                          <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </button>
                        <button class="btn btn-primary btn-next">
                          <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Next</span>
                          <i class="bx bx-chevron-right bx-sm me-sm-n2"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <!-- Billing Links -->
                  <div id="billingLinksValidation" class="content">
                    <!-- Credit Card Details -->
                    <div class="row g-3">
                      <div class="col-sm-12 col-md-6">
                        <label class="form-label" for="multiVisit">Type of visit : <span class="text-danger">*</span></label>
                        <select id="multiVisit" name="multiVisit" class="form-select multiVisit">
                          <option value="" selected>Select</option>
                          <option value="1">On-site (Local visit at Prince of Songkla University, Thailand)</option>
                          <option value="2">On-line visit (Join via zoom)</option>
                        </select>
                      </div>

                      <div class="col-sm-12 col-md-6">
                        <label class="form-label" for="multiPaticipant">Type of participate : <span class="text-danger">*</span></label>
                        <select id="multiPaticipant" name="multiPaticipant" class="form-select multiPaticipant">
                          <option value="" selected>Select</option>
                          <option value="1">Presenters (Main-Author)</option>
                          <option value="3">Speaker</option>
                          <option value="2">Listeners</option>
                        </select>
                        <div class="text-danger" style="font-size: 0.8em;">** Careful! : Only author can submit the abstract</div>
                      </div>

                      <div class="col-12 d-flex justify-content-between">
                        <button class="btn btn-primary btn-prev">
                          <i class="bx bx-chevron-left bx-sm ms-sm-n2"></i>
                          <span class="align-middle d-sm-inline-block d-none">Previous</span>
                        </button>
                        <button type="submit" class="btn btn-success btn-next btn-submit">Submit</button>
                      </div>
                    </div>
                    <!--/ Credit Card Details -->
                  </div>
                </form>

                <p class="text-left pt-5">
                  <span>Already have account?</span>
                  <a href="./">
                    <span>Go to login</span>
                  </a>
                </p>
              </div>
            </div>
          </div>
        </div>
        <!-- / Multi Steps Registration -->
      </div>
    </div>

    <script>
      // Check selected custom option
      window.Helpers.initCustomOptionCheck();
    </script>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="./assets/vendor/libs/jquery/jquery.js"></script>
    <script src="./assets/vendor/libs/popper/popper.js"></script>
    <script src="./assets/vendor/js/bootstrap.js"></script>
    <script src="./assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="./assets/vendor/libs/hammer/hammer.js"></script>
    <script src="./assets/vendor/libs/i18n/i18n.js"></script>
    <script src="./assets/vendor/libs/typeahead-js/typeahead.js"></script>

    <script src="./assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="./assets/vendor/libs/cleavejs/cleave.js"></script>
    <script src="./assets/vendor/libs/cleavejs/cleave-phone.js"></script>
    <script src="./assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
    <script src="./assets/vendor/libs/select2/select2.js"></script>
    <script src="./assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="./assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="./assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>
    <script src="./assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="./assets/vendor/preload.js/dist/js/preload.js"></script>

    <!-- Main JS -->
    <script src="./assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="./assets/js/pages-auth-multisteps.js"></script>
    
    <script src="../../config/js/config.conf.js?v=<?php echo $dateu; ?>"></script>
    <script src="./assets/custom/js/authen.js?v=<?php echo $dateu; ?>"></script>

    <script>
      $(document).ready(function(){
          preload.hide()
          setTimeout(() => {
            $('#multiStepsEmail').focus()
          }, 300);
      })
    </script>
  </body>
</html>
