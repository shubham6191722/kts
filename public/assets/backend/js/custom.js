function show_toastr(type, title_msg, title_sub_msg) {
    toastr.options.closeButton = true;
    toastr.options.progressBar = true;
    toastr.options.timeOut = '5000';

    if (type == 'success') {
        toastr.success(title_sub_msg, title_msg);
    } else if (type == 'info') {
        toastr.info(title_sub_msg, title_msg);
    } else if (type == 'warning') {
        toastr.warning(title_sub_msg, title_msg);
    } else if (type == 'error') {
        toastr.error(title_sub_msg, title_msg);
    }
}

$(".read-more").click(function() {
    $(this).parent().find('.description-read').css("height", "auto");
    $(this).parent().find('.read-less').css("display", "block");
    $(this).css("display", "none");
});

$(".read-less").click(function() {
    $(this).parent().find('.description-read').css("height", "100px");
    $(this).parent().find('.read-more').css("display", "block");
    $(this).css("display", "none");
});