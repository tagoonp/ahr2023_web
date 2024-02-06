<!-- Modal -->
<div class="modal fade" id="modalInvitation" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white pb-3" id="modalCenterTitle">Send invitation</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-sm-6 mb-3">
                    <label for="nameWithTitle" class="form-label">Name</label>
                    <input
                        type="text"
                        id="txtReviewerFullname"
                        class="form-control"
                        placeholder="Enter Name"
                        readonly
                    />
                    </div>

                    <div class="col-12 col-sm-6 mb-3">
                    <label for="emailWithTitle" class="form-label">Email</label>
                    <input
                        type="text"
                        id="txtReviewerInviteEmail"
                        class="form-control"
                        placeholder="xxxx@xxx.xx"
                        readonly
                    />
                    </div>

                    <div class="col-12 mb-3">
                        <label for="emailWithTitle" class="form-label">Title : </label>
                        <input type="text" id="txtReviewerInviteEmail" class="form-control" placeholder="xxxx@xxx.xx" value="PostgraduateForum 2023 Reviewer Invitation Letter"/>
                    </div>

                </div>
                <div class="row g-2">
                    
                    <div class="col-12 mb-0">
                        <label for="dobWithTitle" class="form-label">Invitation message : </label>
                        <!-- <textarea name="txtReviewerInvitation" id="txtReviewerInvitation" cols="30" rows="10" class="form-control"></textarea> -->

                        <div id="full-editor">
                            <h6>Quill Rich Text Editor</h6>
                            <p>
                            Cupcake ipsum dolor sit amet. Halvah cheesecake chocolate bar gummi bears cupcake. Pie
                            macaroon bear claw. Soufflé I love candy canes I love cotton candy I love.
                            </p>
                            <p>
                                <button class="btn btn-primary" style="background: red;">Accept</button>
                            </p>
                        </div>

                    </div>

                    <div class="col-12">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="button" class="btn btn-danger"><i class="bx bx-paper-plane"></i> Save changes</button>
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalAddReviewer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white pb-3" id="modalCenterTitle">Add reviewer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
            </div>
            <div class="modal-body">
                
                <form onsubmit="staff.add_reviewer(); return false;">
                    <div class="row">
                        <div class="col-12 col-sm-4 mb-3">
                            <label for="nameWithTitle" class="form-label">Title / Academic title : </label>
                            <input type="text" id="txtReviewerTitle" class="form-control" placeholder="Enter title"  />
                        </div>
                        <div class="col-12 col-sm-4 mb-3">
                            <label for="nameWithTitle" class="form-label">First name : <span class="text-danger">*</span></label>
                            <input type="text" id="txtReviewerFname" class="form-control" placeholder="Enter Name" required />
                        </div>

                        <div class="col-12 col-sm-4 mb-3">
                            <label for="nameWithTitle" class="form-label">Surname : <span class="text-danger">*</span></label>
                            <input type="text" id="txtReviewerLname" class="form-control" placeholder="Enter Surname" required />
                        </div>

                        <div class="col-12 col-sm-4 mb-3">
                            <label for="emailWithTitle" class="form-label">Country : <span class="text-danger">*</span></label>
                            <select id="txtReviewerCountry" class="form-select" required>
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

                        <div class="col-12 col-sm-8 mb-3">
                            <label for="emailWithTitle" class="form-label">Email : <span class="text-danger">*</span></label>
                            <input type="text" id="txtReviewerEmail" class="form-control" placeholder="xxxx@xxx.xx" require />
                        </div>

                        <div class="col-12 mb-3">
                            <label for="emailWithTitle" class="form-label">Institution : <span class="text-danger">*</span></label>
                            <input type="text" id="txtReviewerInstitution" class="form-control" placeholder="University name / Institution" require />
                        </div>

                        <div class="col-12 mb-3">
                            <label for="emailWithTitle" class="form-label">Address : </label>
                            <textarea name="txtReviewerAddress" class="form-control" id="txtReviewerAddress" cols="30" rows="3"></textarea>
                        </div>

                    </div>
                    <div class="row g-2">
                        <div class="col-12" style="text-align: right;">
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-danger">Save</button>
                        </div>
                    </div>
                </form>

            </div>
            
        </div>
    </div>
</div>

