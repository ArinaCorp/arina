$(document).ready(function () {
    // $(document).on('click', '.action-button', function (e) {
    //     e.preventDefault();
    //     var data;
    //     if ($(this).attr('data-key')) {
    //         data = $(this).closest("form").serialize() + "&save=0&" + $(this).attr('data-action') + "=1" + "&data-key=" + $(this).attr('data-key');
    //     } else {
    //         data = $(this).closest("form").serialize() + "&save=0&" + $(this).attr('data-action') + "=1";
    //     }
    //     var containerID = '#' + $(this).closest('.tab-pane').attr('id');
    //     $.pjax({
    //         url: location.href,
    //         type: "POST",
    //         container: containerID,
    //         fragment: containerID,
    //         scrollTo: false,
    //         timeout: 3000,
    //         data: data
    //     });
    // });
    $(document).on('click', '.save-btn', function (event) {
        var data = $(this).closest("form").serialize();
        var action = $(this).attr('data-action');
        if (action) {
            data += '&' + action + '=1';
        }
        $.pjax.reload({
            type: "POST",
            container: "#pjax-container",
            scrollTo: false,
            timeout: 3000,
            data: data
        });
    });
    /**
     * Save menu position to cookie
     */
    var expandMainMenu = tools.cookie.get('expandMainMenu');

    jQuery('.menu-button').on('click', function () {
        setTimeout(function () {
            tools.cookie.set('expandMainMenu', !jQuery('.sidebar').hasClass('closed'));
        });
    });

    if (expandMainMenu == 'true') {
        jQuery('.sidebar').removeClass('closed');
        jQuery('#page-wrapper').removeClass('maximized');
    }

    $(document).on('change', '#not-present-check', function () {
        var $this = $(this);
        if ($this.checked() == 1) {
            $this.hide();
        } else {
            $this.show();
        }
    });
});

$(document).ready(function () {
    $('#employee-is_in_education').on('change', function () {
        if ($(this).val() == 0) {
            $('.field_cyclic_commission_id').addClass('hidden');
        } else {
            $('.field_cyclic_commission_id').removeClass('hidden');
        }
    })
});

let background = $(".dialog-background");
let attestationBtn= $("#attestation");
let semesterBtn = $("#semester");
let examBtn = $("#exam");
let zalikBtn = $("#zalik");
let navbar = $(".sidebar");

background.click(function () {
    $('.dialog-window').fadeOut(200);
});
function showDialog(button,form){
    form.fadeIn(200);
    form.css('display', 'flex');
}

zalikBtn.click(() => {
    showDialog(zalikBtn,$('#zalik-window'));
});

attestationBtn.click(() => {
    showDialog(attestationBtn,$('#attestation-window'));
});

semesterBtn.click(() => {
    showDialog(semesterBtn,$('#semester-window'));
});

examBtn.click(() => {
    showDialog(examBtn,$('#exam-window'));
});