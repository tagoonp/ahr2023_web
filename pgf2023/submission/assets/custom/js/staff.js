var staff = {
    updateReviewrInfo(){
        $check = 0;
        $('.form-control').removeClass('is-invalid')

        if($('#txtFname').val() == ''){ $check++; $('#txtFname').addClass('is-invalid')}
        if($('#txtLname').val() == ''){ $check++; $('#txtLname').addClass('is-invalid')}
        if($('#txtEmail').val() == ''){ $check++; $('#txtEmail').addClass('is-invalid')}
        if($('#txtGender').val() == ''){ $check++; $('#txtGender').addClass('is-invalid')}
        if($('#txtPrimaryRole').val() == ''){ $check++; $('#txtPrimaryRole').addClass('is-invalid')}
        if($('#txtInstitution').val() == ''){ $check++; $('#txtInstitution').addClass('is-invalid')}

        var param = {
            uid: $("#txtUid").val(),
            role: $("#txtRole").val(),
            token: $("#txtToken").val(),
            selected_id: $("#txtSelectedUid").val(),
            title: $("#txtTitle").val(),
            fname: $("#txtFname").val(),
            lname: $("#txtLname").val(),
            primary_role: $('#txtPrimaryRole').val(),
            gender: $("#txtGender").val(),
            email: $("#txtEmail").val(),
            institution: $("#txtInstitution").val(),
            address: $("#txtAddress").val(),
            specialize: $("#txtSpeciality").val()
        }

        console.log(param);

        preload.show()

        $url = api + 'pgf2023/api/php/staff?stage=update_reviewer_info';
                var jxr = $.post($url , param, function(){ }, 'json')
                        .always(function(snap){ 
                            console.log(snap);
                            if(snap.status == 'Success'){
                                setTimeout(() => {
                                    Swal.fire({
                                        icon: "success",
                                        title: 'Success',
                                        text: 'User info update.',
                                        confirmButtonClass: 'btn btn-success',
                                        confirmButtonText: "OK"
                                    })
                                    preload.hide();
                                }, 500);
                            }else{
                                Swal.fire({
                                    icon: "error",
                                    title: 'Error',
                                    text: 'Can not update info.',
                                    confirmButtonClass: 'btn btn-danger',
                                    confirmButtonText: "OK"
                                })
                                preload.hide();
                            }
                        })
    },
    togglePriviledge(id, par){
        let isChecked = $('#defaultCheck' + id).is(':checked');
        $nex = 'N';
        if(isChecked){
            $nex = 'Y';
        }
        var param = {
            uid: $("#txtUid").val(),
            role: $("#txtRole").val(),
            token: $("#txtToken").val(),
            selected_id: $("#txtSelectedUid").val(),
            target_param: par,
            target_status: $nex
        }
        $url = api + 'pgf2023/api/php/staff?stage=update_reviewer_privilledge';
        var jxr = $.post($url , param, function(){ }, 'json')
                   .always(function(snap){ console.log(snap); })
        
    },
    openModal(id, a, b){
        $('#' + id).modal('show')
    },
    setReviewContent(uid, title, fname, lname, email){
        $('#txtRevieweruid').val(uid)
        $('#txtReviewername').val(title + fname + ' ' + lname)
        $('#txtRevieweremail').val(email)
        $('#txtRevieweretitle').val('uid')
        $('#reviewerFullname').text(title + fname + ' ' + lname)
    },
    send_review_invitation(){
        $check = 0;
        $('.form-control').removeClass('is-invalid')
        if($("#txtRevieweruid").val() == ''){ $check++; $("#txtRevieweruid").addClass('is-invalid') }
        if($("#txtReviewername").val() == ''){ $check++; $("#txtReviewername").addClass('is-invalid') }
        if($("#txtRevieweremail").val() == ''){ $check++; $("#txtRevieweremail").addClass('is-invalid') }
        if($("#txtRevieweretitle").val() == ''){ $check++; $("#txtRevieweretitle").addClass('is-invalid') }
        if($check != 0){
            return ;
        }
        var param = {
            uid: $('#txtUid').val(),
            token: $("#txtToken").val(),
            target_uid: $('#txtRevieweruid').val(),
            email: $('#txtRevieweremail').val(),
            fullname: $('#txtReviewername').val(),
            title: $('#txtRevieweretitle').val(),
            content: $('.ql-editor').html()
        }
        console.log(param);
        // preload.show()
    },
    add_reviewer(){
        console.log('a');
        $check = 0;
        $('.form-control').removeClass('is-invalid')
        if($('#txtReviewerFname').val() == ''){ $check++ ; $('#txtReviewerFname').addClass('is-invalid')}
        if($('#txtReviewerLname').val() == ''){ $check++ ; $('#txtReviewerLname').addClass('is-invalid')}
        if($('#txtReviewerCountry').val() == ''){ $check++ ; $('#txtReviewerCountry').addClass('is-invalid')}
        if($('#txtReviewerEmail').val() == ''){ $check++ ; $('#txtReviewerEmail').addClass('is-invalid')}
        if($('#txtReviewerInstitution').val() == ''){ $check++ ; $('#txtReviewerInstitution').addClass('is-invalid')}

        var param = {
            uid: $("#txtUid").val(),
            role: $("#txtRole").val(),
            token: $("#txtToken").val(),
            title: $("#txtReviewerTitle").val(),
            fname: $("#txtReviewerFname").val(),
            lname: $("#txtReviewerLname").val(),
            country: $("#txtReviewerCountry").val(),
            email: $("#txtReviewerEmail").val(),
            institution: $("#txtReviewerInstitution").val(),
            address: $("#txtReviewerAddress").val()
        }

        if($check != 0){
            console.log(param);
            return ;
        }

        

        
        preload.show()

        $url = api + 'pgf2023/api/php/staff?stage=add_reviewer';
                var jxr = $.post($url , param, function(){ }, 'json')
                        .always(function(snap){ 
                            console.log(snap);
                            if(snap.status == 'Success'){
                                setTimeout(function(){
                                    preload.hide()
                                    Swal.fire({
                                        title: 'Success',
                                        text: "Click OK to reload data.",
                                        icon: 'success',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'OK',
                                        cancelButtonText: 'Cancel',
                                        confirmButtonClass: 'btn btn-danger mr-1',
                                        cancelButtonClass: 'btn btn-secondary',
                                        buttonsStyling: false,
                                    }).then(function (result) {
                                        if (result.value) {
                                            window.location.reload()
                                        }
                                    })
                                }, 2000)
                            }else if(snap.status == 'Duplicate'){
                                preload.hide()
                                Swal.fire({
                                    icon: "error",
                                    title: 'Error',
                                    text: 'E-mail already used, please check from participant list.',
                                    confirmButtonClass: 'btn btn-danger',
                                    confirmButtonText: "OK"
                                })
                                return ;
                            }else{
                                preload.hide()
                                Swal.fire({
                                    icon: "error",
                                    title: 'Warning',
                                    text: 'Can not add reviewer.',
                                    confirmButtonClass: 'btn btn-danger',
                                    confirmButtonText: "OK"
                                })
                                return ;
                            }
                        })
    }
}

$(function(){
    $('#txtResponseType').change(function(){
        if($('#txtResponseType').val() == 'wait for update'){
            $('#responseBack').removeClass('dn')
        }else{
            $('#responseBack').addClass('dn')
        }
    })
})