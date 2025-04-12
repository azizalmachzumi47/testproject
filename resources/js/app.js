import './bootstrap';
import Swal from 'sweetalert2';

document.addEventListener('DOMContentLoaded', function () {
    const alerts = document.getElementById('alerts');
    const success = alerts.getAttribute('data-success');
    const error = alerts.getAttribute('data-error');
    const errors = alerts.getAttribute('data-errors');

    if (success) {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: success,
        });
    }

    if (error) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: error,
        });
    }

    if (errors) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Errors',
            text: errors.replace(/,/g, '\n'),
        });
    }
});
