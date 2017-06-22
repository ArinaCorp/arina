$(document).ready(function () {
    $(document).on('click', '.action-button', function (e) {
        e.preventDefault();
        var data;
        if ($(this).attr('data-key')) {
            data = $(this).closest("form").serialize() + "&save=0&" + $(this).attr('data-action') + "=1" + "&data-key=" + $(this).attr('data-key');
        } else {
            data = $(this).closest("form").serialize() + "&save=0&" + $(this).attr('data-action') + "=1";
        }
        var containerID = '#' + $(this).closest('.student-tab').attr('id');
        $.pjax({
            url: location.href,
            type: "POST",
            container: containerID,
            fragment: containerID,
            scrollTo: false,
            timeout: 3000,
            data: data
        });
    });
    $(document).on('change', '#not-present-check', function () {
        var $this = $(this);
        if ($this.checked() == 1) {
            $this.hide();
        } else {
            $this.show();
        }
    })
});

