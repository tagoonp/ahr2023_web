var submission = {
    delete_submission(id){
        var param = {
            uid: $("#txtUid").val(),
            role: $("#txtRole").val(),
            token: $("#txtToken").val(),
            abs_id: id
        }

        Swal.fire({
            title: 'Are you sure?',
            text: "You will be can not recovery this record after delete.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            confirmButtonClass: 'btn btn-danger mr-1',
            cancelButtonClass: 'btn btn-secondary',
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
                preload.show()
                $url = api + 'pgf2023/api/php/submission?stage=delete_submission_by_staff';
                var jxr = $.post($url , param, function(){ }, 'json')
                        .always(function(snap){ 
                            if(snap.status == 'Success'){
                                window.location.reload()
                            }else{
                                Swal.fire({
                                    icon: "error",
                                    title: 'Warning',
                                    text: 'Can not save draft abstract.',
                                    confirmButtonClass: 'btn btn-danger',
                                    confirmButtonText: "OK"
                                })
                                return ;
                            }
                        })
            }
        })
    },
    save_draft_btn(){
        if($("#txtTitle").val() == ''){
            Swal.fire({
                icon: "error",
                title: 'Warning',
                text: 'Please enter the abstract title.',
                confirmButtonClass: 'btn btn-danger',
                confirmButtonText: "OK"
            })
            return ;
        }else{
            var param = {
                title: $("#txtTitle").val(),
                category: $("#txtCat").val(),
                typeofpresent: $("#txtType").val(),
                sid: $("#txtSid").val(),
                uid: $("#txtUid").val(),
                token: $("#txtToken").val()
            }

            $url = api + 'pgf2023/api/php/submission?stage=save_draft';

            var jxr = $.post($url , param, function(){ }, 'json')
                    .always(function(snap){ 
                        if(snap.status == 'Success'){
                            Swal.fire({
                                icon: "success",
                                title: 'Success',
                                text: 'Your abstract is saved.',
                                confirmButtonClass: 'btn btn-danger',
                                confirmButtonText: "OK"
                            })
                            return ;
                        }else{
                            Swal.fire({
                                icon: "error",
                                title: 'Warning',
                                text: 'Can not save draft abstract.',
                                confirmButtonClass: 'btn btn-danger',
                                confirmButtonText: "OK"
                            })
                            return ;
                        }
                    })
        }
    },
    save_draft(){
        if($("#txtTitle").val() != ''){
            var param = {
                title: $("#txtTitle").val(),
                category: $("#txtCat").val(),
                typeofpresent: $("#txtType").val(),
                sid: $("#txtSid").val(),
                uid: $("#txtUid").val(),
                token: $("#txtToken").val()
            }

            $url = api + 'pgf2023/api/php/submission?stage=save_draft';

            var jxr = $.post($url , param, function(){ }, 'json')
                    .always(function(snap){ 
                            console.log(snap);
                    })
        }
    },
    send(){
        $check = 0
        $('.form-control').removeClass('is-invalid')
        if($('#txtTitle').val() == ''){ $check++; $('#txtTitle').addClass('is-invalid')}
        if($('#txtCat').val() == ''){ $check++; $('#txtCat').addClass('is-invalid')}
        if($('#txtType').val() == ''){ $check++; $('#txtType').addClass('is-invalid')}

        if($check != 0){
            Swal.fire({
                icon: "error",
                title: 'Warning',
                text: 'Please enter all require field.',
                confirmButtonClass: 'btn btn-danger',
                confirmButtonText: "OK"
            })
            return ;
        }

        if($('#txtFilename').val() == ''){
            Swal.fire({
                icon: "error",
                title: 'Warning',
                text: 'Please upload your abstract file.',
                confirmButtonClass: 'btn btn-danger',
                confirmButtonText: "OK"
            })
            return ;
        }


        Swal.fire({
            title: 'Are you sure?',
            text: "Your abstract can not update after send to the committee.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel',
            confirmButtonClass: 'btn btn-danger mr-1',
            cancelButtonClass: 'btn btn-secondary',
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
                preload.show()
                var param = {
                    sid: $("#txtSid").val(),
                    uid: $("#txtUid").val(),
                    token: $("#txtToken").val()
                }
                var jxr = $.post(api + 'pgf2023/api/php/submission?stage=confirm_send' , param, function(){ }, 'json')
                        .always(function(snap){ 
                                console.log(snap);
                                if(snap.status == 'Success'){
                                    window.location = 'submission_sended?id=' + $('#txtSid').val()
                                }else{ 
                                    preload.hide()
                                    Swal.fire({
                                        icon: "error",
                                        title: 'Error',
                                        text: 'Can not send the submission. Please try again or contact our staff.',
                                        confirmButtonClass: 'btn btn-danger',
                                        confirmButtonText: "OK"
                                    })
                                    return ;
                                }
                            })
            }
        })


        if($('#txtTitle').val() == ''){ $check++; $('#txtTitle').addClass('is-invalid')}
    },
    set_co(id, title, fullname, email, inst, respon){
        $('#modalUpdateCo').modal('show')
        $('#txtCoUpdateId').val(id)
        $('#txtCoUpdateTitle').val(title)
        $('#txtCoUpdateFullname').val(fullname)
        $('#txtCoUpdateEmail').val(email)
        $('#txtCoUpdateInstitution').val(inst)

        if(respon == 'Y'){
            $('#txtCoUpdateRespond').prop('checked', 'checked')
        }else{
            $('#txtCoUpdateRespond').prop('checked', '')
        }
    },
    delete_upload(){
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete attached file?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel',
            confirmButtonClass: 'btn btn-danger mr-1',
            cancelButtonClass: 'btn btn-secondary',
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
                preload.show()
                var param = {
                    sid: $("#txtSid").val(),
                    uid: $("#txtUid").val(),
                    token: $("#txtToken").val()
                }
                var jxr = $.post(api + 'pgf2023/api/php/submission?stage=delete_uploaded_file' , param, function(){ }, 'json')
                        .always(function(snap){ 
                                console.log(snap);
                                if(snap.status == 'Success'){
                                    preload.hide()
                                    $('#txtFilename').val('')
                                    $('#btnDeleteFileDiv').addClass('dn')
                                    $('#btnDeleteFileDiv_prev').removeClass('col-11')
                                    $('#btnDeleteFileDiv_prev').addClass('col-12')
                                }else{ 
                                    preload.hide()
                                    Swal.fire({
                                        icon: "error",
                                        title: 'Error',
                                        text: 'Can not delete uploaded file.',
                                        confirmButtonClass: 'btn btn-danger',
                                        confirmButtonText: "Try again"
                                    })
                                    return ;
                                }
                            })
            }
        })
    },
    toggle_response(co_to, co_id, co_fullname){
        if(co_to == 'N'){
            Swal.fire({
                title: 'Are you sure?',
                text: "Un-set " + co_fullname + " as corresponding author?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel',
                confirmButtonClass: 'btn btn-danger mr-1',
                cancelButtonClass: 'btn btn-secondary',
                buttonsStyling: false,
            }).then(function (result) {
                if (result.value) {
                    preload.show()
                    var param = {
                        sid: $("#txtSid").val(),
                        uid: $("#txtUid").val(),
                        token: $("#txtToken").val(),
                        co_to: 'N',
                        co_id: co_id
                    }
                    var jxr = $.post(api + 'pgf2023/api/php/submission?stage=update_co_response' , param, function(){ }, 'json')
                            .always(function(snap){ 
                                    console.log(snap);
                                    if(snap.status == 'Success'){
                                        window.location.reload()
                                    }else{ 
                                        preload.hide()
                                        Swal.fire({
                                            icon: "error",
                                            title: 'Error',
                                            text: 'Can not update co-author.',
                                            confirmButtonClass: 'btn btn-danger',
                                            confirmButtonText: "Try again"
                                        })
                                        return ;
                                    }
                                })
                }else{
                    $('#disabledCheck_' + co_id).prop('checked', 'checked')
                }
            })
        }else{
            Swal.fire({
                title: 'Are you sure?',
                text: "Set " + co_fullname + " as responding author author?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel',
                confirmButtonClass: 'btn btn-danger mr-1',
                cancelButtonClass: 'btn btn-secondary',
                buttonsStyling: false,
            }).then(function (result) {
                if (result.value) {
                    // $('#disabledCheck_' + co_id).prop('checked', 'checked')
                    preload.show()
                    var param = {
                        sid: $("#txtSid").val(),
                        uid: $("#txtUid").val(),
                        token: $("#txtToken").val(),
                        co_to: 'Y',
                        co_id: co_id
                    }
                    var jxr = $.post(api + 'pgf2023/api/php/submission?stage=update_co_response' , param, function(){ }, 'json')
                            .always(function(snap){ 
                                    console.log(snap);
                                    if(snap.status == 'Success'){
                                        window.location.reload()
                                    }else{ 
                                        preload.hide()
                                        Swal.fire({
                                            icon: "error",
                                            title: 'Error',
                                            text: 'Can not update co-author.',
                                            confirmButtonClass: 'btn btn-danger',
                                            confirmButtonText: "Try again"
                                        })
                                        return ;
                                    }
                                })
                }else{
                    $('#disabledCheck_' + co_id).prop('checked', '')
                }
            })
        }
    },
    update_co(){
        if($('#txtCoUpdateId').val() == ''){
            Swal.fire({
                icon: "error",
                title: 'Error',
                text: 'Invalid co-author ID',
                confirmButtonClass: 'btn btn-danger',
                confirmButtonText: "OK"
            })
            return ;
        }

        $check = 0;
        $('.form-control').removeClass('is-invalid')
        if($('#txtCoUpdateFullname').val() == ''){ $check++ ; $('#txtCoUpdateFullname').addClass('is-invalid')}
        if($('#txtCoUpdateEmail').val() == ''){ $check++ ; $('#txtCoUpdateEmail').addClass('is-invalid')}
        if($('#txtCoUpdateInstitution').val() == ''){ $check++ ; $('#txtCoUpdateInstitution').addClass('is-invalid')}
        if($check != 0){
            return ;
        }

        $co = 'N';

        if ($('#txtCoUpdateRespond').is(':checked')) {
            $co = 'Y';
        }

        var param = {
            uid: $('#txtUid').val(),
            token: $('#txtToken').val(),
            sid: $("#txtSid").val(),
            co_id: $("#txtCoUpdateId").val(),
            title: $("#txtCoUpdateTitle").val(),
            fullname: $('#txtCoUpdateFullname').val(),
            email: $('#txtCoUpdateEmail').val(),
            inst: $('#txtCoUpdateInstitution').val(),
            cores: $co
        }

        preload.show()

        $url = api + 'pgf2023/api/php/submission?stage=update_co';

        var jxr = $.post($url , param, function(){ }, 'json')
                   .always(function(snap){ 
                        console.log(snap);
                        if(snap.status == 'Success'){
                            window.location.reload()
                        }else{ 
                            preload.hide()
                            Swal.fire({
                                icon: "error",
                                title: 'Error',
                                text: 'Can not update co-author.',
                                confirmButtonClass: 'btn btn-danger',
                                confirmButtonText: "Try again"
                            })
                            return ;
                        }
                    })
    },
    save_co(){
        $check = 0;
        $('.form-control').removeClass('is-invalid')
        if($('#txtCoFullname').val() == ''){ $check++ ; $('#txtCoFullname').addClass('is-invalid')}
        if($('#txtCoEmail').val() == ''){ $check++ ; $('#txtCoEmail').addClass('is-invalid')}
        if($('#txtCoInstitution').val() == ''){ $check++ ; $('#txtCoInstitution').addClass('is-invalid')}
        if($check != 0){
            return ;
        }

        $co = 'N';

        if ($('#txtCoRespond').is(':checked')) {
            $co = 'Y';
        }
        var param = {
            uid: $('#txtUid').val(),
            token: $('#txtToken').val(),
            sid: $("#txtSid").val(),
            title: $("#txtCoTitle").val(),
            fullname: $('#txtCoFullname').val(),
            email: $('#txtCoEmail').val(),
            inst: $('#txtCoInstitution').val(),
            cores: $co
        }

        preload.show()

        $url = api + 'pgf2023/api/php/submission?stage=save_co';

        var jxr = $.post($url , param, function(){ }, 'json')
                   .always(function(snap){ 
                        console.log(snap);
                        if(snap.status == 'Success'){
                            window.location.reload()
                        }else{ 
                            preload.hide()
                            Swal.fire({
                                icon: "error",
                                title: 'Error',
                                text: 'Can not add co-author.',
                                confirmButtonClass: 'btn btn-danger',
                                confirmButtonText: "Try again"
                            })
                            return ;
                        }
                    })
    },
    delete_abstract(id, code){
        Swal.fire({
            title: 'Are you sure?',
            text: "Delete abstract ID " + code + "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel',
            confirmButtonClass: 'btn btn-danger mr-1',
            cancelButtonClass: 'btn btn-secondary',
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
                preload.show()
                var param = {
                    uid: $('#txtUid').val(),
                    token: $('#txtToken').val(),
                    abstract_id: id
                }
        
                preload.show()

                console.log(param);
        
                $url = api + 'pgf2023/api/php/submission?stage=delete_abstract';
        
                var jxr = $.post($url , param, function(){ }, 'json')
                           .always(function(snap){ 
                                console.log(snap);
                                if(snap.status == 'Success'){
                                    window.location.reload()
                                }else{ 
                                    preload.hide()
                                    Swal.fire({
                                        icon: "error",
                                        title: 'Error',
                                        text: 'Can not delete abstract.',
                                        confirmButtonClass: 'btn btn-danger',
                                        confirmButtonText: "Try again"
                                    })
                                    return ;
                                }
                            })
            }
        })
    },
    delete_co(id, co_name){
        Swal.fire({
            title: 'Are you sure?',
            text: "Delete " + co_name + " from co-author list?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel',
            confirmButtonClass: 'btn btn-danger mr-1',
            cancelButtonClass: 'btn btn-secondary',
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
                preload.show()
                var param = {
                    uid: $('#txtUid').val(),
                    token: $('#txtToken').val(),
                    sid: $("#txtSid").val(),
                    co_id : id
                }
        
                preload.show()
        
                $url = api + 'pgf2023/api/php/submission?stage=delete_co';
        
                var jxr = $.post($url , param, function(){ }, 'json')
                           .always(function(snap){ 
                                console.log(snap);
                                if(snap.status == 'Success'){
                                    window.location.reload()
                                }else{ 
                                    preload.hide()
                                    Swal.fire({
                                        icon: "error",
                                        title: 'Error',
                                        text: 'Can not delete co-author.',
                                        confirmButtonClass: 'btn btn-danger',
                                        confirmButtonText: "Try again"
                                    })
                                    return ;
                                }
                            })
            }
        })
    }
}