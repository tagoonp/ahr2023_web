<?php 
require('../../config/php/config.conf.php');
require('../../config/php/database.php'); 
require('../../config/php/function.php'); 
require('../../config/php/user.php'); 

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

    <title>Reviewer</title>

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
    <link rel="stylesheet" href="../submission/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="../submission/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="../submission/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
    <link rel="stylesheet" href="../submission/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />

    <link rel="stylesheet" href="../submission/assets/vendor/libs/quill/typography.css" />
    <link rel="stylesheet" href="../submission/assets/vendor/libs/quill/editor.css" />

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
                  <h5 class="mb-1">Hello, <?php echo $currentUser['fname'] . " " . $currentUser['lname']; ?></h5>
                  <h2>Reviewer</h2>
                  <!-- Basic Breadcrumb -->
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a href="./">Home</a>
                      </li>
                      <li class="breadcrumb-item">
                        <a href="javascript:void(0);">Users</a>
                      </li>
                      <li class="breadcrumb-item active">Reviewer</li>
                    </ol>
                  </nav>
                  <!-- Basic Breadcrumb -->
                </div>

                <div class="col-12 d-block d-sm-none">
                  <h1>PGF2023</h1>
                  <h2 class="mb-3">Reviewer</h2>
                </div>

                <div class="col-12 col-sm-8 col-md-10">
                  <div class="card mb-5">
                    <div class="card-header bg-dark">
                      <h5 class="text-white mb-0">List of Reviewer</h5>
                    </div>
                    <div class="card-body pt-3 table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th>Code</th>
                            <th style="width: 200px;">Fullname</th>
                            <th>E-mail</th>
                            <th >Review send</th>
                            <th >Review accept</th>
                            <th >Review reject</th>
                            <th >Review non-response</th>
                            <th >Invitation</th>
                            <th >Acception</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                          $strSQL = "SELECT * FROM sx4_account a INNER JOIN sx4_country b ON a.country = b.CountryID 
                                     WHERE 
                                     active_status = 'Y' 
                                     AND allow_status = 'Y' 
                                     AND delete_status = 'N'
                                     AND role_reviewer = 'Y'";
                          $res = $db->fetch($strSQL, true, true);
                          if(($res) && ($res['status'])){
                            foreach ($res['data'] as $row) {
                              ?>
                              <tr>
                                <td style="vertical-align: top;"><?php echo $row['ucode']; ?></td>
                                <td style="vertical-align: top; widht: 200px;">
                                  <?php 
                                  echo $row['title'] . $row['fname'] . " " . $row['lname'];
                                  ?>
                                  <div style="font-size: 0.8em;">
                                  <?php 
                                  echo $row['institution'];
                                  ?>
                                  </div>
                                  <div class="pt-1">
                                    <button class="btn btn-icon btn-label-primary btn-sm" onclick="window.location='app-reviewer-info?uid=<?php echo $row['uid']; ?>'"><i class="bx bx-search"></i></button>  
                                    <button class="btn btn-icon btn-label-primary btn-sm" onclick="user.set_reviewer_invitation('<?php echo $row['uid']; ?>')"><i class="bx bx-envelope"></i></button>  
                                    <button class="btn btn-icon btn-label-danger btn-sm"><i class="bx bx-trash"></i></button> 
                                  </div>
                                </td>
                                <td style="vertical-align: top;">
                                 <?php echo $row['email'] ;?>
                                </td>
                                <td style="vertical-align: top;">
                                 <?php 
                                  $strSQL = "SELECT COUNT(rv_id) cn FROM sx4_review WHERE rv_uid = '".$row['uid']."' AND rv_delete = 'N'";
                                  $res = $db->fetch($strSQL, false, false);
                                  if($res){ echo $res['cn']; }else{ echo "0"; }
                                 ?>
                                </td>
                                <td style="vertical-align: top;">
                                <?php 
                                  $strSQL = "SELECT COUNT(rv_id) cn FROM sx4_review WHERE rv_uid = '".$row['uid']."' AND rv_status = 'accept' AND rv_delete = 'N'";
                                  $res = $db->fetch($strSQL, false, false);
                                  if($res){ echo $res['cn']; }else{ echo "0"; }
                                 ?>
                                </td>
                                <td style="vertical-align: top;">
                                <?php 
                                  $strSQL = "SELECT COUNT(rv_id) cn FROM sx4_review WHERE rv_uid = '".$row['uid']."' AND rv_status = 'reject' AND rv_delete = 'N'";
                                  $res = $db->fetch($strSQL, false, false);
                                  if($res){ echo $res['cn']; }else{ echo "0"; }
                                 ?>
                                </td>
                                <td style="vertical-align: top;">
                                <?php 
                                  $strSQL = "SELECT COUNT(rv_id) cn FROM sx4_review WHERE rv_uid = '".$row['uid']."' AND rv_status = 'send' AND rv_delete = 'N'";
                                  $res = $db->fetch($strSQL, false, false);
                                  if($res){ echo $res['cn']; }else{ echo "0"; }
                                 ?>
                                </td>
                                <td style="vertical-align: top;">
                                 <?php if($row['invitation_send'] == 'Y'){ echo "<i class='bx bxs-check-circle text-success'></i>"; }else{ echo "-"; } ?>
                                </td>
                                <td style="vertical-align: top;">
                                 <?php if($row['reviewer_acception'] == 'Y'){ echo "<i class='bx bxs-check-circle text-success'></i>"; }else{ echo "-"; } ?>
                                </td>
                              </tr>
                              <?php
                            }
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <div class="col-12 col-sm-4 col-md-2">
                  <h4>Add reviewer</h4>
                  <div class="form-group">
                    <label for="">User code : <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter user code .." id="txtXcode">
                    <div style="font-size: 0.78em; padding: 5px;" class="text-muted;">You can find user code on participant page.</div>
                  </div>
                  <div class="form-group pt-2">
                    <button class="btn btn-primary" type="button" onclick="user.set_reviewer()">Save</button>
                    <button class="btn btn-label-secondary" onclick="$('#txtXcode').val('')">Reset</button>
                  </div>
                  <hr>
                  <p>
                    Or add new reviewer manually
                  </p>
                  <div class="form-group pt-2">
                    <button class="btn btn-primary" type="button" onclick="staff.openModal('modalAddReviewer')">Add new reviewer</button>
                  </div>
                  <!-- <button class="btn" style="background-color: green; color: #fff; padding: 10px 30px; font-size: 20px; cursor: pointer;">Accept</button>&nbsp;&nbsp;<button class="btn" style="background-color: red; color: #fff; padding: 10px 30px; font-size: 20px;">Reject</button> -->
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

    <?php require_once('./comp/modal.php'); ?>

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
     <!-- Vendors JS -->
    <script src="../submission/assets/vendor/libs/datatables/jquery.dataTables.js"></script>
    <script src="../submission/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
    <script src="../submission/assets/vendor/libs/datatables-responsive/datatables.responsive.js"></script>
    <script src="../submission/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js"></script>
    <script src="../submission/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.js"></script>
    <script src="../submission/assets/vendor/libs/datatables-buttons/datatables-buttons.js"></script>
    <script src="../submission/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.js"></script>
    <script src="../submission/assets/vendor/libs/jszip/jszip.js"></script>
    <script src="../submission/assets/vendor/libs/pdfmake/pdfmake.js"></script>
    <script src="../submission/assets/vendor/libs/datatables-buttons/buttons.html5.js"></script>
    <script src="../submission/assets/vendor/libs/datatables-buttons/buttons.print.js"></script>
    <script src="../submission/assets/vendor/libs/datatables-rowgroup/datatables.rowgroup.js"></script>
    <script src="../submission/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.js"></script>
    <!-- Vendors JS -->
    <script src="../submission/assets/vendor/libs/quill/katex.js"></script>
    <script src="../submission/assets/vendor/libs/quill/quill.js"></script>

    <script src="../submission/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../submission/assets/js/main.js"></script>

    <script src="../../config/js/config.conf.js?v=<?php echo $dateu; ?>"></script>
    <script src="../submission/assets/custom/js/authen.js?v=<?php echo $dateu; ?>"></script>
    <script src="../submission/assets/custom/js/user.js?v=<?php echo $dateu; ?>"></script>
    <script src="../submission/assets/custom/js/staff.js?v=<?php echo $dateu; ?>"></script>

    <script>

    var dt_basic_table = $('#table-1')

      $(document).ready(function(){
          preload.hide()

          
          if (dt_basic_table.length) {
              dt_basic = dt_basic_table.DataTable({
                  "ordering": false
              })
          }

          
      })

      $(function(){
      })
    </script>
    <!-- Page JS -->
  </body>
</html>
