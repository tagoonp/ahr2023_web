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