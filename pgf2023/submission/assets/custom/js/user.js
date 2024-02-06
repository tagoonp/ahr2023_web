const fullToolbar = [
    [
      {
        font: []
      },
      {
        size: []
      }
    ],
    ['bold', 'italic', 'underline', 'strike'],
    [
      {
        color: []
      },
      {
        background: []
      }
    ],
    [
      {
        script: 'super'
      },
      {
        script: 'sub'
      }
    ],
    [
      {
        header: '1'
      },
      {
        header: '2'
      },
      'blockquote',
      'code-block'
    ],
    [
      {
        list: 'ordered'
      },
      {
        list: 'bullet'
      },
      {
        indent: '-1'
      },
      {
        indent: '+1'
      }
    ],
    [
      'direction',
      {
        align: []
      }
    ],
    ['link', 'image', 'video', 'formula'],
    ['clean']
  ];

var fullEditor
if ($('#full-editor').length) {
  console.log('a');
  fullEditor = new Quill('#full-editor', {
    bounds: '#full-editor',
    placeholder: 'Type Something...',
    modules: {
      formula: true,
      toolbar: fullToolbar
    },
    theme: 'snow'
  });
}

var fullEditor2
if ($('#full-editor-2').length) {
  console.log('a');
  fullEditor2 = new Quill('#full-editor-2', {
    bounds: '#full-editor-2',
    placeholder: 'Type Something...',
    modules: {
      formula: true,
      toolbar: fullToolbar
    },
    theme: 'snow'
  });
}
    
var user = {
    set_reviewer(){
        $('#txtXcode').removeClass('is-invalid')
        if($('#txtXcode').val() == ''){
            $('#txtXcode').addClass('is-invalid')
            return ;
        }
        var param = {
            uid: $('#txtUid').val(),
            token: $("#txtToken").val(),
            target_code: $('#txtXcode').val()
        }
        preload.show()
        var jxr = $.post(api + 'pgf2023/api/php/user?stage=set_reviewer' , param, function(){ }, 'json')
                   .always(function(snap){ 
                        console.log(snap);
                        if(snap.status == 'Success'){
                            window.location.reload()
                        }else{ 
                            preload.hide()
                            Swal.fire({
                                icon: "error",
                                title: 'Error',
                                text: 'User not found',
                                confirmButtonClass: 'btn btn-danger',
                                confirmButtonText: "Try again"
                            })
                            return ;
                        }
                    })
    },
    send_invitation(){

        // if($("#txtFilename").val() == ''){
        //   Swal.fire({
        //       icon: "error",
        //       title: 'Error',
        //       text: 'Please upload invitation letter.',
        //       confirmButtonClass: 'btn btn-danger',
        //       confirmButtonText: "OK"
        //   })
        //   return ;
        // }

        Swal.fire({
            title: 'Are you sure?',
            text: "Invitation e-mail will send immidiatly.",
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
                var param = {
                    uid: $('#txtUid').val(),
                    token: $("#txtToken").val(),
                    target_uid: $('#txtReviewerUid').val(),
                    email: $('#txtReviewerEmail').val(),
                    fullname: $('#txtReviewerFullname').val(),
                    title: $('#txtEmailTitle').val(),
                    content: $('.ql-editor').html()
                }
                preload.show()

                // console.log(param);
                // return ;
                var jxr = $.post(api + 'pgf2023/api/php/user?stage=send_invitation' , param, function(){ }, 'json')
                           .always(function(snap){ 
                                console.log(snap);
                                // return ;
                                if(snap.status == 'Success'){
                                    // window.location.reload()
                                    
                                    setTimeout(function(){
                                      preload.hide()
                                      Swal.fire({
                                        title: 'Done.',
                                        text: "Invitation e-mail send to reviewer",
                                        icon: 'success',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Back to reviewer list',
                                        cancelButtonText: 'Cancel',
                                        confirmButtonClass: 'btn btn-danger mr-1',
                                        cancelButtonClass: 'btn btn-secondary',
                                        buttonsStyling: false,
                                    }).then(function (result) {
                                        if (result.value) {
                                          window.location = 'app-reviewer';
                                        }
                                      })
                                    }, 2000)
                                }else{ 
                                    preload.hide()
                                    Swal.fire({
                                        icon: "error",
                                        title: 'Error',
                                        text: 'Can not send invitation letter',
                                        confirmButtonClass: 'btn btn-danger',
                                        confirmButtonText: "Try again"
                                    })
                                    return ;
                                }
                            })
            }
        })
    },
    remove_participant(uid){
        Swal.fire({
            title: 'Are you sure?',
            text: "Remove this person from participant list?",
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
                var param = {
                    uid: $('#txtUid').val(),
                    token: $("#txtToken").val(),
                    target_uid: uid
                }
                preload.show()
                var jxr = $.post(api + 'pgf2023/api/php/user?stage=remove_participant' , param, function(){ }, 'json')
                           .always(function(snap){ 
                                console.log(snap);
                                if(snap.status == 'Success'){
                                    window.location.reload()
                                }else{ 
                                    preload.hide()
                                    Swal.fire({
                                        icon: "error",
                                        title: 'Error',
                                        text: 'Can not remove from list',
                                        confirmButtonClass: 'btn btn-danger',
                                        confirmButtonText: "Try again"
                                    })
                                    return ;
                                }
                            })
            }
        })
    },
    set_reviewer_invitation(uid){
        // $('#modalInvitation').modal('show')
        // $('#txtReviewerFullname').val(fullname)
        // $('#txtReviewerEmail').val(email)
        window.location = 'app-reviewer-send-invitation?uid=' + uid
    }
}