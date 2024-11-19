const avatarInput = $('#avatarInput');

$('.open-avatar-selector').click(function(){
    avatarInput.click();
});


// Handle selected file
avatarInput.change(function(e){
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            $('.avatar img').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
        console.log($('#avatarInput').val());
    }
});
