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

if(!$abstract){
  header('Location: ./');
  die();
}

if($abstract['abstract_status'] != 'wait for update'){
  header('Location: ./submission_view?sid=' . $sid);
  die();
}

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

    <title>AHR2023 : Submit new abstract</title>

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
                      <h5 class="text-white mb-0">Submit new abstract</h5>
                    </div>
                    <div class="card-body pt-3">
                        <strong>Aggreement : </strong>
                        <ol class="pt-2">
                          <li>Only main-author can be upload and submit the abstract.</li>
                          <li>Main-author can choose or change the presenter after accepted.</li>
                          <li>Your abstract file <span class="text-danger">(accept only word file *.doc or *.docx)</span> must be follow the instruction <a href="https://postgraduateforum2023.com/submission" target="_blank">- here -</a>.</li>
                        </ol>
                        <hr>
                        <strong>Abstract form : </strong>
                        <div class="row">
                            <div class="form-group col-12 pt-2">
                              <label for="">Title : <span class="text-danger">*</span></label>
                              <textarea name="txtTitle" class="form-control" id="txtTitle" cols="30" rows="3" required><?php if($abstract){ echo $abstract['abstract_title']; } ?></textarea>
                            </div>

                            <div class="form-group col-12 col-sm-6 pt-3">
                              <label for="">Category : <span class="text-danger">*</span></label>
                              <select name="txtCat" id="txtCat" class="form-control">
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
                              <label for="">Presentation type : <span class="text-danger">*</span></label>
                              <select name="txtType" id="txtType" class="form-control">
                                <option value="">-- Select --</option>
                                <option value="Oral presentation" <?php if(($abstract) && ($abstract['abstract_present_type'] == 'Oral presentation')){ echo "selected"; } ?>>Oral presentation</option>
                                <option value="Poster presentation" <?php if(($abstract) && ($abstract['abstract_present_type'] == 'Poster presentation')){ echo "selected"; } ?>>Poster presentation</option>
                              </select>
                            </div>

                            <div class="d-none d-sm-block">
                              <div class="form-group col-12 pt-3">
                                <label for="">List of author : <span class="text-danger">* accept only word file (.doc, .docx)</span></label>
                                <table class="table table-striped table-borderless-">
                                  <thead>
                                    <tr>
                                      <th width="80">#</th>
                                      <th>Author / Co-author</th>
                                      <th>Responding author</th>
                                      <th>Presenter</th>
                                      <th width="200"></th>
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
                                        <!-- <label class="switch switch-primary">
                                          <input type="checkbox" class="switch-input" checked />
                                          <span class="switch-toggle-slider">
                                          </span>
                                        </label> -->
                                        <div class="form-check">
                                          <input
                                            class="form-check-input"
                                            type="checkbox"
                                            value=""
                                            id="disabledCheck2"
                                            disabled
                                            checked
                                          />
                                      </td>
                                      <td>
                                        <div class="form-check">
                                          <input
                                            class="form-check-input"
                                            type="checkbox"
                                            value=""
                                            id="disabledCheck2"
                                            disabled
                                            checked
                                          />
                                      </td>
                                      <td style="vertical-align: top;">
                                        <div class="text-right" style="text-align: right; padding-top: 2px;">
                                          <div class="demo-inline-spacing-" style="margin: 0px !important;">
                                            <button type="button" class="btn rounded-pill btn-icon btn-label-primary" disabled>
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
                                              <div class="form-check">
                                                <input
                                                  class="form-check-input"
                                                  type="checkbox"
                                                  value=""
                                                  id="disabledCheck2"
                                                  disabled
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
                                <div class="pt-3 text-left">
                                  <div class="row">
                                    <div class="col-4">
                                      <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalCenter"><i class="bx bx-plus"></i> Add new author</button>
                                    </div>
                                    <div class="col-8 text-danger" style="text-align: right; font-size: 0.8em; " class="">** You can change the presenter after accepted.</div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="d-block d-sm-none">

                            </div>

                            <div class="form-group col-12 pt-3">
                              <label for="">Upload abstract file : <span class="text-danger">* accept only word file (.doc, .docx)</span></label>
                              <form action="#" class="dropzone dropzone-area dropzone-previews" id="dpz-single-file" style="padding-top: 30px;">
                                  <div class="dz-message" style="margin-bottom: 0px; margin-top: 0px;">Click or drag file to upload (or replace file) here<br><span class="text-danger" style="font-size: 0.8em;">accept only .doc or .docx file</span></div>
                              </form>
                              <div class="row">
                                <div class="form-group col-12" id="btnDeleteFileDiv_prev">
                                      <input type="text" class="form-control" id="txtFilename" readonly disabled value="<?php if(($abstract) && ($abstract['abstract_recent_file'] != '') && ($abstract['abstract_recent_file'] != null)){ 
                                        $strSQL = "SELECT upload_file_name FROM sx4_upload_file WHERE upload_url = '".$abstract['abstract_recent_file']."' AND upload_ref = '$sid'";
                                        $resFile = $db->fetch($strSQL, false, false);
                                        if($resFile){ echo $resFile['upload_file_name']; }
                                         } ?>">
                                </div>
                                <div class="col-1 <?php if(($abstract) && ($abstract['abstract_recent_file'] != '') && ($abstract['abstract_recent_file'] != null)){ }else{ echo "dn"; } ?> dn" style="text-align: right;" id="btnDeleteFileDiv">
                                  <div class="row mt-0">
                                    <div class="d-grid col-lg-12 mx-auto">
                                    <button class="btn text-danger btn-lg" onclick="submission.delete_upload()"><i class="bx bx-trash"></i></button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="form-group pt-4 text-center">
                                <button type="button" class="btn btn-label-secondary btn-lg" onclick="submission.save_draft_btn()">Save draft</button> &nbsp;
                                <button type="button" class="btn btn-danger btn-lg" onclick="submission.send()">Save and back</button>
                                <button type="button" class="btn btn-danger btn-lg" onclick="submission.send()">Submit and send</button>
                            </div>
                          </div>

                    </div>
                  </div>
                </div>
              </div>

              <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header bg-dark">
                      <h5 class="text-white" id="modalCenterTitle">Add co-author / Corresponding author</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form onsubmit="submission.save_co(); return false;">
                      <div class="modal-body">
                        <div class="row">
                          <div class="form-group col-4 mb-3">
                            <label for="txtCoTitle" class="form-label">Academic title :</label>
                            <input type="text" id="txtCoTitle" class="form-control" placeholder="Enter title" />
                          </div>
                          <div class="form-group col-8 mb-3">
                            <label for="txtCoFullname" class="form-label">Fullname : <span class="text-danger">*</span></label>
                            <input
                              type="text"
                              id="txtCoFullname"
                              class="form-control"
                              placeholder="Enter fitst name and surname" required
                            />
                          </div>
                        </div>

                        <div class="form-group mb-3">
                          <label for="txtCoEmail" class="form-label">Email : <span class="text-danger">*</span></label>
                          <input type="email" id="txtCoEmail" class="form-control" placeholder="xxxx@xxx.xx" required />
                        </div>

                        <div class="form-group  mb-3">
                          <label for="txtCoInstitution" class="form-label">Affaciliation : <span class="text-danger">*</span></label>
                          <input type="text" id="txtCoInstitution" class="form-control" placeholder="University of xxxx" required />
                        </div>

                        <div class="form-group  mb-3">
                          <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="txtCoRespond" value="1" />
                              <label class="form-check-label" for="defaultCheck3"> Co-reponding author ? </label>
                            </div>
                        </div>

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                          Close
                        </button>
                        <button type="submit" class="btn btn-primary">Save</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              <div class="modal fade" id="modalUpdateCo" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header bg-dark">
                      <h5 class="text-white" id="modalCenterTitle">Update co-author / Corresponding author</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form onsubmit="submission.update_co(); return false;">
                      <div class="modal-body">
                        <div class="row">
                          <div class="form-group col-12 mb-3" style="display: none; ">
                            <label for="txtCoTitle" class="form-label">Co-author ID :</label>
                            <input type="text" id="txtCoUpdateId" readonly disable class="form-control" />
                          </div>
                          <div class="form-group col-4 mb-3">
                            <label for="txtCoTitle" class="form-label">Academic title :</label>
                            <input type="text" id="txtCoUpdateTitle" class="form-control" placeholder="Enter title" />
                          </div>
                          <div class="form-group col-8 mb-3">
                            <label for="txtCoUpdateFullname" class="form-label">Fullname : <span class="text-danger">*</span></label>
                            <input
                              type="text"
                              id="txtCoUpdateFullname"
                              class="form-control"
                              placeholder="Enter fitst name and surname" required
                            />
                          </div>
                        </div>

                        <div class="form-group mb-3">
                          <label for="txtCoUpdateEmail" class="form-label">Email : <span class="text-danger">*</span></label>
                          <input type="email" id="txtCoUpdateEmail" class="form-control" placeholder="xxxx@xxx.xx" required />
                        </div>

                        <div class="form-group  mb-3">
                          <label for="txtCoUpdateInstitution" class="form-label">Affaciliation : <span class="text-danger">*</span></label>
                          <input type="text" id="txtCoUpdateInstitution" class="form-control" placeholder="University of xxxx" required />
                        </div>

                        <div class="form-group  mb-3">
                          <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="txtCoUpdateRespond" value="1" />
                              <label class="form-check-label" for="defaultCheck3"> Corresponding author ? </label>
                            </div>
                        </div>

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                          Close
                        </button>
                        <button type="submit" class="btn btn-primary">Save</button>
                      </div>
                    </form>
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
          setTimeout(() => {
            $('#email').focus()
          }, 300);


          if($('#txtFilename').val() != ''){
            $('#btnDeleteFileDiv_prev').removeClass('col-12')
            $('#btnDeleteFileDiv_prev').addClass('col-11')
          }
      })

      $(function(){
        
      })

      Dropzone.autoDiscover = false;

      // console.log($('#txtUid').val());

      var dropzone_5 = new Dropzone("#dpz-single-file", {
        url: api + 'AHR2023/api/php/upload_abstract.php?uid=' + $('#txtUid').val() + '&token=' + $('#txtToken').val() + '&sid=' + $("#txtSid").val(),
        acceptedFiles: '.doc,.docx',
        previewsContainer: ".dropzone-previews",
        maxFiles: 1,
        maxFilesize: 100,
        init: function(){
            this.on("complete", function(file) {
            // console.log(file);
              if(file.xhr.responseText == "Success"){
                this.removeFile(file);
                  preload.show()
                  $('#txtFilename').val(file.name)

                  $('#btnDeleteFileDiv_prev').removeClass('col-12')
                  $('#btnDeleteFileDiv_prev').addClass('col-11')

                  $('#btnDeleteFileDiv').removeClass('dn')
                  
                  setTimeout(function(){
                    Swal.fire({
                              icon: "success",
                              title: 'Upload success',
                              text: 'You can replace new file by upload file again.',
                              confirmButtonClass: 'btn btn-danger',
                    })
                    preload.hide()
                  }, 3000)
              }else if(file.xhr.responseText == 'Fail x1001'){
                preload.hide()
                this.removeFile(file);
                Swal.fire({
                          icon: "error",
                          title: 'Error',
                          text: 'Please enter you abstract title.',
                          confirmButtonClass: 'btn btn-danger',
                })
                $('#txtFilename').val('')
              }else{
                this.removeFile(file);
                Swal.fire({
                          icon: "error",
                          title: 'Error',
                          text: 'Can not upload file.',
                          confirmButtonClass: 'btn btn-danger',
                })
                $('#txtFilename').val('')
              }
            });
        }
      });
    </script>
    <!-- Page JS -->
  </body>
</html>
