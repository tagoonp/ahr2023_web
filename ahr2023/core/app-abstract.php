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

    <title>Submission</title>

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
                  <h2>Submission</h2>
                  <!-- Basic Breadcrumb -->
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a href="./">Home</a>
                      </li>
                      <li class="breadcrumb-item active">Submission</li>
                    </ol>
                  </nav>
                  <!-- Basic Breadcrumb -->
                </div>

                <div class="col-12 d-block d-sm-none">
                  <h1>AHR2023</h1>
                  <h2 class="mb-3">Submission</h2>
                </div>

                <div class="col-12 col-sm-8 col-md-10">
                  <div class="card mb-5">
                    <div class="card-header bg-dark">
                      <h5 class="text-white mb-0">List of Submission</h5>
                    </div>
                    <div class="card-body pt-3">
                      <button class="btn btn-primary" type="button" onclick="window.location='app-abstract-print'">Print</button>
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th>Code</th>
                            <th>Title</th>
                            <th style="width: 100px;">Type</th>
                            <th style="width: 100px;">Category</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                          $strSQL = "SELECT * FROM sx4_abstract a INNER JOIN sx4_account b ON a.abstract_uid = b.uid 
                                     WHERE 
                                     a.abstract_delete = 'N' 
                                     AND a.abstract_send = 'Y' 
                                     AND a.abstract_status != 'draft'
                                     AND b.delete_status = 'N'
                                     AND b.active_status = 'Y'
                                     ORDER BY a.abstract_ref_id";
                          $res = $db->fetch($strSQL, true, true);
                          if(($res) && ($res['status'])){
                            foreach ($res['data'] as $row) {
                              ?>
                              <tr>
                                <td style="vertical-align: top; width: 100px;"><?php echo $row['abstract_ref_id']; ?></td>
                                <td style="vertical-align: top;">
                                  <div class="text-dark">
                                  <?php 
                                  echo $row['abstract_title'] ;
                                  ?>
                                  </div>
                                  <div style="font-size: 0.8em; padding-top: 10px;">
                                  <?php 
                                  echo $row['title'] . $row['fname'] . " " . $row['lname'];
                                  ?>
                                  </div>
                                  <div style="font-size: 0.8em;">
                                  <?php 
                                  echo $row['institution'];
                                  ?>
                                  <br>
                                  <?php 
                                  echo "E-mail : " . $row['email'];
                                  ?>
                                  </div>
                                </td>
                                <td style="vertical-align: top;">
                                  <?php echo $row['abstract_present_type']; ?>
                                </td>
                                <td style="vertical-align: top;">
                                  <?php echo $row['abstract_category']; ?>
                                </td>
                                <td style="text-align: right;vertical-align: top; width: 120px;">
                                  <button class="btn btn-icon btn-primary" type="button" onclick="window.location = 'app-manage-submission?id=<?php echo $row['abstract_id'];?>'"><i class="bx bx-search"></i></button>  
                                  <?php
                                  if($currentUser['role_admin'] == 'Y'){
                                    ?>
                                    <button class="btn btn-icon btn-danger" type="button" onclick="submission.delete_submission('<?php echo $row['abstract_id'];?>')"><i class="bx bx-trash"></i></button>  
                                    <?php
                                  }else{
                                    ?>
                                    <button class="btn btn-icon btn-danger" type="button" disabled><i class="bx bx-trash"></i></button>  
                                    <?php
                                  }
                                  ?>
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
                  <h4><i class="bx bx-wrench"></i> Settings</h4>
                  
                  <div class="demo-inline-spacing mt-3">
                    <div class="list-group list-group-flush">
                      <a href="javascript:void(0);" class="list-group-item list-group-item-action">- General calling submission</a>
                      <a href="javascript:void(0);" class="list-group-item list-group-item-action">- Submission category</a>
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

    <script src="../submission/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../submission/assets/js/main.js"></script>

    <script src="../../config/js/config.conf.js?v=<?php echo $dateu; ?>"></script>
    <script src="../submission/assets/custom/js/authen.js?v=<?php echo $dateu; ?>"></script>
    <script src="../submission/assets/custom/js/submission.js?v=<?php echo $dateu; ?>"></script>

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
