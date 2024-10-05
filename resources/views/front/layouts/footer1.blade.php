<style>
    .social-link {
        color: #6e6e6e;
        margin: 0 10px;
    }
    .social-link:hover {
        color: #6e6e6e;
    }

    .whatsapp .fab.fa-whatsapp {
        color: #6e6e6e;
    }

    .twitter .fab.fa-twitter {
        color: #6e6e6e;
    }

    .facebook .fab.fa-facebook {
        color: #6e6e6e;
    }

    <style>
    .social-link {
        color: #333;
        font-size: 1.2rem;
    }
    .social-link:hover {
        color: #007bff;
    }
    .text-gray-600 {
        color: #6c757d !important;
    }
    .link-info {
        color: #007bff;
    }
    .link-info:hover {
        color: #0056b3;
    }
    .slash {
        color: #6c757d;
        margin: 0 0.5rem;
    }
</style>
<!-- start footer section -->
    <div class="curve-shape">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
            viewBox="0 0 4000 275">
            <path fill="#f3f3ff" d="M4000,125.3V275H0V109.9C1907.2,615.4,2670.5-323.1,4000,125.3z"></path>
        </svg>
    </div>
    <footer class="bg-light ">
        <div class="container">
            <div class="row align-items-center flex-lg-row flex-column-reverse pt-50 pb-40">
                <div class="col-lg-6">
                    <div class="text-lg-start text-center pe-xxl-5 me-xxl-5">
                        <h3 class="fs-30 mb-20">{{ __('messages.Subscribe_Our_Newsletter') }}</h3>
                        <p class="text-gray-100 fs-18 mb-40 pb-lg-3 pe-xl-5 me-xl-5">
                            {{ __('messages.Receive_latest_news_update_and_many_other_things_every_week') }}</p>
                    </div>
                    <form action="{{ route('email.sub') }}" method="post" id="addEmail">
                        @csrf()
                        <div class="email">
                            <input type="email" name="email" id="email" class="form-control"
                                placeholder="{{ __('messages.front.enter_your_email') }}" value="" required>
                            <!-- Placeholder for error messages -->
                            <div id="email-error" class="text-danger" style="display: none;"></div>

                            <div class="subscribe-btn text-sm-end text-center mt-sm-0 mt-4">
                                <button type="submit" class="btn btn-primary h-100 subscribeBtn">{{ __('messages.subscribe') }}</button>
                            </div>
                        </div>
                    </form>

                    <script>
                        document.getElementById('addEmail').addEventListener('submit', function(e) {
                            e.preventDefault(); // Prevent form from submitting the traditional way

                            var form = this;
                            var email = form.querySelector('#email').value;

                            // Clear any previous error messages
                            var errorDiv = document.getElementById('email-error');
                            errorDiv.style.display = 'none';
                            errorDiv.innerHTML = ''; // Clear the error message

                            // Front-end Validation checks
                            var invalidChars = /[!#\$%\^&\*\(\)]/;
                            if (invalidChars.test(email)) {
                                errorDiv.style.display = 'block';
                                errorDiv.innerHTML = 'Email contains invalid characters.';
                                return false;
                            }

                            if (email.match(/\.com\..+/)) {
                                errorDiv.style.display = 'block';
                                errorDiv.innerHTML = 'Email contains duplicate domain extensions.';
                                return false;
                            }

                            if (email.length > 25) {
                                errorDiv.style.display = 'block';
                                errorDiv.innerHTML = 'Email is too long. Please use less than 25 characters.';
                                return false;
                            }

                            var formData = new FormData(form);
                            fetch("{{ route('email.sub') }}", {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                                }
                            })
                            alert("802189")
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Successfully subscribed!');
                                } else {
                                    errorDiv.style.display = 'block';
                                    errorDiv.innerHTML = data.message || 'An error occurred.';
                                }
                            })
                            .catch(error => {
                                errorDiv.style.display = 'block';
                                errorDiv.innerHTML = 'An unexpected error occurred.';
                                console.log('Error:', error);
                            });
                        });
                    </script>





                </div>
                <div class="col-lg-6 text-lg-end text-center mb-lg-0 mb-40">
                    <div class="footer-img ">
                        <img src="{{ asset('assets/img/new_home_page/footer-img.png') }}"
                            class="zoom-in-zoom-out img-fluid w-auto h-100" alt="img">
                    </div>

                </div>
            </div>
            <div class="row align-items-center">
            <div class="col-md-4 mb-3 mb-md-0 text-center text-md-start text-gray-600">
                © {{ \Carbon\Carbon::now()->year }} {{ getAppName() }}.
                <span class="text-gray-600">All Rights Reserved. 1XL Info LLP</span>
                <p class="text-gray-600">A product by <a href="https://1xl.com/" target="blank">1XL.com</a></p>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="social-media-links d-flex justify-content-center">
                    <a href="https://www.facebook.com/1XLUniverse" target="_blank" class="social-link text-decoration-none me-2">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="https://www.linkedin.com/company/1XLUniverse" target="_blank" class="social-link text-decoration-none me-2">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://www.youtube.com/@1XLUniverse" target="_blank" class="social-link text-decoration-none me-2">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="https://www.medium.com/@1XLUniverse/" target="_blank" class="social-link text-decoration-none me-2">
                        <i class="fab fa-medium"></i>
                    </a>
                    <a href="https://www.x.com/1XLUniverse/" target="_blank" class="social-link text-decoration-none me-2">
                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="13" height="24" fill="currentColor"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg>
                    </a>
                    <a href="https://www.reddit.com/user/1XLUniverse/" target="_blank" class="social-link text-decoration-none me-2">
                        <i class="fab fa-reddit"></i>
                    </a>
                    <a href="https://www.pinterest.com/1XLUniverse/" target="_blank" class="social-link text-decoration-none me-2">
                        <i class="fab fa-pinterest"></i>
                    </a>
                    <a href="https://www.quora.com/profile/1XLUniverse/" target="_blank" class="social-link text-decoration-none me-2">
                        <i class="fab fa-quora"></i>
                    </a>
                    <a href="https://www.discord.com/channels/@1XLUniverse/" target="_blank" class="social-link text-decoration-none me-2">
                        <i class="fab fa-discord"></i>
                    </a>
                    <a href="https://whatsapp.com/channel/0029VaLoJ1SLCoX4iyiW0R0c" target="_blank" class="social-link text-decoration-none me-2">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="https://www.threads.net/@1XLUniverse/" target="_blank" class="social-link text-decoration-none me-2">
                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="13" height="24" fill="currentColor">
                                <path d="M331.5 235.7c2.2 .9 4.2 1.9 6.3 2.8c29.2 14.1 50.6 35.2 61.8 61.4c15.7 36.5 17.2 95.8-30.3 143.2c-36.2 36.2-80.3 52.5-142.6 53h-.3c-70.2-.5-124.1-24.1-160.4-70.2c-32.3-41-48.9-98.1-49.5-169.6V256v-.2C17 184.3 33.6 127.2 65.9 86.2C102.2 40.1 156.2 16.5 226.4 16h.3c70.3 .5 124.9 24 162.3 69.9c18.4 22.7 32 50 40.6 81.7l-40.4 10.8c-7.1-25.8-17.8-47.8-32.2-65.4c-29.2-35.8-73-54.2-130.5-54.6c-57 .5-100.1 18.8-128.2 54.4C72.1 146.1 58.5 194.3 58 256c.5 61.7 14.1 109.9 40.3 143.3c28 35.6 71.2 53.9 128.2 54.4c51.4-.4 85.4-12.6 113.7-40.9c32.3-32.2 31.7-71.8 21.4-95.9c-6.1-14.2-17.1-26-31.9-34.9c-3.7 26.9-11.8 48.3-24.7 64.8c-17.1 21.8-41.4 33.6-72.7 35.3c-23.6 1.3-46.3-4.4-63.9-16c-20.8-13.8-33-34.8-34.3-59.3c-2.5-48.3 35.7-83 95.2-86.4c21.1-1.2 40.9-.3 59.2 2.8c-2.4-14.8-7.3-26.6-14.6-35.2c-10-11.7-25.6-17.7-46.2-17.8H227c-16.6 0-39 4.6-53.3 26.3l-34.4-23.6c19.2-29.1 50.3-45.1 87.8-45.1h.8c62.6 .4 99.9 39.5 103.7 107.7l-.2 .2zm-156 68.8c1.3 25.1 28.4 36.8 54.6 35.3c25.6-1.4 54.6-11.4 59.5-73.2c-13.2-2.9-27.8-4.4-43.4-4.4c-4.8 0-9.6 .1-14.4 .4c-42.9 2.4-57.2 23.2-56.2 41.8l-.1 .1z"/>
                            </svg>
                    </a>
                </div>
            </div>
            <div class="col-md-4 text-center text-md-end">
                <a href="{{ route('terms.conditions') }}" target="_blank" class="text-decoration-none link-info me-2">
                    {!! __('messages.vcard.term_condition') !!}
                </a>
                <span class="slash">|</span>
                <a href="{{ route('privacy.policy') }}" target="_blank" class="text-decoration-none link-info ms-2">
                    {{ __('messages.vcard.privacy_policy') }}
                </a>
            </div>
        </div>
        </div>


    </footer>
        <!--support banner -->
        @if(isset($setting['banner_enable']) && $setting['banner_enable'] == 1)
        <section class="banner-section bg-light banner-cookie d-none">
            <div class="hero-bg-img text-end">
            </div>
            <div class="container">
                <div class="row mt-5 pt-4 pb-3">
                    <div class="text-center text">
                    <h3>{{ $setting['banner_title'] }}</h3>
                    <p>{{ $setting['banner_description'] }}</p>
                    </div>
                    <div class="text-center pt-2">
                        <a href="{{ $setting['banner_url'] }}" class="btn btn-primary act-now" target="blank" data-turbo="false">{{ $setting['banner_button'] }}</a>
                    </div>
                </div>
            </div>
            <div class="main-banner top-0 left-curve-1">
                <img src="{{ asset('assets/img/new_home_page/left-curve-1.png') }}" class="w-100 h-auto" alt="image">
            </div>
            <div class="main-banner left-curve2">
                <img src="{{ asset('/assets/img/new_home_page/left-curve2.png') }}" class="w-100 h-auto" alt="image">
            </div>

            <div class="main-banner bottom-0 right-curve1">
                <img src="{{ asset('assets/img/new_home_page/right-curve1.png') }}" class="w-100 h-auto" alt="image">
            </div>
            <div class="main-banner right-curve-2">
                <img src="{{ asset('assets/img/new_home_page/right-curve-2.png') }}" class="w-100 " alt="image">
            </div>
            <div class="main-banner square-1">
                <img src="{{ asset('assets/img/new_home_page/squre.png') }}" class="w-100 " alt="image">
            </div>
            <div class="main-banner banner-img-3">
                <img src="{{ asset('assets/img/new_home_page/round-1.png') }}" class="w-100 h-auto" alt="image">
            </div>
            <div class="main-banner square-2">
                <img src="{{ asset('assets/img/new_home_page/squre.png') }}" class="w-100 h-auto" alt="image">
            </div>
            <div class="main-banner banner-img-4">
                <img src="{{ asset('assets/img/new_home_page/round-2.png') }}" class="w-100 h-auto" alt="image">
            </div>
            <div class="main-banner group-dot">
                <img src="{{ asset('assets/img/new_home_page/group-1.png') }}" class="w-100 h-auto" alt="image">
            </div>
            <div class="main-banner squre-img">
                <img src="{{ asset('assets/img/new_home_page/round-1.png') }}" class="w-100 h-auto" alt="image">
            </div>
            <div class="main-banner round-1">
                <img src="{{ asset('assets/img/new_home_page/round-1.png') }}" class="w-100 h-auto" alt="image">
            </div>
            <div class="main-banner group-dot-2">
                <img src="{{ asset('assets/img/new_home_page/group-2.png') }}" class="w-100 h-auto" alt="image">
            </div>
            <div class="main-banner triangel-img">
                <img src="{{ asset('assets/img/new_home_page/triangel.png') }}" class="w-100 h-auto" alt="image">
            </div>
            <div class="main-banner close-btn bg-transparent">
                <button type="button" class="border-0 bg-transparent disbale-cookie"><i class="fa-solid fa-xmark"></i></button>
            </div>
        </section>
        @endif
    <!-- end footer section -->
