$(document).ready(function(){
    $(".frame").click(function(){
        const status = $(this).attr('value') || '0';
        const passwordInput = $('#password');
        
        if(status === '0'){
            $(this).attr('src', './assets/images/signin_image/openedEye.svg');
            $(this).attr('value', "1");
            passwordInput.attr('type', 'text');
        } else {
            $(this).attr('src', './assets/images/signin_image/closedEye.svg');
            $(this).attr('value', "0");
            passwordInput.attr('type', 'password');
        }
    });
});