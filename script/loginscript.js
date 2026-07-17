const RECAPTCHA_SITE_KEY = "6LeEj1YtAAAAAKqmxx_kv9hW4abpK5S2CVY4dRVV";
let isSubmitting = false;

document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault();

    if (isSubmitting) return;
    isSubmitting = true;

    const form = e.target;
    const btn = document.getElementById('btnLogin');
    const errorBox = document.getElementById('loginError');
    errorBox.style.display = 'none';

    btn.disabled = true;
    btn.textContent = 'Memproses...';

    grecaptcha.ready(function () {
        grecaptcha.execute(RECAPTCHA_SITE_KEY, { action: 'admin_login' }).then(function (token) {
            const formData = new FormData(form);
            formData.append('recaptcha_token', token);

            fetch('../api/login.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    window.location.href = data.redirect;
                } else {
                    errorBox.textContent = data.message;
                    errorBox.style.display = 'block';
                }
            })
            .catch(() => {
                errorBox.textContent = 'Terjadi kesalahan koneksi ke server.';
                errorBox.style.display = 'block';
            })
            .finally(() => {
                btn.disabled = false;
                btn.textContent = 'Login';
                isSubmitting = false;
            });
        });
    });
});