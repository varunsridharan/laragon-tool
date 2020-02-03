$(function () {

    /**
     * Hosts Module Related Javascript.
     * @type {jQuery|HTMLElement}
     */

    var allcheckbox = $('table#hostslisting input[type=checkbox]');
    var hostdelete = $('table#hostslisting button.host-delete');

    allcheckbox.on('click', function () {
        var btn = $(this);
        allcheckbox.attr('disabled', 'disabled');
        jQuery.ajax({
            url: location.href,
            method: 'POST',
            data: {
                host_id: $(this).attr('id'),
                action: "update-status",
                status: $(this).prop('checked'),
            }
        }).done(function (res) {
            var host = JSON.parse(res);
            if ( typeof host.host_id !== 'undefined' ) {
                btn.attr('id', host.host_id);
                btn.parent().find('label').attr('for', host.host_id);
            }
        }).always(function () {
            allcheckbox.removeAttr('disabled');
        });
    });

    hostdelete.on('click', function () {
        var btn = $(this);
        hostdelete.attr('disabled', 'disabled');
        jQuery.ajax({
            url: location.href,
            method: 'POST',
            data: {
                action: "delete",
                host_id: $(this).attr('id')
            }
        }).done(function (res) {
            var host = JSON.parse(res);
            if ( typeof host.status !== 'undefined' ) {
                if ( true === host.status ) {
                    btn.parent().parent().remove();
                }
            }
        }).always(function () {
            hostdelete.removeAttr('disabled');
        });
    });

    $('.modal').on('click', '.addnew-hosts-entry', function () {
        var $data = {
            action: "addnew",
            ip: $('.modal').find('#host_ip').val(),
            domains: $('.modal').find('#domains').val(),
            comments: $('.modal').find('#comments').val(),
            status: $('.modal').find('#new_hosts_status').prop('checked'),
        };

    });
});