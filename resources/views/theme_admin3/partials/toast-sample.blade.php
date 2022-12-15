<script type="text/javascript">
    window.onload = function () {
        lptoast.cogoToast.success('01# This is a success message!', { position: 'top-center', heading: 'Success' });
        lptoast.cogoToast.info('02# This is a Info message!', { position: 'bottom-right', heading: 'Info' });
        lptoast.cogoToast.warn('03# This is a Warning message!', { position: 'top-right', heading: 'Warning' });
        lptoast.cogoToast.error('04# This is a Error message!', { position: 'bottom-center', heading: 'Error' });
        displayAlert('success', '05# This is a success message!');
        displayAlert('danger', '06# This is a danger message!');
        displayAlert('warning', '07# This is a warning message!');
        displayAlert('info', '08# This is a info message!');
    }
</script>