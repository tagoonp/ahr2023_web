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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Participant</title>

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
    
    <table class="table table-striped" id="table-1" width="100%">
                        <thead>
                          <tr>
                            <th>Code</th>
                            <th>Fullname</th>
                            <th>Institution</th>
                            <th>E-mail</th>
                            <th style="width: 100px;">Author</th>
                            <th style="width: 100px;">Presenter</th>
                            <th style="width: 100px;">Listener</th>
                            <th style="width: 100px;">Activation</th>
                            <th>Visit</th>
                            <th>AHR Join</th>
                            <th>Half day trip</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                          $strSQL = "SELECT * FROM sx4_account a INNER JOIN sx4_country b ON a.country = b.CountryID 
                                     WHERE 
                                     active_status = 'Y' 
                                     AND role_participant = 'Y'
                                     AND allow_status = 'Y' 
                                     AND delete_status = 'N'
                                     ORDER BY ucode";
                          $res = $db->fetch($strSQL, true, true);
                          if(($res) && ($res['status'])){
                            foreach ($res['data'] as $row) {
                              ?>
                              <tr>
                                <td><?php echo $row['ucode']; ?></td>
                                <td>
                                  <?php 
                                  echo $row['title'] . $row['fname'] . " " . $row['lname'];
                                  ?>
                                </td>
                                <td>
                                  <?php 
                                  echo $row['institution'];
                                  ?>
                                </td>
                                <td>
                                  <?php 
                                  echo $row['email'];
                                  ?>
                                </td>
                                <td>
                                  <?php if($row['role_author'] == 'Y'){ echo 'Yes'; }else{ echo "-"; } ?>
                                </td>
                                <td>
                                <?php if($row['presenter'] == 'Y'){ echo 'Yes'; }else{ echo "-"; }  ?>
                                </td>
                                <td>
                                  <?php if($row['listener'] == 'Y'){ echo 'Yes'; }else{ echo "-"; }  ?>
                                </td>
                                <td>
                                  <?php if($row['active_status'] == 'Y'){ echo 'Yes'; }else{ echo "-"; }  ?>
                                </td>
                                <td style="vertical-align: top;">
                                  <?php if($row['jointype'] == 'online'){ echo "online"; }else{ echo "on-site"; }?>
                                </td>
                                <td style="vertical-align: top;">
                                  <?php if($row['join_ahr2023'] == 'Y'){ echo "Yes"; }else{ echo "No"; } ?>
                                </td>
                                <td style="vertical-align: top;">
                                  <?php if($row['join_trip'] == 'Y'){ echo "Yes"; }else{ echo "No"; } ?>
                                </td>
                              </tr>
                              <?php
                            }
                          }
                          ?>
                        </tbody>
                      </table>
            <!-- / Content -->

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>

      <!-- Drag Target Area To SlideIn Menu On Small Screens -->
      <div class="drag-target"></div>
    
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
    <script src="../submission/assets/custom/js/user.js?v=<?php echo $dateu; ?>"></script>

    <script>

var dt_basic_table = $('#table-1')

      $(document).ready(function(){
          preload.hide()

          
          if (dt_basic_table.length) {
              dt_basic = dt_basic_table.DataTable({
                  "ordering": false,
                  dom: 'Bfrtip',
                  buttons: [
                    {
                      extend: 'csv',
                      charset: 'UTF-8',
                      // fieldSeparator: ';',
                      bom: true,
                      filename: 'CsvTest',
                      title: 'CsvTest'
                    }
                  ]
              })
          }
      })

      $(function(){
      })
    </script>
    <!-- Page JS -->
  </body>
</html>
