<?php 
require('../config/php/config.conf.php');
require('../config/php/database.php'); 
require('../config/php/function.php'); 
require('../config/php/user.php'); 

$page_name = basename(__FILE__) ;

if(!(isset($_REQUEST['uid']))){
  $db->close();
  header('Location: ./');
  die();
}

$reviewer_uid = mysqli_real_escape_string($conn, $_REQUEST['uid']);

$strSQL = "SELECT * FROM sx4_account a INNER JOIN sx4_country b ON a.country = b.CountryID 
                                     WHERE 
                                     active_status = 'Y' 
                                     AND allow_status = 'Y' 
                                     AND delete_status = 'N'
                                     AND role_reviewer = 'Y'
                                     AND uid = '$reviewer_uid'";
$resReviewer = $db->fetch($strSQL, false, false);
if(!$resReviewer){
  $db->close();
  header('Location: ./');
  die();
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

    <title>Send invitation to reviewer</title>

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
                      <li class="breadcrumb-item">
                        <a href="./app-reviewer">Reviewer</a>
                      </li>
                      <li class="breadcrumb-item active">Send invitation</li>
                    </ol>
                  </nav>
                  <!-- Basic Breadcrumb -->
                </div>

                <div class="col-12 d-block d-sm-none">
                  <h1>AHR2023</h1>
                  <h2 class="mb-3">Reviewer</h2>
                </div>

                <div class="col-12">
                  <div class="card mb-5">
                    <div class="card-header bg-dark">
                      <h5 class="text-white mb-0">Send invitation form</h5>
                    </div>
                    <div class="card-body pt-3">
                      <div class="row">
                        <div class="form-group mb-3 col-6 dn-">
                          <label for="">UID : </label>
                          <input type="text" class="form-control" id="txtReviewerUid" value="<?php echo $reviewer_uid ;?>" readonly>
                        </div>
                        <div class="form-group mb-3 col-6">
                          <label for="">Full name : </label>
                          <input type="text" class="form-control" id="txtReviewerFullname" value="<?php echo $resReviewer['title']. $resReviewer['fname'] . " " . $resReviewer['lname'];?>">
                        </div>
                        <div class="form-group mb-3 col-6">
                        <label for="">E-mail : </label>
                          <input type="email" class="form-control" id="txtReviewerEmail" value="<?php echo $resReviewer['email'];?>">
                        </div>
                        <div class="form-group mb-3 col-12">
                          <label for="">Title : </label>
                          <input type="text" class="form-control" id="txtEmailTitle" value='Invitation to be an abstract reviewer for the International Hybrid Conference The 17th Postgraduate Forum of Health Systems and Policies: Post-Covid Health Equity'>
                        </div>
                      </div> 
                      <!-- . row  -->
                      
                      <div class="mb-3">
                          <label for="">Content : </label>
                          <div id="full-editor">
                              <p>
                                <h3>Subject : Invitation to be an abstract reviewer for the International Hybrid Conference <strong>The 17th Postgraduate Forum of Health Systems and Policies: Post-Covid Health Equity</strong></h3>
                              </p>
                              <p>
                              Dear <strong><?php echo $resReviewer['title']. $resReviewer['fname'] . " " . $resReviewer['lname'];?></strong>
                              </p>
                              <p>
                              On behalf of the Department of Epidemiology, Faculty of Medicine, Prince of Songkla University, I am delighted to inform you that we will be hosting the <strong>International Hybrid Conference : The 17th Postgraduate Forum of Health Systems and Policies: Post-Covid Health Equity</strong> during 17-18 July 2023 at Faculty of Medicine, Prince of Songkla University. At this event, the postgraduate students will be offered chances to share and present their research and work. In addition, the conference aims to strengthen overall systems and facilitate achieving global health targets of the SDGs, the effective network and collaboration across multi-stakeholders.
                              </p>
                              <p>
                              To maintain the quality of presentation, we would like to invite you to be an abstract reviewer for the oral and poster presentation which approximately 6 abstracts from candidate will be sent to you for reviewing in April 2023. Please click a button below to choose your decision.
                              </p>
                          </div>
                      </div>

                      <div class="form-group col-12 pt-3">
                        <label for="">Upload Invitation letter : <span class="text-danger">* accept only word file (.doc, .docx)</span></label>
                        <form action="#" class="dropzone dropzone-area dropzone-previews" id="dpz-single-file" style="padding-top: 30px;">
                            <div class="dz-message" style="margin-bottom: 0px; margin-top: 0px;">Click or drag file to upload (or replace file) here<br><span class="text-danger" style="font-size: 0.8em;">accept only .doc or .docx file</span></div>
                        </form>
                        <div class="row">
                          <div class="form-group col-12" id="btnDeleteFileDiv_prev">
                                <input type="text" class="form-control" id="txtFilename" readonly disabled value="<?php echo $resReviewer['invitation_letter_url'];?>">
                          </div>
                          <div class="col-1 <?php if(($resReviewer) && ($resReviewer['invitation_letter_url'] != '') && ($resReviewer['invitation_letter_url'] != null)){ }else{ echo "dn"; } ?> dn" style="text-align: right;" id="btnDeleteFileDiv">
                            <div class="row mt-0">
                              <div class="d-grid col-lg-12 mx-auto">
                              <button class="btn text-danger btn-lg" onclick="submission.delete_upload()"><i class="bx bx-trash"></i></button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="form-group bg-3 pt-4 col-12" style="text-align: right;">
                          <button class="btn btn-danger" type="button" onclick="user.send_invitation()">Send</button>
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

      Dropzone.autoDiscover = false;

      // console.log($('#txtUid').val());

      var dropzone_5 = new Dropzone("#dpz-single-file", {
        url: api + 'AHR2023/api/php/upload_invitation.php?uid=' + $('#txtUid').val() + '&token=' + $('#txtToken').val() + '&reviewer_uid=' + $("#txtReviewerUid").val(),
        acceptedFiles: '.pdf',
        previewsContainer: ".dropzone-previews",
        maxFiles: 1,
        maxFilesize: 100,
        init: function(){
            this.on("complete", function(file) {
            console.log(file);
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