<!-- modalStaffAction -->
<div class="modal fade" id="modalStaffAction" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white pb-3" id="modalCenterTitle">Staff action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-8 pt-2">
                            <h4 class="text-dark">Staff responding</h4>
                            </div>
                            <div class="col-4">
                                <div class="form-group pt-3" style="text-align: right;">
                                    <button class="btn btn-danger btn-lg" type="button" onclick="staff.send_review_invitation()">Save update status</button>
                                </div>
                            </div>
                        </div>
                        
                        <form onsubmit="return false;" class="reviewEmailForm">
                            <div class="row">
                                <div class="col-12 dn">
                                    <div class="form-group">
                                        <label for="">UID : </label>
                                        <input type="text" class="form-control" id="txtRevieweruid">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="">Response type : <span class="text-danger">*</span> </label>
                                        <select name="txtResponseType" id="txtResponseType" class="form-control">
                                            <option value="">-- Select --</option>
                                            <option value="wait for update">Send back to author for update</option>
                                            <option value="wait for reviewer review">Set to review process</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div id="responseBack" class="dn">
                                        <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="">Author name : </label>
                                                <input type="text" class="form-control" id="txtRevieweremail" value="<?php echo $currentUser['title'] . $currentUser['fname'] . " " . $currentUser['lname']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label for="">E-mail address : </label>
                                                <input type="email" class="form-control" id="txtRevieweremail" value="<?php echo $currentUser['email']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group pt-3">
                                                <label for="">Title : </label>
                                                <input type="text" class="form-control" id="txtRevieweretitle" value="[PGG2023] Response for author update.">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group pt-3">
                                                <label for="">E-mail content : </label>
                                                <!-- <textarea name="txtreviewlettercontent" id="txtreviewlettercontent" cols="30" rows="10" class="form-control"></textarea> -->
                                                <div>
                                                    <div id="full-editor-2">
                                                        <p>
                                                            <h6>PGF2023 number : <?php if($resAbstract){ echo $resAbstract['abstract_ref_id']; }; ?></h6>
                                                            <h5>Title : <?php if($resAbstract){ echo $resAbstract['abstract_title']; } ?></h5>
                                                        </p>
                                                        <p>
                                                        Dear <?php echo $currentUser['title'] . $currentUser['fname'] . " " . $currentUser['lname']; ?>
                                                        </p>
                                                        <p>
                                                            Your abstract has been evaluated by our reviewers, please see the results of process below.
                                                        </p>
                                                        <p>
                                                        --------------- Write your message here ------------------
                                                        </p>

                                                        <p>
                                                        Best regards,<br>
                                                        PGF2023 organization team.<br>
                                                        Contact us via email : saina.seeyong@gmail.com
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modalSelectReviewer -->
<div class="modal fade" id="modalSelectReviewer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable modal-fullscreen" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white pb-3" id="modalCenterTitle">Select reviewer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-5">
                        <h5 class="text-dark">Reviewer list</h5>
                        <div style="padding: 0px 20px 0px 0px; border: solid; border-width: 0px 1px 0px 0px; border-color: #ccc;">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>Reviewer name</th>
                                        <th width="80"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                $strSQL = "SELECT * FROM sx4_account a INNER JOIN sx4_country b ON a.country = b.CountryID 
                                            WHERE 
                                            active_status = 'Y' 
                                            AND allow_status = 'Y' 
                                            AND delete_status = 'N'
                                            AND role_reviewer = 'Y'
                                            AND reviewer_acception = 'Y'";
                                $res = $db->fetch($strSQL, true, true);
                                if(($res) && ($res['status'])){
                                    foreach ($res['data'] as $row) {
                                    ?>
                                    <tr>
                                        <td style="vertical-align: top; ">
                                            <?php 
                                            echo $row['title'] . $row['fname'] . " " . $row['lname'];
                                            ?>
                                            <div style="font-size: 0.8em;">
                                            <?php 
                                            echo $row['institution'];
                                            ?>
                                            </div>
                                            <div class="pt-2">
                                                <div class="text-dark"><small>Speciality : </small></div>
                                                <?php if($row['specialize'] == null){ echo "-"; }else{ echo $row['specialize'];}?>
                                            </div>
                                        </td>
                                        <td style="vertical-align: top; text-align: right;">
                                            <div class="pt-1">
                                                <button class="btn btn-icon btn-primary btn-sm" onclick="staff.setReviewContent('<?php echo $row['uid']; ?>', '<?php echo $row['title']; ?>', '<?php echo $row['fname']; ?>', '<?php echo $row['lname']; ?>', '<?php echo $row['email']; ?>')"><i class="bx bx-plus"></i></button> 
                                            </div>
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
                    <div class="col-7">
                        <h4 class="text-dark">Review letter form</h4>
                        <form onsubmit="return false;" class="reviewEmailForm">
                            <div class="row">
                                <div class="col-12 dn">
                                    <div class="form-group">
                                        <label for="">UID : </label>
                                        <input type="text" class="form-control" id="txtRevieweruid">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Reviewer full name : </label>
                                        <input type="text" class="form-control" id="txtReviewername">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">E-mail address : </label>
                                        <input type="text" class="form-control" id="txtRevieweremail">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group pt-3">
                                        <label for="">Title : </label>
                                        <input type="text" class="form-control" id="txtRevieweretitle">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group pt-3">
                                        <label for="">E-mail content : </label>
                                        <!-- <textarea name="txtreviewlettercontent" id="txtreviewlettercontent" cols="30" rows="10" class="form-control"></textarea> -->
                                        <div style="padding: 10px; border: dashed; border-width: 1px 1px 1px 1px; border-color: #ccc;">
                                            <div id="full-editor">
                                                <p>
                                                    <h6>PGF2023 number : <?php echo $resAbstract['abstract_ref_id']; ?></h6>
                                                    <h5>Title : <?php echo $resAbstract['abstract_title']; ?></h5>
                                                </p>
                                                <p>
                                                Dear <strong id="reviewerFullname">................</strong>
                                                </p>
                                                <p>
                                                    In July 2023, Department of Epidemiology Faculty of Medicine, Prince of Songkla University, Thailand will organize the international conference "PGF2023", I would like to invite you to review the entitle "<?php echo $resAbstract['abstract_title']; ?>"
                                                </p>
                                                <p>
                                                Please click a button below to choose your decision.
                                                </p>
                                            </div>

                                            <div class="btn btn-success btn-lg" type="button">Start review</div> <div class="btn btn-danger btn-lg" type="button">Decline</div>

                                            <div class="pt-4">
                                                <p>
                                                Since timely reviews are of utmost importance to authors, I would appreciate receiving your review within April 30, 2023. I hope you will be able to review this.<br>Thank you in advance for your contribution and time.
                                                </p>
                                                <p>
                                                Best regards,<br>
                                                PGF2023 organization team.<br>
                                                Contact us via email : saina.seeyong@gmail.com
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group pt-3" style="text-align: right;">
                                        <button class="btn btn-danger btn-lg" type="button" onclick="staff.send_review_invitation()">Add and send letter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</div>