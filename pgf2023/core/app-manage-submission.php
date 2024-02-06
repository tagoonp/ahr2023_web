<?php 
require('../../config/php/config.conf.php');
require('../../config/php/database.php'); 
require('../../config/php/function.php'); 
require('../../config/php/user.php'); 

$page_name = basename(__FILE__) ;
$id = '';
if((isset($_REQUEST['id'])) && ($_REQUEST['id'] != '')){
  $id = mysqli_real_escape_string($conn, $_REQUEST['id']);
}else{
  $db->close();
  header('Location: ./');
}


$strSQL = "SELECT * FROM sx4_abstract a INNER JOIN sx4_account b ON a.abstract_uid = b.uid WHERE abstract_id = '$id'";
$resAbstract = $db->fetch($strSQL, false, false);

if($resAbstract){

}else{
  $db->close();
  header('Location: ./');
}
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

    <title>Submission ID : <?php echo $resAbstract['abstract_ref_id'];?></title>

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
                  <h2>Submission information</h2>
                  <!-- Basic Breadcrumb -->
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a href="./">Home</a>
                      </li>
                      <li class="breadcrumb-item"><a href="app-abstract">Submission</a></li>
                      <li class="breadcrumb-item active"><?php echo $resAbstract['abstract_ref_id'];?></li>
                    </ol>
                  </nav>
                  <!-- Basic Breadcrumb -->
                </div>

                <div class="col-12 col-sm-8 col-md-10">
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-12"><label for="" class="text-dark" >Title : </label></div>
                          <div class="col-12">
                            <div class="form-group">
                              <textarea name="" id="" cols="30" rows="3" class="form-control"><?php echo $resAbstract['abstract_title']; ?></textarea>
                            </div>
                          </div>
                        </div>

                        <div class="row mt-3">
                          <div class="col-12 col-sm-6">
                            <div class="row">
                              <div class="col-12">
                                <div class="form-group">
                                <label for="" class="text-dark">Category : </label>
                                  <select name="txtCat" id="txtCat" class="form-control">
                                    <option value="">-- Select --</option>
                                    <option value="Health equity" <?php if(($resAbstract) && ($resAbstract['abstract_category'] == 'Health equity')){ echo "selected"; } ?>>Health equity</option>
                                    <option value="Universal health coverage" <?php if(($resAbstract) && ($resAbstract['abstract_category'] == 'Universal health coverage')){ echo "selected"; } ?>>Universal health coverage</option>
                                    <option value="Health systems and Policy integration" <?php if(($resAbstract) && ($resAbstract['abstract_category'] == 'Health systems and Policy integration')){ echo "selected"; } ?>>Health systems and Policy integration</option>
                                    <option value="Health in sustainable development goals" <?php if(($resAbstract) && ($resAbstract['abstract_category'] == 'Health in sustainable development goals')){ echo "selected"; } ?>>Health in sustainable development goals</option>
                                    <option value="Health workforce and finance" <?php if(($resAbstract) && ($resAbstract['abstract_category'] == 'Health workforce and finance')){ echo "selected"; } ?>>Health workforce and finance</option>
                                    <option value="Primary health care" <?php if(($resAbstract) && ($resAbstract['abstract_category'] == 'Primary health care')){ echo "selected"; } ?>>Primary health care</option>
                                  </select>
                                </div>
                              </div>
                              
                            </div>
                          </div>
                          <div class="col-12 col-sm-6">
                            <div class="row">
                              <div class="col-12">
                                <label for="" class="text-dark">Presentation type : <span class="text-danger">*</span></label>
                                <select name="txtType" id="txtType" class="form-control">
                                  <option value="">-- Select --</option>
                                  <option value="Oral presentation" <?php if(($resAbstract) && ($resAbstract['abstract_present_type'] == 'Oral presentation')){ echo "selected"; } ?>>Oral presentation</option>
                                  <option value="Poster presentation" <?php if(($resAbstract) && ($resAbstract['abstract_present_type'] == 'Poster presentation')){ echo "selected"; } ?>>Poster presentation</option>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-12">
                            <div class="row">
                              <div class="col-12 pt-3"><label for="" class="text-dark">List of author : </label></div>

                              <div class="table-responsive">
                                <table class="table table-striped table-borderless-">
                                    <thead>
                                      <tr class="bg-dark">
                                        <th class="text-white" width="80">#</th>
                                        <th class="text-white">Author / Co-author</th>
                                        <th class="text-white">Corresponding author</th>
                                        <th class="text-white">Presenter</th>
                                        <th  class="text-white" width="200"></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td style="vertical-align: top;">1</td>
                                        <td style="vertical-align: top;">
                                          <div class="text-dark"><?php echo $resAbstract['title']. " ". $resAbstract['fname'] . " " . $resAbstract['lname']; ?></div>
                                          <div style="font-size: 0.8em;"><?php echo $resAbstract['institution'] ; ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $resAbstract['email'] ; ?></div>
                                        </td>
                                        <td>
                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="disabledCheck2" checked />
                                        </td>
                                        <td>
                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="disabledCheck2" checked />
                                        </td>
                                        <td style="vertical-align: top;">
                                          <div class="text-right" style="text-align: right; padding-top: 2px;">
                                            <div class="demo-inline-spacing-" style="margin: 0px !important;">
                                              <button type="button" class="btn rounded-pill btn-icon btn-label-primary" >
                                                <span class="tf-icons bx bx-pencil"></span>
                                              </button>
                                              <button type="button" class="btn rounded-pill btn-icon btn-label-danger" disabled>
                                                <span class="tf-icons bx bx-trash"></span>
                                              </button>
                                            </div>
                                          </div>
                                        </td>
                                      </tr>
                                      <?php 
                                      $strSQL = "SELECT * FROM sx4_coauthor WHERE co_sid = '".$resAbstract['abstract_sid']."' AND co_delete = 'N'";
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
                                                <div class="form-check">
                                                  <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    value=""
                                                    id="disabledCheck_<?php echo $row['co_id'];?>"
                                                    checked
                                                    onclick="submission.toggle_response('N', '<?php echo $row['co_id']; ?>', '<?php echo $row['co_fullname'] ; ?>')"
                                                  />
                                                </div>
                                                <?php
                                              }else{
                                                ?>
                                                <div class="form-check">
                                                  <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    value=""
                                                    id="disabledCheck_<?php echo $row['co_id'];?>"
                                                    onclick="submission.toggle_response('Y', '<?php echo $row['co_id']; ?>', '<?php echo $row['co_fullname'] ; ?>')"
                                                  />
                                                </div>
                                                <?php
                                              }
                                              ?>
                                            </td>
                                            <td style="vertical-align: top; width: 200px;">
                                              <?php 
                                              if(($resAbstract) && ($resAbstract['abstract_status'] == 'accept')){
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
                                                <div class="form-check">
                                                  <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    value=""
                                                    id="disabledCheck2"
                                                    
                                                  />
                                                </div>
                                                <?php
                                              }
                                              ?>
                                            </td>
                                            <td style="vertical-align: top;">
                                              <div class="text-right" style="text-align: right; padding-top: 2px;">
                                                <div class="demo-inline-spacing-" style="margin: 0px !important;">
                                                  <button type="button" class="btn rounded-pill btn-icon btn-label-primary" onclick="submission.set_co('<?php echo $row['co_id']; ?>', '<?php echo $row['co_title']; ?>', '<?php echo $row['co_fullname']; ?>', '<?php echo $row['co_email']; ?>', '<?php echo $row['co_institution']; ?>', '<?php echo $row['co_resonding']; ?>')">
                                                    <span class="tf-icons bx bx-pencil"></span>
                                                  </button>
                                                  <button type="button" class="btn rounded-pill btn-icon btn-label-danger" onclick="submission.delete_co('<?php echo $row['co_id']; ?>', '<?php echo $row['co_fullname'] ; ?>')">
                                                    <span class="tf-icons bx bx-trash"></span>
                                                  </button>
                                                </div>
                                              </div>
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
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-12">
                            <div class="row">
                              <div class="col-12 pt-3"><label for="" class="text-dark">Attached file : <a href="<?php echo $resAbstract['abstract_recent_file']; ?>" target="_blank"><?php echo $resAbstract['abstract_recent_file']; ?></a></label></div>
                            </div>
                          </div>
                        </div>
                        
                        <div class="row">
                          <div class="col-12 pt-3"><label for="" class="text-dark">Staff action : </label></div>
                          <div class="text-dark">
                            <button class="btn btn-danger" onclick="staff.openModal('modalStaffAction')"><i class="bx bx-wrench"></i> Add action</button> 
                          </div>
                        </div>

                        <?php 
                        if(($resAbstract) && ($resAbstract['abstract_status'] != 'draft') && ($resAbstract['abstract_status'] != 'wait for staff review') ) {
                          ?>
                          <hr class="mb-3 mt-4">
                          <h4 class="mb-1">Review process</h4>
                          <div class="row mt-1">
                            <div class="col-12">
                              <div class="row">
                              <div class="col-12 pt-3"><label for="" class="text-dark">Assigned reviewer and result : </label></div>
                                <div class="col-12">
                                  <table class="table table-bordered table-stripted">
                                    <thead>
                                      <tr class="bg-dark">
                                        <th class="text-white" width="50">#</th>
                                        <th class="text-white">Reviewer name</th>
                                        <th class="text-white" width="100">Score</th>
                                        <th class="text-white" width="120"></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td colspan="4" class="text-center">No reviewer selected.</td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <div class="col-12 pt-2">
                                  <button class="btn btn-primary" type="button" onclick="staff.openModal('modalSelectReviewer')"><i class="bx bx-plus"></i> Add reviewer</button>
                                </div>
                              </div>
                            </div>
                          </div>


                          <div class="row mt-3">
                            <div class="col-12">
                              <div class="row">
                                <div class="col-12 pt-3"><label for="" class="text-dark">Committee result : </label></div>
                                <div class="col-12">
                                  <table class="table table-bordered table-stripted">
                                    <thead>
                                      <tr class="bg-dark">
                                        <th class="text-white" width="50">#</th>
                                        <th class="text-white">Reviewer name</th>
                                        <th class="text-white" width="100">Score</th>
                                        <th class="text-white" width="120"></th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td colspan="4" class="text-center">No reviewer selected.</td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <div class="col-12 pt-2">
                                  <button class="btn btn-primary"><i class="bx bx-plus"></i> Add reviewer</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <?php
                        }
                        ?>
                        
                        

                        
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

    <script src="../submission/assets/vendor/js/menu.js"></script>
    <script src="../submission/assets/vendor/libs/quill/katex.js"></script>
    <script src="../submission/assets/vendor/libs/quill/quill.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../submission/assets/js/main.js"></script>

    <script src="../../config/js/config.conf.js?v=<?php echo $dateu; ?>"></script>
    <script src="../submission/assets/custom/js/authen.js?v=<?php echo $dateu; ?>"></script>
    <script src="../submission/assets/custom/js/submission.js?v=<?php echo $dateu; ?>"></script>
    <script src="../submission/assets/custom/js/staff.js?v=<?php echo $dateu; ?>"></script>
    <script src="../submission/assets/custom/js/user.js?v=<?php echo $dateu; ?>"></script>

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
