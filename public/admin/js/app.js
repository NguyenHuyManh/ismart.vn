$(document).ready(function() {
    $('.nav-link.active .sub-menu').slideDown();

    $('#sidebar-menu .arrow').click(function() {
        $(this).parents('li').children('.sub-menu').slideToggle();
        $(this).toggleClass('fa-angle-right fa-angle-down');
    });

    //Check box
    $('.checkall').click(function() {
        $(this).parents('.table-checkall').find('.check-childrent').prop('checked', $(this).prop('checked'));
    });

    //Auto search
    $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    //Ckediter
    CKEDITOR.replace('editor1');

    //Auto đóng thông báo alert
    $("div.alert").delay(3000).slideUp();

    //Fomat-money
    $('.format-money').simpleMoneyFormat();

    //Load image
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imgOut').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
    $("#imgInp").change(function() {
        readURL(this);
    });

    //Tooltip
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    //Validate add slider
    $("#slider-validate").validate({
        rules: {
            "image": {
                required: true,
            }
        },
        messages: {
            "image": {
                required: "Ảnh không được để trống!",
            }
        }
    });

    //Validate add banner
    $("#banner-validate").validate({
        rules: {
            "image": {
                required: true,
            }
        },
        messages: {
            "image": {
                required: "Ảnh không được để trống!",
            }
        }
    });

    //Checkbox phân quyền
    $('.checkbox-parent').on('click', function(){
        $(this).parents('.card-wrapper').find('.checkbox-childrent').prop('checked', $(this).prop('checked'));
    });
});
