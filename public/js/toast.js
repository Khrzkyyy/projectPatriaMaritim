toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-full-width",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": 300,
    "hideDuration": 1000,
    "timeOut": 3000,
    "extendedTimeOut": 1000,
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

document.addEventListener('livewire:load', function () {
    Livewire.on('showToastr', (message, type) => {
        if (type === 'success') {
            toastr.success(message, "Success!");
        } else if (type === 'error') {
            toastr.error(message, "Error!");
        } else {
            toastr.info(message, "Info!");
        }
    });
});