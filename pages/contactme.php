<div class="text-center text-white" style="background-color: #031430; padding-top: 130px; padding-bottom: 120px;">
    <h2 class="fw-semibold m-0" style="font-size: 3.5rem; letter-spacing: 0.5px;">Contact Me</h2>
</div>

<div id="notifPopup" style="
    display:none;
    position:fixed;
    top:20px;
    right:20px;
    z-index:9999;
    min-width:280px;
    max-width:350px;
    padding:16px 20px;
    border-radius:10px;
    color:#fff;
    font-weight:600;
    box-shadow:0 4px 15px rgba(0,0,0,0.3);
    transition: all 0.3s ease;">
    <span id="notifMessage"></span>
</div>

<section class="py-5">
    <div class="container text-white" style="max-width: 650px;">
        <p class="fst-italic mb-4" style="font-size: 0.9rem; line-height: 1.6; color: #e2e8f0;">
            *Note: For mutual comfort, please use the form below wisely and convey your message
            using polite language. Thank you for your cooperation.
        </p>

        <form id="contactForm" method="POST">
            <div style="position:absolute; left:-9999px; top:-9999px;" aria-hidden="true">
                <label for="website">Website</label>
                <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
            </div>

            <div class="mb-3">
                <label for="nama" class="form-label fw-semibold mb-2">Name</label>
                <input type="text" class="form-control px-3 py-2" id="nama" name="nama" placeholder="Example : Risky" maxlength="50"
                    style="border-radius: 10px; border: none;">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold mb-2">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control px-3 py-2" id="email" name="email" placeholder="Example : risky@gmail.com"
                    required maxlength="50" style="border-radius: 10px; border: none;">
            </div>

            <div class="mb-3">
                <label for="topik" class="form-label fw-semibold mb-2">Topic <span class="text-danger">*</span></label>
                <select class="form-select px-3 py-2" id="topik" name="topik" required style="border-radius: 10px; border: none;">
                    <option value="" selected disabled>Please Select One</option>
                    <option value="bug">Report a Bug</option>
                    <option value="cheat">Report a Player</option>
                    <option value="staff">Report Our Staff</option>
                    <option value="saran">Feedback & Suggestions</option>
                    <option value="banned">Submit an Appeal</option>
                    <option value="lainnya">Others</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="penjelasan" class="form-label fw-semibold mb-2">Explanation <span
                        class="text-danger">*</span></label>
                <textarea class="form-control px-3 py-2" id="penjelasan" name="penjelasan" rows="4"
                    placeholder="Example : I got banned" required maxlength="500"
                    style="border-radius: 15px; border: none; resize: none;"></textarea>
            </div>

            <div class="text-start">
                <button type="submit" id="btnSubmit" class="btn btn-primary px-4 py-2 fw-semibold"
                    style="background-color: #ff7b00; border: none; border-radius: 8px;">Submit Report</button>
                <p style="font-size: 0.75rem; color: #94a3b8; margin-top: 10px;">
                    This site is protected by reCAPTCHA and the Google
                    <a href="https://policies.google.com/privacy" target="_blank" style="color:#94a3b8; text-decoration:underline;">Privacy Policy</a> and
                    <a href="https://policies.google.com/terms" target="_blank" style="color:#94a3b8; text-decoration:underline;">Terms of Service</a> apply.
                </p>
            </div>
        </form>
    </div>
</section>

<style>
    .grecaptcha-badge {
        visibility: hidden;
    }
</style>

<script src="https://www.google.com/recaptcha/api.js?render=6LeEj1YtAAAAAKqmxx_kv9hW4abpK5S2CVY4dRVV"></script>
<script src="../script/contactscript.js"></script>