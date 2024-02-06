<?php 
require('../config/php/config.conf.php');
require('../config/php/database.php'); 
require('../config/php/function.php'); 
require('../config/php/user.php'); 

$page_name = basename(__FILE__) ;

$sid = $dateu.generateRandomString(4);
if((isset($_REQUEST['sid'])) && ($_REQUEST['sid'] != '')){
  $sid = mysqli_real_escape_string($conn, $_REQUEST['sid']);
}else{
  header('Location: ./');
}

$abstract = false;

$strSQL = "SELECT * FROM sx4_abstract a INNER JOIN sx4_account b ON a.abstract_uid = b.uid WHERE a.abstract_sid = '$sid' AND a.abstract_delete = 'N' AND a.abstract_uid = '$uid'";
$abstract = $db->fetch($strSQL, false, false);

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

    <title>Abstract ID : <?php echo $abstract['abstract_ref_id']; ?></title>

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

                <div class="col-12">
                  <div class="card mb-5">
                    <div class="card-header bg-dark">
                      <h5 class="text-white mb-0">Submission ID : <?php echo $abstract['abstract_ref_id']; ?></h5>
                    </div>
                    <div class="card-body pt-3">
                        <strong>Abstract form : </strong>
                        <div class="row">
                            <div class="form-group col-12 pt-2">
                              <label for=""><strong>Title</strong> : <span class="text-danger">*</span></label>
                              <textarea name="txtTitle" disabled class="form-control" id="txtTitle" cols="30" rows="3" required><?php if($abstract){ echo $abstract['abstract_title']; } ?></textarea>
                            </div>

                            <div class="form-group col-12 col-sm-6 pt-3">
                              <label for=""><strong>Category</strong> : <span class="text-danger">*</span></label>
                              <select name="txtCat" id="txtCat" class="form-control" readonly disabled>
                                <option value="">-- Select --</option>
                                <option value="Health equity" <?php if(($abstract) && ($abstract['abstract_category'] == 'Health equity')){ echo "selected"; } ?>>Health equity</option>
                                <option value="Universal health coverage" <?php if(($abstract) && ($abstract['abstract_category'] == 'Universal health coverage')){ echo "selected"; } ?>>Universal health coverage</option>
                                <option value="Health systems and Policy integration" <?php if(($abstract) && ($abstract['abstract_category'] == 'Health systems and Policy integration')){ echo "selected"; } ?>>Health systems and Policy integration</option>
                                <option value="Health in sustainable development goals" <?php if(($abstract) && ($abstract['abstract_category'] == 'Health in sustainable development goals')){ echo "selected"; } ?>>Health in sustainable development goals</option>
                                <option value="Health workforce and finance" <?php if(($abstract) && ($abstract['abstract_category'] == 'Health workforce and finance')){ echo "selected"; } ?>>Health workforce and finance</option>
                                <option value="Primary health care" <?php if(($abstract) && ($abstract['abstract_category'] == 'Primary health care')){ echo "selected"; } ?>>Primary health care</option>
                              </select>
                            </div>

                            <div class="form-group col-12 col-sm-6 pt-3">
                              <label for=""><strong>Presentation type</strong> : <span class="text-danger">*</span></label>
                              <select name="txtType" id="txtType" class="form-control" readonly disabled>
                                <option value="">-- Select --</option>
                                <option value="Oral presentation" <?php if(($abstract) && ($abstract['abstract_present_type'] == 'Oral presentation')){ echo "selected"; } ?>>Oral presentation</option>
                                <option value="Poster presentation" <?php if(($abstract) && ($abstract['abstract_present_type'] == 'Poster presentation')){ echo "selected"; } ?>>Poster presentation</option>
                              </select>
                            </div>

                            <div class="d-none d-sm-block">
                              <div class="form-group col-12 pt-5">
                                <label for=""><strong>List of author</strong> : </label>
                                <table class="table table-striped table-borderless-">
                                  <thead>
                                    <tr>
                                      <th width="80">#</th>
                                      <th>Author / Co-author</th>
                                      <th>Responding author</th>
                                      <th>Presenter</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td style="vertical-align: top;">1</td>
                                      <td style="vertical-align: top;">
                                        <div class="text-dark"><?php echo $currentUser['fname'] . " " . $currentUser['lname']; ?></div>
                                        <div style="font-size: 0.8em;"><?php echo $currentUser['institution'] ; ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $currentUser['email'] ; ?></div>
                                      </td>
                                      <td>
                                        <i class='bx bxs-check-circle text-success' style="font-size: 1.6em;"></i>
                                      </td>
                                      <td>
                                        <i class='bx bxs-check-circle text-success' style="font-size: 1.6em;"></i>
                                      </td>
                                    </tr>
                                    <?php 
                                    $strSQL = "SELECT * FROM sx4_coauthor WHERE co_sid = '$sid' AND co_delete = 'N'";
                                    $resCo = $db->fetch($strSQL , true, true);
                                    if(($resCo) && ($resCo['status'])){
                                      $c = 2;
                                      foreach($resCo['data'] as $row){
                                        ?>
                                        <tr>
                                          <td style="vertical-align: top;"><?php echo $c; ?></td>
                                          <td style="vertical-align: top;">
                                            <div class="text-dark"><?php if(($row['co_title'] != '') && ($row['co_title'] != null)){ echo $row['co_title'];} ?> <?php echo $row['co_fullname'] ; ?></div>
                                            <div style="font-size: 0.8em;"><?php echo $row['co_institution'] ; ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $row['co_email'] ; ?></div>
                                          </td>
                                          <td style="vertical-align: top;">
                                            <?php 
                                            if($row['co_resonding'] == 'Y'){
                                              ?>
                                              <i class='bx bxs-check-circle text-success' style="font-size: 1.6em;"></i>
                                              <?php
                                            }else{
                                              ?>
                                              <i class='bx bx-minus-circle text-secondary' style="font-size: 1.5em;"></i>
                                              <?php
                                            }
                                            ?>
                                          </td>
                                          <td style="vertical-align: top;">
                                            <?php 
                                            if(($abstract) && ($abstract['abstract_status'] == 'accept')){
                                              ?>
                                              <div class="form-check">
                                                <input
                                                  class="form-check-input"
                                                  type="checkbox"
                                                  value=""
                                                  id="disabledCheck2"
                                                />
                                              </div>
                                              <?php
                                            }else{
                                              ?>
                                              <i class='bx bx-minus-circle text-secondary' style="font-size: 1.5em;"></i>
                                              <?php
                                            }
                                            ?>
                                          </td>
                                          
                                        </tr>
                                        <?php
                                        $c++;
                                      }
                                    }
                                    ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>

                            <div class="form-group col-12 col-sm-12 pt-3">
                              <label for=""><strong>Abstract file</strong> : <span class="text-danger">*</span></label>
                              <div class="row">
                                <div class="col-12">
                                  <button class="btn btn-label-primary btn-icon" onclick="window.open('<?php echo $abstract['abstract_recent_file']; ?>', target='_blank')"><i class="bx bx-download"></i></button>&nbsp;&nbsp;<?php echo $abstract['abstract_recent_file']; ?>
                                </div>
                              </div>
                            </div>


                            <div class="form-group pt-4 text-center">
                                <button type="button" class="btn btn-primary btn-lg" onclick="window.location='./'">Back to home</button>
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
    <script src="../submission/assets/custom/js/submission.js?v=<?php echo $dateu; ?>"></script>

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
