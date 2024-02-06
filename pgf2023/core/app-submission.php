<?php 
require('../../config/php/config.conf.php');
require('../../config/php/database.php'); 
require('../../config/php/function.php'); 
require('../../config/php/user.php'); 

$page_name = basename(__FILE__) ;
$sid = $dateu.generateRandomString(4);
?>
<input type="hidden" id="txtUid" value="<?php echo $uid; ?>">
<input type="hidden" id="txtRole" value="<?php echo $role; ?>">
<input type="hidden" id="txtToken" value="<?php echo $token; ?>">
<input type="hidden" id="txtSid" value="<?php echo $sid; ?>">
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

    <title>PGF2023 : By Wisnior Submission System</title>

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
    <link rel="stylesheet" href="../submission/assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet" href="../submission/assets/vendor/preload.js/dist/css/preload.css">

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
                  <div class="pt-0 text-center pb-5">
                    <div class="demo-inline-spacing">
                      <button type="button" class="btn btn-icon btn-label-primary">
                        <span class="tf-icons bx bx-pie-chart-alt"></span>
                      </button>
                      <button type="button" class="btn btn-icon btn-label-secondary">
                        <span class="tf-icons bx bx-bell"></span>
                      </button>
                      <button type="button" class="btn rounded-pill btn-icon btn-label-primary">
                        <span class="tf-icons bx bx-pie-chart-alt"></span>
                      </button>
                      <button type="button" class="btn rounded-pill btn-icon btn-label-secondary">
                        <span class="tf-icons bx bx-bell"></span>
                      </button>
                    </div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                      <?php 
                      $abstract_number = 0;
                      $strSQL = "SELECT * FROM sx4_abstract WHERE abstract_uid = '$uid' AND abstract_delete = 'N'";
                      $resAbstract = $db->fetch($strSQL, true, true);
                      if(($resAbstract) && ($resAbstract['status'])){
                        $abstract_number = sizeof($resAbstract['data']);
                        ?>
                        <h5 class="text-dark">Your submission</h5>
                        <div class="text-left pt-3 pb-4">
                          <button class="btn btn-primary" id="btnAddAbstract" onclick="window.location='submission?sid=<?php echo $sid; ?>'"><i class="bx bx-plus"></i> Submit new abstract</button>
                          <div class="text-danger" style="font-size: 0.8em; padding-top: 4px;">
                            ** You can submit only 2 abstract
                          </div>
                        </div>
                        <div class="d-none d-sm-block">
                          <div class="table-responsive">
                            <table class="table table-striped">
                              <thead class="bg-dark">
                                <tr>
                                  <th class="text-white" style="width: 150px;">Abstract ID</th>
                                  <th class="text-white">Title</th>
                                  <th class="text-white" style="width: 250px;">Status</th>
                                  <th  style="width: 150px;"></th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php 
                                foreach($resAbstract['data'] as $row){
                                  ?>
                                  <tr>
                                    <td style="vertical-align: top;"><?php if($row['abstract_draft'] == 'Y'){}else{ echo "SID_".$row['abstract_ref_id']; }  ?></td>
                                    <td style="vertical-align: top;">
                                      <div class="text-dark"><?php echo $row['abstract_title']; ?></div>
                                      <div style="font-size: 0.8em;">
                                      <?php 
                                      $co_arr = array();
                                      $co_arr[] = $currentUser['fname'] . " " . $currentUser['lname'];
                                      $strSQL = "SELECT * FROM sx4_coauthor WHERE co_sid = '".$row['abstract_sid']."' AND co_delete = 'N'";
                                      $resCo = $db->fetch($strSQL , true, true);
                                      if(($resCo) && ($resCo['status'])){
                                        $c = 2;
                                        foreach($resCo['data'] as $row2){
                                          $co_arr[] = $row2['co_fullname'];
                                        }
                                      }
                                      if(sizeof($co_arr) > 1){
                                        $str_co = implode(', ', $co_arr);
                                        echo $str_co;
                                      }else{
                                        echo $currentUser['fname'] . " " . $currentUser['lname'];
                                      }
                                      ?>
                                      </div>
                                    </td>
                                    <td style="vertical-align: top;">
                                      <?php 
                                      if($row['abstract_draft'] == 'Y'){
                                           ?>
                                          <span class="badge rounded-pill bg-label-secondary">Draft</span>
                                          <?php
                                      }else{
                                        if(($row['abstract_status'] == 'wait for staff review') || ($row['abstract_status'] == 'wait for committee review') || ($row['abstract_status'] == 'wait for reviewer review')){
                                          ?>
                                          <span class="badge rounded-pill bg-primary">Under review</span>
                                          <?php
                                        }else if($row['abstract_status'] == 'wait for update'){
                                          ?>
                                          <span class="badge rounded-pill bg-warning">Wait for update</span>
                                          <?php
                                        }else if($row['abstract_status'] == 'accept'){
                                          ?>
                                          <span class="badge rounded-pill bg-success">Accepted</span>
                                          <?php
                                        }else if($row['abstract_status'] == 'reject'){
                                          ?>
                                          <span class="badge rounded-pill bg-danger">Reject</span>
                                          <?php
                                        }else{
                                          ?>
                                          <span class="badge bg-danger">Unknown status</span>
                                          <?php
                                        }
                                      }
                                      
                                      ?>
                                    </td>
                                    <td style="vertical-align: top;">
                                    <?php 
                                      if($row['abstract_draft'] == 'Y'){
                                        ?>
                                        <div class="text-right" style="text-align: right; padding-top: 2px;">
                                          <div class="demo-inline-spacing-" style="margin: 0px !important;">
                                            <button type="button" class="btn rounded-pill btn-icon btn-label-primary" onclick="window.location='submission?sid=<?php echo $row['abstract_sid']; ?>'">
                                              <span class="tf-icons bx bx-pencil"></span>
                                            </button>
                                            <button type="button" class="btn rounded-pill btn-icon btn-label-danger" onclick="submission.delete_co('<?php echo $row['abstract_id']; ?>', '<?php echo $row['abstract_title'] ; ?>')">
                                              <span class="tf-icons bx bx-trash"></span>
                                            </button>
                                          </div>
                                        </div>
                                        <?php
                                      }else{
                                        if($row['abstract_status'] == 'wait for staff review'){
                                          ?>
                                          <div class="text-right" style="text-align: right; padding-top: 2px;">
                                            <div class="demo-inline-spacing-" style="margin: 0px !important;">
                                              <button type="button" class="btn rounded-pill btn-icon btn-label-primary" onclick="window.location='submission_view?sid=<?php echo $row['abstract_sid']; ?>'">
                                                <span class="tf-icons bx bx-search"></span>
                                              </button>
                                              <button type="button" class="btn rounded-pill btn-icon btn-label-danger" onclick="submission.delete_abstract('<?php echo $row['abstract_id']; ?>', 'SID_<?php echo $row['abstract_ref_id']; ?>')">
                                                <span class="tf-icons bx bx-trash"></span>
                                              </button>
                                            </div>
                                          </div>
                                          <?php
                                        }
                                        else if( ($row['abstract_status'] == 'wait for committee review') || ($row['abstract_status'] == 'wait for reviewer review')){
                                          ?>
                                          <div class="text-right" style="text-align: right; padding-top: 2px;">
                                            <div class="demo-inline-spacing-" style="margin: 0px !important;">
                                              <button type="button" class="btn rounded-pill btn-icon btn-label-primary" onclick="window.location='submission_view?sid=<?php echo $row['abstract_sid']; ?>'"> 
                                                <span class="tf-icons bx bx-search"></span>
                                              </button>
                                              <button type="button" disabled class="btn rounded-pill btn-icon btn-label-danger">
                                                <span class="tf-icons bx bx-trash"></span>
                                              </button>
                                            </div>
                                          </div>
                                          <?php
                                        }else if($row['abstract_status'] == 'wait for update'){
                                          ?>
                                          <div class="text-right" style="text-align: right; padding-top: 2px;">
                                            <div class="demo-inline-spacing-" style="margin: 0px !important;">
                                              <button type="button" class="btn rounded-pill btn-icon btn-label-primary" onclick="window.location='submission_update?sid=<?php echo $row['abstract_sid']; ?>'">
                                                <span class="tf-icons bx bx-pencil"></span>
                                              </button>
                                              <button type="button" class="btn rounded-pill btn-icon btn-label-danger" onclick="submission.delete_abstract('<?php echo $row['abstract_id']; ?>')">
                                                <span class="tf-icons bx bx-trash"></span>
                                              </button>
                                            </div>
                                          </div>
                                          <?php
                                        }else if($row['abstract_status'] == 'accept'){
                                          ?>
                                          <div class="text-right" style="text-align: right; padding-top: 2px;">
                                            <div class="demo-inline-spacing-" style="margin: 0px !important;">
                                              <button type="button" class="btn rounded-pill btn-icon btn-label-primary" onclick="window.location='submission_view?sid=<?php echo $row['abstract_sid']; ?>'">
                                                <span class="tf-icons bx bx-pencil"></span>
                                              </button>
                                              <button type="button" disabled class="btn rounded-pill btn-icon btn-label-danger" >
                                                <span class="tf-icons bx bx-trash"></span>
                                              </button>
                                            </div>
                                          </div>
                                          <?php
                                        }else if($row['abstract_status'] == 'reject'){
                                          ?>
                                          <span class="badge bg-danger">Reject</span>
                                          <?php
                                        }else{
                                          ?>
                                          <span class="badge bg-danger">Unknown status</span>
                                          <?php
                                        }
                                      }
                                      
                                      ?>
                                    </td>
                                  </tr>
                                  <?php
                                }
                                ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <?php
                        
                      }else{
                        if(($currentUser['core_role'] == 'participant') && ($currentUser['presenter'] == 'Y')){
                          ?>
                          <div class="text-center pt-5">
                              <img src="../upload/img/folders.png" alt="" width="100">
                              <div class="text-center pt-3 pb-4">
                                <button class="btn btn-primary" onclick="window.location='submission?sid=<?php echo $sid; ?>'">Submit your abstract</button>
                              </div>
                            </div>
                          <?php
                        }else{
                          // --------------- Participant ------------------- //
                          ?>
                          <h3>Registration fee:</h3>
                          • On-site attendance as presenter and listener: 3,500 baht or 120 USD per person.<br>
                          • On-line presenter: 1,000 Baht or 30 USD per person<br>
                          • On-line listener: Free<br>
                          <div style="font-size: 0.8em;" class="text-danger">
                          ** Note: Send the registration fee via bank transfer to the bank account shown below. After the transfer, please attach the scanned receipt in the registration system.
                          </div>

                          <div style="padding: 30px; margin-top: 40px; border: dashed; border-width: 1px 1px 1px 1px; border-color: #ccc;">
                          <strong>Account Holder’s Name:</strong> Faculty of Medicine, Prince of Songkla University (Meeting)<br>
                          <strong>Bank Name:</strong> The Siam Commercial Bank PCL<br>
                          <strong>Bank Address:</strong> 15 Karnjanawanich Road, Hat Yai, Songkhla, Thailand, 90110<br>
                          <strong>Account Number:</strong> 565-2-64561-2<br>
                          <strong>Swift Code:</strong>  SICOTHBK
                          </div>
                          <?php
                        }
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>

              <input type="hidden" id="txtAbstractnumber" value="<?php echo $abstract_number; ?>">


              <div class="d-block d-sm-none">
                <div class="row mt-4">
                  <div class="d-grid gap-2 col-lg-6 mx-auto">
                    <button class="btn btn-danger btn-lg" type="button">Log out</button>
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
    <script src="../submission/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <script src="../submission/assets/vendor/preload.js/dist/js/preload.js"></script>

    <script src="../submission/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../submission/assets/js/main.js"></script>
    <script src="../../config/js/config.conf.js?v=<?php echo $dateu; ?>"></script>
    <script src="../submission/assets/custom/js/authen.js?v=<?php echo $dateu; ?>"></script>
    <script src="../submission/assets/custom/js/submission.js?v=<?php echo $dateu; ?>"></script>

    <script>
      $(document).ready(function(){
        preload.hide()
        if(parseInt($('#txtAbstractnumber').val()) >= 2){
          $('#btnAddAbstract').prop('disabled', 'disabled')
        }
      })
    </script>

    <!-- Page JS -->
  </body>
</html>
