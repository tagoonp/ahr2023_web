var authen = {
    login(){

        if(($('#email').val() == '') || ($('#password').val() == '')){
            if($('#email').val() == ''){ $('#email').addClass('is-invalid') }
            if($('#password').val() == ''){ $('#password').addClass('is-invalid') }
            return ;

        }

        var param = {
            username: $('#email').val(),
            password: $('#password').val()
        }

        preload.show()

        $url = api + 'pgf2023/api/php/authen?stage=login';

        var jxr = $.post($url , param, function(){ }, 'json')
                   .always(function(snap){ 
                        console.log(snap);
                        preload.show()
                        if(snap.status == 'Success'){
                            window.location = '../core/'
                        }else{ 
                            preload.hide()
                            Swal.fire({
                                icon: "error",
                                title: 'Error',
                                text: 'Invalid useraccount or password.',
                                confirmButtonClass: 'btn btn-danger',
                                confirmButtonText: "Try again"
                            })
                            return ;
                        }
                    })
    },
    update(){

        $check = 0
        $('.form-control').removeClass('is-invalid')

        if($('#txtFname').val() == ''){ $check++; $('#txtFname').addClass('is-invalid')}
        if($('#txtLname').val() == ''){ $check++; $('#txtLname').addClass('is-invalid')}
        if($('#txtInstitution').val() == ''){ $check++; $('#txtInstitution').addClass('is-invalid')}
        if($('#txtAddress').val() == ''){ $check++; $('#txtAddress').addClass('is-invalid')}
        if($('#txtCountry').val() == ''){ $check++; $('#txtCountry').addClass('is-invalid')}
        if($('#txtGender').val() == ''){ $check++; $('#txtGender').addClass('is-invalid')}

        if($check!=0){
            return ;
        }

        var param = {
            uid: $("#txtUid").val(),
            token: $("#txtToken").val(),
            title: $('#txtTitle').val(),
            fname: $("#txtFname").val(),
            lname: $("#txtLname").val(),
            inst: $("#txtInstitution").val(),
            address: $('#txtAddress').val(),
            country: $('#txtCountry').val(),
            gender: $('#txtGender').val()
        }

        console.log(param);

        preload.show()

        $url = api + 'pgf2023/api/php/authen?stage=update';

        var jxr = $.post($url , param, function(){ }, 'json')
                   .always(function(snap){ 
                        console.log(snap);
                        if(snap.status == 'Success'){
                           setTimeout(() => {
                            preload.hide()
                            Swal.fire({
                                title: 'Success',
                                text: "Your information update.",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Reload',
                                cancelButtonText: 'Cancel',
                                confirmButtonClass: 'btn btn-danger mr-1',
                                cancelButtonClass: 'btn btn-secondary',
                                buttonsStyling: false,
                            }).then(function (result) {
                                if (result.value) {
                                    window.location.reload()
                                }
                            })
                           }, 3000);
                        }else{ 
                            preload.hide()
                            Swal.fire({
                                icon: "error",
                                title: 'Error',
                                text: 'Can not update your information.',
                                confirmButtonClass: 'btn btn-danger',
                                confirmButtonText: "Re-try"
                            })
                            return ;
                        }
                    })
    },
    update_password(){
        $check = 0
        $('.form-control').removeClass('is-invalid')
        if($('#password1').val() == ''){ $check++; $('#password1').addClass('is-invalid')}
        if($('#password2').val() == ''){ $check++; $('#password2').addClass('is-invalid')}
        
        if($check!=0){
            return ;
        }

        if($('#password1').val() != $('#password2').val()){ $check++; $('#password2').addClass('is-invalid')}

        if($check!=0){
            Swal.fire({
                icon: "error",
                title: 'Error',
                text: 'Password not match',
                confirmButtonClass: 'btn btn-danger',
                confirmButtonText: "OK"
            })
            return ;
        }

        var param = {
            uid: $('#txtUid').val(),
            password: $("#password1").val()
        }

        preload.show()

        $url = api + 'pgf2023/api/php/authen?stage=reset_password';

        var jxr = $.post($url , param, function(){ }, 'json')
                   .always(function(snap){ 
                        console.log(snap);
                        if(snap.status == 'Success'){
                            setTimeout(() => {
                                preload.hide()
                                Swal.fire({
                                    title: 'Success',
                                    text: "Update password success.",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Back to login',
                                    confirmButtonClass: 'btn btn-danger mr-1',
                                    cancelButtonClass: 'btn btn-secondary',
                                    buttonsStyling: false,
                                }).then(function (result) {
                                    if (result.value) {
                                        window.location = './'
                                    }
                                })
                            }, 500);
                        }else{
                            preload.hide()
                            Swal.fire({
                                icon: "error",
                                title: 'Error',
                                text: 'Can not reset password, try again or contact our staff.',
                                confirmButtonClass: 'btn btn-danger',
                                confirmButtonText: "OK"
                            })
                        }
                   })
    },
    send_reset_password_link(){
        $check = 0
        $('.form-control').removeClass('is-invalid')
        if($('#email').val() == ''){ $check++; $('#email').addClass('is-invalid')}
        if($check != 0){
            Swal.fire({
                icon: "error",
                title: 'Error',
                text: 'Please enter your e-amil address.',
                confirmButtonClass: 'btn btn-danger',
                confirmButtonText: "OK"
            })
            return ;
        }

        var param = {
            email: $('#email').val()
        }

        preload.show()

        $url = api + 'pgf2023/api/php/authen?stage=send_reset_password';

        var jxr = $.post($url , param, function(){ }, 'json')
                   .always(function(snap){ 
                        console.log(snap);
                        if(snap.status == 'Success'){
                            window.location = 'link-success'
                        }else{
                            preload.hide()
                            if(snap.error_message == 'Email not found'){
                                Swal.fire({
                                    icon: "error",
                                    title: 'Error',
                                    text: 'E-mail address not found.',
                                    confirmButtonClass: 'btn btn-danger',
                                    confirmButtonText: "Try again"
                                })
                                return ;
                            }else{
                                Swal.fire({
                                    icon: "error",
                                    title: 'Error',
                                    text: 'Can not send reset password link, try again or contact our staff.',
                                    confirmButtonClass: 'btn btn-danger',
                                    confirmButtonText: "Try again"
                                })
                                return ;
                            }
                        }
                   })
    },
    register(){
        $check = 0
        $('.form-control').removeClass('is-invalid')
        if($('#multiStepsEmail').val() == ''){ $check++; $('#multiStepsEmail').addClass('is-invalid')}
        if($('#multiStepsPass').val() == ''){ $check++; $('#multiStepsPass').addClass('is-invalid')}
        if($('#multiStepsFirstName').val() == ''){ $check++; $('#multiStepsFirstName').addClass('is-invalid')}
        if($('#multiStepsLastName').val() == ''){ $check++; $('#multiStepsLastName').addClass('is-invalid')}
        if($('#multiStepsUniversity').val() == ''){ $check++; $('#multiStepsUniversity').addClass('is-invalid')}
        if($('#multiStepsAddress').val() == ''){ $check++; $('#multiStepsAddress').addClass('is-invalid')}
        if($('#multiStepsState').val() == ''){ $check++; $('#multiStepsState').addClass('is-invalid')}
        if($('#multiVisit').val() == ''){ $check++; $('#multiVisit').addClass('is-invalid')}
        if($('#multiPaticipant').val() == ''){ $check++; $('#multiPaticipant').addClass('is-invalid')}
        if($('#multiGender').val() == ''){ $check++; $('#multiGender').addClass('is-invalid')}

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

        $ahr = 'N';
        $trip = 'N';

        if ($('#defaultCheck3_1').is(':checked')){ $trip = 'Y' }
        if ($('#defaultCheck3_2').is(':checked')){ $ahr = 'Y' }

        var param = {
            email: $('#multiStepsEmail').val(),
            password: $('#multiStepsPass').val(),
            fname: $('#multiStepsFirstName').val(),
            lname: $('#multiStepsLastName').val(),
            university: $('#multiStepsUniversity').val(),
            address: $('#multiStepsAddress').val(),
            country: $('#multiStepsState').val(),
            vtype: $('#multiVisit').val(),
            ptype: $('#multiPaticipant').val(),
            gender: $('#multiGender').val(),
            title:  $('#multiStepsTitle').val(),
            ahr: $ahr,
            trip: $trip
        }

        preload.show()

        $url = api + 'pgf2023/api/php/authen?stage=register';

        var jxr = $.post($url , param, function(){ }, 'json')
                   .always(function(snap){ 
                        console.log(snap);
                        preload.show()
                        if(snap.status == 'Success'){
                            window.location = 'reg-success'
                        }else{ 
                            preload.hide()
                            if(snap.error_message == 'Email already use.'){
                                Swal.fire({
                                    icon: "error",
                                    title: 'Error',
                                    text: 'This e-mail already use.',
                                    confirmButtonClass: 'btn btn-danger',
                                    confirmButtonText: "Re-try"
                                })
                            }else{
                                Swal.fire({
                                    icon: "error",
                                    title: 'Error',
                                    text: 'Can not register, please tery again or contact system admin.',
                                    confirmButtonClass: 'btn btn-danger',
                                    confirmButtonText: "Re-try"
                                })
                            }
                            
                            
                            return ;
                        }
                    })
    }
}