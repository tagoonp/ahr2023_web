<?php 
require('../../config/php/config.conf.php');
require('../../config/php/database.php'); 
require('../../config/php/function.php'); 
require('../../config/php/user.php'); 

$page_name = basename(__FILE__) ;

$selected_uid = '';
if(!isset($_REQUEST['uid'])){
  $db->close();
  header('Location: ./');
  die();
}

$selected_uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);

$strSQL = "SELECT * FROM sx4_account WHERE uid = '$selected_uid'";
$resUser = $db->fetch($strSQL, false, false);
if(!$resUser){
  $db->close();
  echo "User not found";
  die();
}
?>

<input type="hidden" id="txtUid" value="<?php echo $uid; ?>">
<input type="hidden" id="txtRole" value="<?php echo $role; ?>">
<input type="hidden" id="txtToken" value="<?php echo $token; ?>">

<input type="hidden" id="txtSelectedUid" value="<?php echo $selected_uid; ?>">

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

    <title>Reviewer information</title>

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
                  <h2>Reviewer Information</h2>
                  <!-- Basic Breadcrumb -->
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a href="./">Home</a>
                      </li>
                      <li class="breadcrumb-item">
                        <a href="javascript:void(0);">Users</a>
                      </li>
                      <li class="breadcrumb-item"><a href="app-reviewer">Reviewer</a></li>
                      <li class="breadcrumb-item active"><?php echo $resUser['ucode']; ?></li>
                    </ol>
                  </nav>
                  <!-- Basic Breadcrumb -->
                </div>

                <div class="col-12 d-block d-sm-none">
                  <h1>PGF2023</h1>
                  <h2 class="mb-3">Reviewer information</h2>
                </div>

                <div class="col-12 col-sm-12 col-md-12">
                  <h5 class="mb-1">General information</h5>
                  <div class="card mb-3">
                    <div class="card-body">
                      <div class="row">
                        <div class="form-group col-2 mb-2">
                          <label for="">Academic title : </label>
                          <input type="text" id="txtTitle" class="form-control" value="<?php echo $resUser['title'];?>">
                        </div>
                        <div class="form-group col-5 mb-2">
                          <label for="">Name : <span class="text-danger">*</span></label>
                          <input type="text" id="txtFname" class="form-control" value="<?php echo $resUser['fname'];?>">
                        </div>
                        <div class="form-group col-5 mb-2">
                          <label for="">Surname : <span class="text-danger">*</span></label>
                          <input type="text" id="txtLname" class="form-control" value="<?php echo $resUser['lname'];?>">
                        </div>
                      </div>

                      <div class="row">
                        <div class="form-group col-6 mb-2">
                          <label for="">E-mail : <span class="text-danger">*</span> </label>
                          <input type="text" id="txtEmail" class="form-control" value="<?php echo $resUser['email'];?>">
                        </div>
                        <div class="form-group col-3 mb-2">
                          <label for="">Gender : <span class="text-danger">*</span></label>
                          <select name="txtGender" id="txtGender" class="form-control">
                            <option value="">-- Select --</option>
                            <option value="Male" <?php if($resUser['gender'] == 'Male'){ echo "selected"; } ?>>Male</option>
                            <option value="Female" <?php if($resUser['gender'] == 'Female'){ echo "selected"; } ?>>Female</option>
                          </select>
                        </div>
                        <div class="form-group col-3 mb-2">
                          <label for="">Primary role : <span class="text-danger">*</span></label>
                          <select name="txtPrimaryRole" id="txtPrimaryRole" class="form-control">
                            <option value="">-- Select --</option>
                            <option value="admin" <?php if($resUser['core_role'] == 'admin'){ echo "selected"; } ?>>Admin</option>
                            <option value="staff" <?php if($resUser['core_role'] == 'staff'){ echo "selected"; } ?>>Staff</option>
                            <option value="author" <?php if($resUser['core_role'] == 'author'){ echo "selected"; } ?>>Author</option>
                            <option value="reviewer" <?php if($resUser['core_role'] == 'reviewer'){ echo "selected"; } ?>>Reviewer</option>
                            <option value="participant" <?php if($resUser['core_role'] == 'participant'){ echo "selected"; } ?>>Participant</option>
                          </select>
                        </div>
                        <div class="form-group col-12 mb-2">
                          <label for="">Institution : <span class="text-danger">*</span> </label>
                          <textarea name="txtInstitution" id="txtInstitution" cols="30" rows="2" class="form-control"><?php echo $resUser['institution'];?></textarea>
                        </div>
                        <div class="form-group col-12 mb-2">
                          <label for="">Specializity : </label>
                          <textarea name="txtSpeciality" id="txtSpeciality" cols="30" rows="3" class="form-control"><?php echo $resUser['specialize'];?></textarea>
                        </div>
                        <div class="form-group col-12 mb-2">
                          <label for="">Address : </label>
                          <textarea name="txtAddress" id="txtAddress" cols="30" rows="5" class="form-control"><?php echo $resUser['address'];?></textarea>
                        </div>
                        <div class="form-group col-12 mb-2">
                          <label for="">Visit type : </label>
                          <select name="txtJointype" id="txtJointype" class="form-control">
                              <option value="">-- Select --</option>
                              <option value="local" <?php if($resUser['jointype'] == 'local'){ echo "selected"; } ?>>On-site</option>
                              <option value="online" <?php if($resUser['jointype'] == 'online'){ echo "selected"; } ?>>Online</option>
                            </select>
                        </div>
                        <div class="col-12 pt-3 text-right">
                          <button class="btn btn-danger" type="button" onclick="staff.updateReviewrInfo()">Save updated info.</button>
                        </div>
                      </div>

                    </div>
                  </div>

                  <h5 class="mb-2 mt-4">Other setting</h5>
                  <div class="card mb-5">
                    <div class="card-body">
                      <label for="">Additional role and privilledge : </label>
                      <div class="row mt-2">
                        <div class="form-group mb-2 col-3">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" onclick="staff.togglePriviledge('1', 'speaker')" <?php if($resUser['speaker'] == 'Y'){ echo "checked"; } ?> />
                            <label class="form-check-label" for="defaultCheck1"> Speaker </label>
                          </div>
                        </div>

                        <div class="form-group mb-2 col-3">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck2" onclick="staff.togglePriviledge('2', 'listener')" <?php if($resUser['listener'] == 'Y'){ echo "checked"; } ?> />
                            <label class="form-check-label" for="defaultCheck2"> LISTENER </label>
                          </div>
                        </div>

                        <div class="form-group mb-2 col-3">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck3" onclick="staff.togglePriviledge('3', 'join_ahr2023')" <?php if($resUser['join_ahr2023'] == 'Y'){ echo "checked"; } ?> />
                            <label class="form-check-label" for="defaultCheck3"> JOIN AHR2023</label>
                          </div>
                        </div>

                        <div class="form-group mb-2 col-3">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck4" onclick="staff.togglePriviledge('4', 'join_trip')" <?php if($resUser['join_trip'] == 'Y'){ echo "checked"; } ?> />
                            <label class="form-check-label" for="defaultCheck4"> JOIN TRIP </label>
                          </div>
                        </div>

                        

                      </div>
                    </div>
                  </div>

                  <h5 class="mb-2 mt-4">List of assigned review</h5>
                  <div class="card mb-5">
                    <div class="card-body pt-3">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th>Code</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th style="width: 50px;">Atricle status</th>
                            <th style="width: 50px;">Review status</th>
                            <th style="width: 50px;">Score</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                          $strSQL = "SELECT * FROM sx4_review a INNER JOIN sx4_account b ON a.rv_uid = b.uid 
                                     INNER JOIN sx4_abstract c ON a.rv_abstract_id = c.abstract_id 
                                     WHERE 
                                     b.active_status = 'Y' 
                                     AND b.allow_status = 'Y' 
                                     AND b.delete_status = 'N'
                                     AND b.role_reviewer = 'Y'
                                     AND b.uid = '$selected_uid'
                                     AND c.abstract_draft = 'N'
                                     AND c.abstract_send = 'Y'
                                     AND c.abstract_delete = 'N'
                                     ";
                          $res = $db->fetch($strSQL, true, true);
                          if(($res) && ($res['status'])){
                            foreach ($res['data'] as $row) {
                              ?>
                              <tr>
                                <td style="vertical-align: top;"><?php echo $row['abstract_ref_id']; ?></td>
                                <td style="vertical-align: top;">
                                  <?php 
                                  echo $row['abstract_title'];
                                  ?>
                                  <div class="pt-1">
                                    <button class="btn btn-icon btn-label-primary btn-sm" onclick="window.location='app-reviewer-info?uid=<?php echo $row['uid']; ?>'"><i class="bx bx-search"></i></button>  
                                    <button class="btn btn-icon btn-label-primary btn-sm" onclick="user.set_reviewer_invitation('<?php echo $row['uid']; ?>')"><i class="bx bx-envelope"></i></button>  
                                    <button class="btn btn-icon btn-label-danger btn-sm"><i class="bx bx-trash"></i></button> 
                                  </div>
                                </td>
                                <td style="vertical-align: top;">
                                 <?php echo $row['abstract_category'] ;?>
                                </td>
                                <td style="vertical-align: top;">
                                 <?php echo $row['abstract_present_type'] ;?>
                                </td>
                                <td style="vertical-align: top;">
                                 <?php echo ucfirst($row['abstract_status']); ?>
                                </td>
                                <td style="vertical-align: top;">
                                <?php echo ucfirst($row['rv_status']); ?>
                                </td>
                                <td style="vertical-align: top;">
                                <?php echo ucfirst($row['rv_score']); ?>
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
