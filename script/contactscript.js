const RECAPTCHA_SITE_KEY = "6LeEj1YtAAAAAKqmxx_kv9hW4abpK5S2CVY4dRVV";
    let isSubmitting = false; // proteksi tambahan di frontend biar tombol tidak bisa double click

    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();

        if (isSubmitting) return; // cegah spam klik cepat
        isSubmitting = true;

        const form = e.target;
        const btn = document.getElementById('btnSubmit');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = 'Mengirim...';

        grecaptcha.ready(function() {
            grecaptcha.execute(RECAPTCHA_SITE_KEY, {
                action: 'submit_contact'
            }).then(function(token) {
                const formData = new FormData(form);
                formData.append('recaptcha_token', token);

                fetch('../api/proses_kontak.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        showNotif(data.message, data.status === 'success');
                        if (data.status === 'success') {
                            form.reset();
                        }
                    })
                    .catch(() => {
                        showNotif('Terjadi kesalahan koneksi ke server.', false);
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                        isSubmitting = false;
                    });
            });
        });
    });

    function showNotif(message, isSuccess) {
        const popup = document.getElementById('notifPopup');
        const msg = document.getElementById('notifMessage');

        popup.style.backgroundColor = isSuccess ? '#28a745' : '#dc3545';
        msg.textContent = message;
        popup.style.display = 'block';
        popup.style.opacity = '1';

        setTimeout(() => {
            popup.style.opacity = '0';
            setTimeout(() => {
                popup.style.display = 'none';
            }, 300);
        }, 3500);
    }