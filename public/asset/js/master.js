$('#sideMenuShow').on('click', function() {
    $('.sideMenuCover').fadeIn();
    $('.sideMenu').css('right', '0');
    $('body').addClass('hideScrollBody')
});

$('.sideMenuCover').on('click', function() {
    $(this).fadeOut();
    $('.sideMenu').css('right', '-300px');
    $('body').removeClass('hideScrollBody')
});

$('#sideMenuClose').on('click', function() {
   $('.sideMenuCover').fadeOut();
    $('.sideMenu').css('right', '-300px');
    $('body').removeClass('hideScrollBody')
});



// Cart Show
$('#cartShow').on('click', function() {
    $('.sideMenuCover').fadeIn();
    $('.cartView').css('right', '0');
    $('body').addClass('hideScrollBody')
});


$('.sideMenuCover').on('click', function() {
    $(this).fadeOut();
    $('.cartView').css('right', '-300px');
    $('body').removeClass('hideScrollBody')
});

$('#cartClose').on('click', function() {
   $('.sideMenuCover').fadeOut();
    $('.cartView').css('right', '-300px');
    $('body').removeClass('hideScrollBody')
});


$('#showReg').on('click', function() {
    $('.signIn').css('display', 'none');
    $('.signUp').css('display', 'block');
});
$('#showLogin').on('click', function() {
    $('.signIn').css('display', 'block');
    $('.signUp').css('display', 'none');
});


