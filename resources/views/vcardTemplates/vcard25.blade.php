<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    @if (checkFeature('seo'))
        @if ($vcard->meta_description)
            <meta name="description" content="{{ $vcard->meta_description }}">
        @endif
        @if ($vcard->meta_keyword)
            <meta name="keywords" content="{{ $vcard->meta_keyword }}">
        @endif
    @else
        <meta name="description" content="{{ $vcard->description }}">
        <meta name="keywords" content="">
    @endif
    <meta property="og:image" content="{{ $vcard->cover_url }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @if (checkFeature('seo') && $vcard->site_title && $vcard->home_title)
        <title>{{ $vcard->home_title }} | {{ $vcard->site_title }}</title>
    @else
        <title>{{ $vcard->name }} | {{ getAppName() }}</title>
    @endif

    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef" />
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    <link rel="manifest" href="{{ asset('pwa/1.json') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS -->
    <link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ getFaviconUrl() }}" type="image/png">

    {{-- css link --}}
    <link rel="stylesheet" href="{{ asset('assets/css/vcard25.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slider/css/slick-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/new_vcard/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/new_vcard/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/new_vcard/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/third-party.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-vcard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lightbox.css') }}">
    @if ($vcard->font_family || $vcard->font_size || $vcard->custom_css)
        <style>
            @if (checkFeature('custom-fonts'))
                @if ($vcard->font_family)
                    body {
                        font-family: {{ $vcard->font_family }};
                    }
                @endif
                @if ($vcard->font_size)
                    div>h4 {
                        font-size: {{ $vcard->font_size }}px !important;
                    }
                @endif
            @endif
            @if (isset(checkFeature('advanced')->custom_css))
                {!! $vcard->custom_css !!}
            @endif
        </style>
    @endif
    <style>
        .bg-img {
            background-image: url("/assets/img/vcard25/bg-img.png");
        }
    </style>
</head>

<body>
    <div class="container p-0">
        <div class="main-content mx-auto w-100 overflow-hidden">
              {{-- support banner --}}
                @if ((isset($managesection) && $managesection['banner']) || empty($managesection))
                @if (isset($banners->title))
                        <div class="support-banner d-flex align-items-center justify-content-center">
                            <button type="button" class="text-start banner-close"><i
                                    class="fa-solid fa-xmark"></i></button>
                            <div class="">
                                <h1 class="text-center support_heading">{{ $banners->title }}</h1>
                                <p class="text-center support_text text-dark">{{ $banners->description }} </p>
                                <div class="text-center">
                                    <a href="{{ $banners->url }}" class="act-now rounded text-light" target="blank"
                                        data-turbo="false">{{ $banners->banner_button }} </a>
                                </div>
                            </div>
                        </div>
                @endif
            @endif
            <div class="banner-section position-relative">
                <div class="banner-img">
                    @if (strpos($vcard->cover_url, '.mp4') !== false || strpos($vcard->cover_url, '.mov') !== false || strpos($vcard->cover_url, '.avi') !== false)
                    <video class="cover-video object-fit-cover w-100 h-100" loop autoplay muted  alt="background video" id="cover-video">
                        <source src="{{ $vcard->cover_url }}" type="video/mp4">
                    </video>
                    @else
                    <img src="{{ $vcard->cover_url }}" class="object-fit-cover w-100 h-100" loading="lazy"/>
                    @endif
                </div>
                <div class="d-flex justify-content-end position-absolute top-0 end-0 me-3">
                    @if ($vcard->language_enable == \App\Models\Vcard::LANGUAGE_ENABLE)
                        <div class="language pt-4 me-2">
                            <ul class="text-decoration-none">
                                <li class="dropdown1 dropdown lang-list">
                                    <a class="dropdown-toggle lang-head text-decoration-none" data-toggle="dropdown"
                                        role="button" aria-haspopup="true" aria-expanded="false">
                                        <i
                                            class="fa-solid fa-language me-2"></i>{{ getLanguage($vcard->default_language) }}
                                    </a>
                                    <ul class="dropdown-menu start-0 top-dropdown lang-hover-list top-100 mt-0">
                                        @foreach (getAllLanguageWithFullData() as $language)
                                            <li
                                                class="{{ getLanguageIsoCode($vcard->default_language) == $language->iso_code ? 'active' : '' }}">
                                                <a href="javascript:void(0)" id="languageName"
                                                    data-name="{{ $language->iso_code }}">
                                                    @if (array_key_exists($language->iso_code, \App\Models\User::FLAG))
                                                        @foreach (\App\Models\User::FLAG as $imageKey => $imageValue)
                                                            @if ($imageKey == $language->iso_code)
                                                                <img src="{{ asset($imageValue) }}" class="me-1" loading="lazy"/>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        @if (count($language->media) != 0)
                                                            <img src="{{ $language->image_url }}" class="me-1" loading="lazy"/>
                                                        @else
                                                            <i class="fa fa-flag fa-xl me-3 text-danger"
                                                                aria-hidden="true"></i>
                                                        @endif
                                                    @endif
                                                    {{ $language->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="overlay"></div>
            </div>
            {{-- profile detials --}}
            <div class="profile-section px-30">
                <div class="profile-bg-img">
                    <img src="{{ asset('assets/img/vcard25/profile-bg-img.png') }}" loading="lazy"/>
                </div>
                <div class="card d-flex flex-sm-row align-items-sm-start align-items-center mb-sm-4 mb-3 pb-sm-2">
                    <div class="card-img me-sm-2">
                        <img src="{{ $vcard->profile_url }}" class="w-100 h-100 object-fit-cover" loading="lazy"/>
                    </div>
                    <div class="card-body text-sm-start text-center mt-sm-5 pt-sm-4">
                        <div class="profile-name">
                            <h2 class="text-secondary mb-1 mt-2 fs-28 fw-5">
                                {{ ucwords($vcard->first_name . ' ' . $vcard->last_name) }}
                                @if ($vcard->is_verified)
                                    <i class="verification-icon bi-patch-check-fill"></i>
                                @endif
                            </h2>
                            <p class="fs-18 text-gray-100 mb-0 text-primary">{{ ucwords($vcard->occupation) }}</p>
                            <p class="fs-18 text-gray-100 mb-0 text-primary">{{ ucwords($vcard->job_title) }}</p>
                            <p class="fs-18 text-gray-100 mb-0 text-primary">{{ ucwords($vcard->company) }}</p>
                        </div>
                    </div>
                </div>
                <p class="text-gray-100 profile-desc mb-sm-0 fs-6 text-sm-start text-center">
                    {!! $vcard->description !!}</p>
                {{-- social icons --}}
                <div class="social-media d-flex justify-content-center flex-wrap mb-5">
                    @if (checkFeature('social_links') && getSocialLink($vcard))
                        <div
                            class="social-icons d-flex justify-content-center text-decoration-none flex-wrap text-primary bg-gray-100 rounded-pill">
                            @foreach (getSocialLink($vcard) as $value)
                                <span
                                    class="social-back d-flex text-decoration-none bg-gray-100 justify-content-center align-items-center m-sm-2 m-1 text-primary rounded-circle">
                                    {!! $value !!}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            {{-- contact details --}}
            @if ((isset($managesection) && $managesection['contact_list']) || empty($managesection))
                <div class="contact-section pt-60">
                    <div class="bg-light px-30 pt-30 pb-30">
                        <div class="row">
                            @if ($vcard->email)
                                <div class="col-sm-6 mb-4 pb-sm-2 px-lg-4 px-sm-3">
                                    <div class="contact-box text-center">
                                        <div
                                            class="contact-icon d-flex justify-content-center align-items-center mx-auto mb-3">
                                            <img src="{{ asset('assets/img/vcard25/email.png') }}" loading="lazy"/>
                                        </div>
                                        <div class="contact-desc">
                                            <a href="mailto:{{ $vcard->email }}"
                                                class="text-secondary fs-6 fw-5">{{ $vcard->email }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($vcard->alternative_email)
                                <div class="col-sm-6 mb-4 pb-sm-2 px-lg-4 px-sm-3">
                                    <div class="contact-box text-center">
                                        <div
                                            class="contact-icon d-flex justify-content-center align-items-center mx-auto mb-3">
                                            <img src="{{ asset('assets/img/vcard25/email.png') }}" loading="lazy"/>
                                        </div>
                                        <div class="contact-desc">
                                            <a href="mailto:{{ $vcard->alternative_email }}"
                                                class="text-secondary fs-6 fw-5">{{ $vcard->alternative_email }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($vcard->phone)
                                <div class="col-sm-6 mb-4 pb-sm-2 px-lg-4 px-sm-3">
                                    <div class="contact-box text-center">
                                        <div
                                            class="contact-icon d-flex justify-content-center align-items-center mx-auto mb-3">
                                            <img src="{{ asset('assets/img/vcard25/phone.png') }}" loading="lazy"/>
                                        </div>
                                        <div class="contact-desc">
                                            <a href="tel:+{{ $vcard->region_code }}{{ $vcard->phone }}"
                                                class="text-secondary fs-6 fw-5">+{{ $vcard->region_code }}{{ $vcard->phone }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($vcard->alternative_phone)
                                <div class="col-sm-6 mb-4 pb-sm-2 px-lg-4 px-sm-3">
                                    <div class="contact-box text-center">
                                        <div
                                            class="contact-icon d-flex justify-content-center align-items-center mx-auto mb-3">
                                            <img src="{{ asset('assets/img/vcard25/phone.png') }}" loading="lazy"/>
                                        </div>
                                        <div class="contact-desc">
                                            <a href="tel:+{{ $vcard->alternative_region_code }}{{ $vcard->alternative_region_code }}"
                                                class="text-secondary fs-6 fw-5">+{{ $vcard->region_code }}{{ $vcard->alternative_phone }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($vcard->dob)
                                <div class="col-sm-6 mb-4 pb-sm-2 px-lg-4 px-sm-3">
                                    <div class="contact-box text-center">
                                        <div
                                            class="contact-icon d-flex justify-content-center align-items-center mx-auto mb-3">
                                            <img src="{{ asset('assets/img/vcard25/dob-icon.png') }}" loading="lazy"/>
                                        </div>
                                        <div class="contact-desc">
                                            <p class="text-secondary fs-6 fw-5">{{ $vcard->dob }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($vcard->location)
                                <div class="col-sm-6 mb-4 pb-sm-2 px-lg-4 px-sm-3">
                                    <div class="contact-box text-center">
                                        <div
                                            class="contact-icon d-flex justify-content-center align-items-center mx-auto mb-3">
                                            <img src="{{ asset('assets/img/vcard25/location.png') }}" loading="lazy"/>
                                        </div>
                                        <div class="contact-desc">
                                            <p class="text-secondary fs-6 fw-5">{!! ucwords($vcard->location) !!}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            {{-- gallery --}}
            @if ((isset($managesection) && $managesection['galleries']) || empty($managesection))
                @if (checkFeature('gallery') && $vcard->gallery->count())
                    <div class="gallery-section pt-60 px-30 position-relative mb-5 pb-2">
                        <div class="gallery-bg-img">
                            <img src="{{ asset('assets/img/vcard25/gallery-bg.png') }}" alt="gallery-bg" loading="lazy"/>
                        </div>
                        <div class="section-heading text-center mb-30">
                            <h2 class="mb-0">{{ __('messages.plan.gallery') }}</h2>
                        </div>
                        <div class="gallery-slider">
                            @foreach ($vcard->gallery as $file)
                                @php
                                    $infoPath = pathinfo(public_path($file->gallery_image));
                                    $extension = $infoPath['extension'];
                                @endphp
                                <div class="slide">
                                    <div class="gallery-img">
                                        @if ($file->type == App\Models\Gallery::TYPE_IMAGE)
                                            <a href="{{ $file->gallery_image }}" data-lightbox="gallery-images"><img
                                                    src="{{ $file->gallery_image }}" alt="profile"
                                                    class="w-100" loading="lazy"/></a>
                                        @elseif($file->type == App\Models\Gallery::TYPE_FILE)
                                            <a id="file_url" href="{{ $file->gallery_image }}"
                                                class="gallery-link gallery-file-link" target="_blank" loading="lazy">
                                                <div class="gallery-item gallery-file-item"
                                                    @if ($extension == 'pdf') style="background-image: url({{ asset('assets/images/pdf-icon.png') }})"> @endif
                                                    @if ($extension == 'xls') style="background-image: url({{ asset('assets/images/xls.png') }})"> @endif
                                                    @if ($extension == 'csv') style="background-image: url({{ asset('assets/images/csv-file.png') }})"> @endif
                                                    @if ($extension == 'xlsx') style="background-image: url({{ asset('assets/images/xlsx.png') }})"> @endif
                                                    </div>
                                            </a>
                                        @elseif($file->type == App\Models\Gallery::TYPE_VIDEO)
                                            <video class="object-fit-cover" width="100%" height="100%" controls>
                                                <source src="{{ $file->gallery_image }}">
                                            </video>
                                        @elseif($file->type == App\Models\Gallery::TYPE_AUDIO)
                                            <div class="audio-container mt-2">
                                                <img src="{{ asset('assets/img/music.jpeg') }}" alt="Album Cover"
                                                    class="audio-image">
                                                <audio controls src="{{ $file->gallery_image }}"
                                                    class="audio-control">
                                                    Your browser does not support the <code>audio</code> element.
                                                </audio>
                                            </div>
                                        @else
                                            <iframe src="https://www.youtube.com/embed/{{ YoutubeID($file->link) }}"
                                                class="w-100" height="315">
                                            </iframe>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
            {{-- our service --}}
            @if ((isset($managesection) && $managesection['services']) || empty($managesection))
                @if (checkFeature('services') && $vcard->services->count())
                    <div class="our-services-section pt-60">
                        <div class="services-bg-img">
                            <img src="{{ asset('assets/img/vcard25/services-bg.png') }}" alt="services-bg-img" loading="lazy"/>
                        </div>
                        <div class="section-heading text-center mb-40">
                            <h2 class="text-center mb-0">{{ __('messages.vcard.our_service') }}</h2>
                        </div>
                        <div class="services bg-light px-30 pt-30 pb-30">
                            <div class="row">
                                @foreach ($vcard->services as $service)
                                    <div class="col-sm-6 mb-sm-4 mb-4">
                                        <div class="service-card h-100">
                                            <div
                                                class="card-img mx-auto d-flex justify-content-center align-items-center mb-3">
                                                <a href="{{ $service->service_url ?? 'javascript:void(0)' }}"
                                                    class="{{ $service->service_url ? 'pe-auto' : 'pe-none' }}"
                                                    target="{{ $service->service_url ? '_blank' : '' }}">
                                                    <img src="{{ $service->service_icon }}" alt="branding" loading="lazy"/>
                                                </a>
                                            </div>
                                            <div class="card-body text-center p-0 pt-2 flex-grow-0">
                                                <h3 class="card-title fs-18 text-secondary">
                                                    {{ ucwords($service->name) }}
                                                </h3>
                                                <p
                                                    class="mb-0 fs-14 text-gray-100 text-center   {{ \Illuminate\Support\Str::length($service->description) > 80 ? 'more' : '' }}">
                                                    {!! $service->description !!}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            {{-- product --}}
            @if ((isset($managesection) && $managesection['products']) || empty($managesection))
                @if (checkFeature('products') && $vcard->products->count())
                    <div class="product-section pt-60 px-30 mb-5">
                        <div class="product-bg-img text-end">
                            <img src="{{ asset('assets/img/vcard25/product-bg.png') }}" alt="product-bg-img" loading="lazy"/>
                        </div>
                        <div class="section-heading text-center mb-40">
                            <h2 class="mb-0">{{ __('messages.plan.products') }}</h2>
                        </div>
                        <div class="">
                            <div class="product-slider">
                                @foreach ($vcard->products as $product)
                                    <div class="">
                                        <div class="product-card card">
                                            <div class="product-img card-img">
                                                <a @if ($product->product_url) href="{{ $product->product_url }}" @endif
                                                    target="_blank" class="text-decoration-none fs-6"><img
                                                        src="{{ $product->product_icon }}"
                                                        class="w-100 h-100 object-fit-cover" loading="lazy"></a>
                                            </div>
                                            <div class="product-desc align-items-center">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <h3 class="text-secondary fs-18 fw-5 mb-0">{{ $product->name }}
                                                    </h3>
                                                    <h4 class="text-center text-primary mb-0 fs-20">
                                                        @if ($product->currency_id && $product->price)
                                                            <span
                                                                class="fs-18 fw-6 text-primary">{{ $product->currency->currency_icon }}{{ number_format($product->price, 2) }}</span>
                                                        @elseif($product->price)
                                                            <span
                                                                class="fs-18 fw-6 text-primary">{{ getUserCurrencyIcon($vcard->user->id) . ' ' . $product->price }}</span>
                                                        @endif
                                                    </h4>
                                                </div>

                                                <p class="mb-0 text-gray-100 fs-14">
                                                    {{ $product->description }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="me-5 mt-2 text-center view-more">
                                <a class="fs-6 text text-decoration-underline text-primary ms-5" href="{{ route('showProducts',['id'=>$vcard->id,'alias'=>$vcard->url_alias]) }}">{{__('messages.analytics.view_more')}}</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            {{-- make appointment --}}
            @if ((isset($managesection) && $managesection['appointments']) || empty($managesection))
                @if (checkFeature('appointments') && $vcard->appointmentHours->count())
                    <div class="appointment-section pt-60 px-30 mb-5 pb-2">
                        <div class="section-heading text-center mb-40">
                            <h2 class="mb-0">{{ __('messages.make_appointments') }}</h2>
                        </div>
                        <div class="appointment">
                            <form action="">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <label class="mt-sm-3 mb-2">{{ __('messages.date') }}:</label>
                                    </div>
                                    <div class="col-sm-10 mb-20">
                                        <div class="position-relative">
                                            {{ Form::text('date', null, ['class' => 'date appoint-input form-control appointment-input', 'placeholder' => __('messages.form.pick_date'), 'id' => 'pickUpDate']) }}
                                            <span class="calendar-icon">
                                                <svg width="18" height="18" viewBox="0 0 18 18"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_102_145)">
                                                        <path
                                                            d="M14.25 1.5H13.5V0.75C13.5 0.551088 13.421 0.360322 13.2803 0.21967C13.1397 0.0790176 12.9489 0 12.75 0C12.5511 0 12.3603 0.0790176 12.2197 0.21967C12.079 0.360322 12 0.551088 12 0.75V1.5H6V0.75C6 0.551088 5.92098 0.360322 5.78033 0.21967C5.63968 0.0790176 5.44891 0 5.25 0C5.05109 0 4.86032 0.0790176 4.71967 0.21967C4.57902 0.360322 4.5 0.551088 4.5 0.75V1.5H3.75C2.7558 1.50119 1.80267 1.89666 1.09966 2.59966C0.396661 3.30267 0.00119089 4.2558 0 5.25L0 14.25C0.00119089 15.2442 0.396661 16.1973 1.09966 16.9003C1.80267 17.6033 2.7558 17.9988 3.75 18H14.25C15.2442 17.9988 16.1973 17.6033 16.9003 16.9003C17.6033 16.1973 17.9988 15.2442 18 14.25V5.25C17.9988 4.2558 17.6033 3.30267 16.9003 2.59966C16.1973 1.89666 15.2442 1.50119 14.25 1.5ZM1.5 5.25C1.5 4.65326 1.73705 4.08097 2.15901 3.65901C2.58097 3.23705 3.15326 3 3.75 3H14.25C14.8467 3 15.419 3.23705 15.841 3.65901C16.2629 4.08097 16.5 4.65326 16.5 5.25V6H1.5V5.25ZM14.25 16.5H3.75C3.15326 16.5 2.58097 16.2629 2.15901 15.841C1.73705 15.419 1.5 14.8467 1.5 14.25V7.5H16.5V14.25C16.5 14.8467 16.2629 15.419 15.841 15.841C15.419 16.2629 14.8467 16.5 14.25 16.5Z"
                                                            fill="#FFA31A"></path>
                                                        <path
                                                            d="M9 12.375C9.62132 12.375 10.125 11.8713 10.125 11.25C10.125 10.6287 9.62132 10.125 9 10.125C8.37868 10.125 7.875 10.6287 7.875 11.25C7.875 11.8713 8.37868 12.375 9 12.375Z"
                                                            fill="#FFA31A"></path>
                                                        <path
                                                            d="M5.25 12.375C5.87132 12.375 6.375 11.8713 6.375 11.25C6.375 10.6287 5.87132 10.125 5.25 10.125C4.62868 10.125 4.125 10.6287 4.125 11.25C4.125 11.8713 4.62868 12.375 5.25 12.375Z"
                                                            fill="#FFA31A"></path>
                                                        <path
                                                            d="M12.75 12.375C13.3713 12.375 13.875 11.8713 13.875 11.25C13.875 10.6287 13.3713 10.125 12.75 10.125C12.1287 10.125 11.625 10.6287 11.625 11.25C11.625 11.8713 12.1287 12.375 12.75 12.375Z"
                                                            fill="#FFA31A"></path>
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_102_145">
                                                            <rect width="18" height="18" fill="white">
                                                            </rect>
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <label class="mt-sm-3 mb-2">{{ __('messages.hour') }}:</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="row justify-content-center">
                                            <div class="">
                                                <div id="slotData" class="row ">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <button class="appointmentAdd  rounded-2 btn btn-primary w-100">
                                                {{ __('messages.make_appointments') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @include('vcardTemplates.appointment')
                @endif
            @endif
            {{-- testimonial --}}
            @if ((isset($managesection) && $managesection['testimonials']) || empty($managesection))
                @if (checkFeature('testimonials') && $vcard->testimonials->count())
                    <div class="testimonial-section pt-60 pb-5">
                        <div class="testimonial-vector-img">
                            <img src="{{ asset('assets/img/vcard25/testimonial-vector.png') }}"
                                alt="testimonial-vector-img" loading="lazy"/>
                        </div>
                        <div class="section-heading text-center mb-40">
                            <h2 class="mb-0">{{ __('messages.plan.testimonials') }}</h2>
                        </div>
                        <div class="testimonial-slider pt-60 pb-40 px-40">
                            @foreach ($vcard->testimonials as $testimonial)
                                <div class="">
                                    <div class="testimonial-card card flex-sm-row">
                                        <div class="testimonial-profile-img">
                                            <img src="{{ $testimonial->image_url }}"
                                                class="w-100 h-100 object-fit-cover" loading="lazy"/>
                                        </div>
                                        <div class="card-body p-0 text-sm-start text-center">
                                            <div class="">
                                                <div class="quote-img text-center mb-3">
                                                    <img src="{{ asset('assets/img/vcard25/quote-img.png') }}"
                                                        alt="quote-img" class="mx-auto" loading="lazy"/>
                                                </div>
                                                <h3 class="text-white fs-20 fw-6 mb-1">
                                                    {{ ucwords($testimonial->name) }}
                                                </h3>
                                                <p
                                                    class="desc text-white fs-14 {{ \Illuminate\Support\Str::length($testimonial->description) > 80 ? 'more' : '' }}">
                                                    {!! $testimonial->description !!}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
            {{-- insta feed --}}
            @if ((isset($managesection) && $managesection['insta_embed']) || empty($managesection))
                @if (checkFeature('instagramEmbed') && $vcard->instagramEmbed->count())
                    <div class="">
                        <div class="section-heading text-center mb-40">
                            <h2 class="mb-0 d-inline-block mt-5">
                                {{ __('messages.feature.insta_embed') }}
                            </h2>
                        </div>
                        <nav>
                            <div class="row insta-toggle">
                                <div class="nav nav-tabs border-0 px-0" id="nav-tab" role="tablist">
                                    <button class="py-2 active postbtn instagram-btn  border-0 text-dark"
                                        id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                                        type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                                        <span class="px-1">{{ __('messages.vcard.post') }}</span></button>
                                    <button class="py-2 instagram-btn reelsbtn  border-0 text-dark mr-0"
                                        id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                                        type="button" role="tab" aria-controls="nav-profile"
                                        aria-selected="false">
                                        <span class="px-1">{{ __('messages.vcard.reel') }}</span>
                                    </button>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <div id="postContent" class="insta-feed">
                        <div class="row overflow-hidden m-0 mt-2">
                            <!-- "Post" content -->
                            @foreach ($vcard->InstagramEmbed as $InstagramEmbed)
                                @if ($InstagramEmbed->type == 0)
                                    <div class="col-12 col-sm-6">
                                        {!! $InstagramEmbed->embedtag !!}
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="d-none insta-feed" id="reelContent">
                        <div class="row overflow-hidden m-0 mt-2">
                            <!-- "Reel" content -->
                            @foreach ($vcard->InstagramEmbed as $InstagramEmbed)
                                @if ($InstagramEmbed->type == 1)
                                    <div class="col-12 col-sm-6">
                                        {!! $InstagramEmbed->embedtag !!}
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
            {{-- blog --}}
            @if ((isset($managesection) && $managesection['blogs']) || empty($managesection))
                @if (checkFeature('blog') && $vcard->blogs->count())
                    <div class="blog-section pt-60 pb-5">
                        <div class="blog-bg-vector1">
                            <img src="{{ asset('assets/img/vcard25/blog-bg-vector1.png') }}" alt="blog-bg-vector"
                                loading="lazy" />
                        </div>
                        <div class="blog-bg-vector2">
                            <img src="{{ asset('assets/img/vcard25/blog-bg-vector2.png') }}" alt="blog-bg-vector"
                                loading="lazy" />
                        </div>
                        <div class="section-heading text-center mb-40">
                            <h2 class="mb-0">{{ __('messages.feature.blog') }}</h2>
                        </div>
                        <div class="blog-slider">
                            @foreach ($vcard->blogs as $blog)
                                <div class="blog-content bg-none">
                                    <div class="content position-relative">
                                        <div class="row">
                                            <div class="col-6 d-flex align-items-center">
                                                <div class="blog-vector">
                                                    <img src="{{ asset('assets/img/vcard25/blog-vector.png') }}"
                                                        alt="log-vector" class="w-100 h-100 object-fit-cover"
                                                        loading="lazy" />
                                                </div>
                                                <div class="text">
                                                    <h3 class="text-white">{{ $blog->title }}</h3>
                                                    <p class="text-white mb-0">
                                                        {{ Illuminate\Support\Str::words(strip_tags($blog->description), 100, '...') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="blog-img h-100">
                                                    <a
                                                        href="{{ route('vcard.show-blog', [$vcard->url_alias, $blog->id]) }}">
                                                        <img src="{{ $blog->blog_icon }}"
                                                            class="w-100 h-100 object-fit-cover" />
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
            {{-- buisness hours --}}
            @if ((isset($managesection) && $managesection['business_hours']) || empty($managesection))
                @if ($vcard->businessHours->count())
                    @php
                        $todayWeekName = strtolower(\Carbon\Carbon::now()->rawFormat('D'));
                    @endphp
                    <div class="business-hour-section pt-60 px-40 mb-5">
                        <div class="business-hour-bg">
                            <img src="{{ asset('assets/img/vcard25/business-hour-bg.png') }}" alt="bg-img" loading="lazy"/>
                        </div>
                        <div class="section-heading text-center mb-40">
                            <h2 class="mb-0">{{ __('messages.business.business_hours') }}</h2>
                        </div>
                        <div class="business-hours">
                            <div class="business-hour-vector1">
                                <img src="{{ asset('assets/img/vcard25/business-hour-vector.png') }}"
                                    alt="vector" loading="lazy"/>
                            </div>
                            <div class="business-hour-vector2">
                                <img src="{{ asset('assets/img/vcard25/business-hour-vector.png') }}"
                                    alt="vector" loading="lazy"/>
                            </div>
                            @foreach ($businessDaysTime as $key => $dayTime)
                                <div class="mb-10 d-flex justify-content-between">
                                    <span>{{ __('messages.business.' . \App\Models\BusinessHour::DAY_OF_WEEK[$key]) }}:</span>
                                    <span>{{ $dayTime ?? __('messages.common.closed') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
            {{-- qr code --}}
            @if (isset($vcard['show_qr_code']) && $vcard['show_qr_code'] == 1)
                <div class="qr-code-section pt-60 px-40">
                    <div class="section-heading mb-40 pb-40 text-center">
                        <h2 class="mb-0">{{ __('messages.vcard.qr_code') }}</h2>
                    </div>
                    <div class="qr-code mx-auto position-relative">
                        <div class="qr-bg-img text-end">
                            <img src="{{ asset('assets/img/vcard25/qr-code-bg.png') }}" alt="qr-bg-img" loading="lazy"/>
                        </div>
                        <div class="qr-profile-img">
                            <img src="{{ $vcard->profile_url }} " class="w-100 h-100 object-fit-cover" loading="lazy"/>
                        </div>
                        <div class="qr-code-img mx-auto" id="qr-code-twentyfive">
                            @if (isset($customQrCode['applySetting']) && $customQrCode['applySetting'] == 1)
                                {!! QrCode::color(
                                    $qrcodeColor['qrcodeColor']->red(),
                                    $qrcodeColor['qrcodeColor']->green(),
                                    $qrcodeColor['qrcodeColor']->blue(),
                                )->backgroundColor(
                                        $qrcodeColor['background_color']->red(),
                                        $qrcodeColor['background_color']->green(),
                                        $qrcodeColor['background_color']->blue(),
                                    )->style($customQrCode['style'])->eye($customQrCode['eye_style'])->size(130)->format('svg')->generate(Request::url()) !!}
                            @else
                                {!! QrCode::size(130)->format('svg')->generate(Request::url()) !!}
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            {{-- iframe --}}
            @if ((isset($managesection) && $managesection['iframe']) || empty($managesection))
                @if (checkFeature('iframes') && $vcard->iframes->count())
                    <div class="blog-section pt-40 pb-40 mb-4">
                        <div class="section-heading text-center">
                            <h2 class="mb-3">
                                {{ __('messages.vcard.iframe') }}
                            </h2>
                        </div>
                        <div class="iframe-slider">
                            @foreach ($vcard->iframes as $iframe)
                                <div class="slide p-3">
                                    <div class="iframe-card">
                                        <div class="overlay">
                                            <iframe src="{{ $iframe->url }}" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                allowfullscreen width="100%" height="400">
                                            </iframe>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
            {{-- inquiries --}}
            @php
                $currentSubs = $vcard
                    ->subscriptions()
                    ->where('status', \App\Models\Subscription::ACTIVE)
                    ->latest()
                    ->first();
            @endphp
            @if ($currentSubs && $currentSubs->plan->planFeature->enquiry_form && $vcard->enable_enquiry_form)
                <div class="contact-us-section pt-30 px-30 position-relative">
                    <div class="contact-bg-img">
                        <img src="{{ asset('assets/img/vcard25/contact-bg.png') }}" loading="lazy"/>
                    </div>
                    <div class="section-heading text-center mb-40">
                        <h2 class="mb-0">{{ __('messages.contact_us.inquries') }}</h2>
                    </div>
                    <div class="contact-form">
                        <form action="" id="enquiryForm">
                            @csrf
                            <div class="row">
                                <div id="enquiryError" class="alert alert-danger d-none"></div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label
                                            class="mb-1 fs-16 fw-5">{{ __('messages.sadmin_dashboard.name') }}</label>
                                       <input type="text" class="form-control" name="name" placeholder="{{ __('messages.form.your_name') }}"
       pattern="[A-Za-z]+" title="{{ __('The :attribute must contain only alphabetical characters.', ['attribute' => __('messages.form.your_name')]) }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="mb-1 fs-16 fw-5">{{ __('messages.user.email') }}</label>
                                        <input type="email" class="form-control" name="email"
                                            placeholder="{{ __('messages.form.your_email') }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="mb-1 fs-16 fw-5">{{ __('messages.user.phone') }}</label>
                                      <input type="tel" class="form-control" name="phone" placeholder="{{ __('messages.form.phone') }}"
 pattern="[0-9+]*"  title="{{ __('The :attribute must contain only numbers.', ['attribute' => __('messages.form.phone')]) }}" />

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="mb-1 fs-16 fw-5">{{ __('messages.user.your_message') }}</label>
                                        <textarea class="form-control h-100" name="message" placeholder="{{ __('messages.form.type_message') }}"
                                            rows="4"></textarea>
                                    </div>
                                </div>
                                @if (!empty($vcard->privacy_policy) || !empty($vcard->term_condition))
                                    <div class="col-12 mb-4">
                                        <input type="checkbox" name="terms_condition"
                                            class="form-check-input terms-condition" id="termConditionCheckbox"
                                            placeholder>&nbsp;
                                        <label class="form-check-label" for="privacyPolicyCheckbox">
                                            <span class="text-dark">{{ __('messages.vcard.agree_to_our') }}</span>
                                            <a href="{{ route('vcard.show-privacy-policy', [$vcard->url_alias, $vcard->id]) }}"
                                                target="_blank"
                                                class="text-decoration-none link-info fs-6">{!! __('messages.vcard.term_and_condition') !!}</a>
                                            <span class="text-dark">&</span>
                                            <a href="{{ route('vcard.show-privacy-policy', [$vcard->url_alias, $vcard->id]) }}"
                                                target="_blank"
                                                class="text-decoration-none link-info fs-6">{{ __('messages.vcard.privacy_policy') }}</a>
                                        </label>
                                    </div>
                                @endif
                                <div class="col-12 text-center mt-3 mb-5 pb-2">
                                    <button class="send-btn btn btn-primary rounded-2 w-100" type="submit">
                                        {{ __('messages.contact_us.send_message') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
            {{-- create your vcard --}}
            @if (!empty($userSetting['enable_affiliation']))
                <div class="create-vcard-section pt-100">
                    <div class="create-vcard-img1">
                        <img src="{{ asset('assets/img/vcard25/create-vcard-img1.png') }}" alt="create-vcard-img" loading="lazy"/>
                    </div>
                    <div class="create-vcard-img2 text-end">
                        <img src="{{ asset('assets/img/vcard25/create-vcard-img2.png') }}" alt="create-vcard-img" loading="lazy"/>
                    </div>
                    <div class="bg-light pt-60 px-30">
                        <div class="section-heading text-center mb-40">
                            <h2 class="mb-0">{{ __('messages.create_vcard') }}</h2>
                        </div>
                        <div class="px-sm-3 pb-30 mb-4">
                            <div class="vcard-link-card card">
                                <div class="d-flex align-items-center justify-content-center">
                                    <a href="{{ route('register', ['referral-code' => $vcard->user->affiliate_code]) }}"
                                        class="text-secondary link-text fw-5">{{ route('register', ['referral-code' => $vcard->user->affiliate_code]) }}</a>
                                    <i class="icon fa-solid fa-arrow-up-right-from-square ms-3 text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            {{-- map --}}
            @if ((isset($managesection) && $managesection['map']) || empty($managesection))
                <div class="container">
                    <div class="d-flex  flex-column justify-content-center mt-2 mb-sm-5">
                        @if ($vcard->location_url && isset($url[5]))
                            <div class="m-2 mb-10 mt-0">
                                <iframe width="100%" height="300px"
                                    src='https://maps.google.de/maps?q={{ $url[5] }}/&output=embed'
                                    frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                                    style="border-radius: 10px;">
                                </iframe>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            {{-- add contact --}}
            @if (
                !isset($userSetting['enable_contact']) ||
                    (!$userSetting['enable_contact'] && $userSetting['enable_contact'] != 0) ||
                    $userSetting['enable_contact'] == 1)
                <div class="add-to-contact-section ">
                    <div class="text-center d-flex align-items-center justify-content-center">
                        <a href="{{ route('add-contact', $vcard->id) }}"
                            class="add-contact-btn rounded-2 btn-primary"><i
                                class="fas fa-download fa-address-book"></i>
                            &nbsp;{{ __('messages.setting.add_contact') }}</a>
                    </div>
                </div>
            @endif
            {{-- made by --}}
            <div class="d-flex justify-content-evenly">
                @if (checkFeature('advanced'))
                    @if (checkFeature('advanced')->hide_branding && $vcard->branding == 0)
                        @if ($vcard->made_by)
                            <a @if (!is_null($vcard->made_by_url)) href="{{ $vcard->made_by_url }}" @endif
                                class="text-center text-decoration-none text-dark" target="_blank">
                                <small>{{ __('messages.made_by') }} {{ $vcard->made_by }}</small>
                            </a>
                        @else
                            <div class="text-center">
                                <small class="text-dark">{{ __('messages.made_by') }}
                                    {{ $setting['app_name'] }}</small>
                            </div>
                        @endif
                    @endif
                @else
                    @if ($vcard->made_by)
                        <a @if (!is_null($vcard->made_by_url)) href="{{ $vcard->made_by_url }}" @endif
                            class="text-center text-decoration-none text-dark" target="_blank">
                            <small>{{ __('messages.made_by') }} {{ $vcard->made_by }}</small>
                        </a>
                    @else
                        <div class="text-center">
                            <small class="text-dark">{{ __('messages.made_by') }}
                                {{ $setting['app_name'] }}</small>
                        </div>
                    @endif
                @endif
                @if (!empty($vcard->privacy_policy) || !empty($vcard->term_condition))
                    <div>
                        <a class="text-decoration-none text-dark cursor-pointer terms-policies-btn"
                            href="{{ route('vcard.show-privacy-policy', [$vcard->url_alias, $vcard->id]) }}"><small>{!! __('messages.vcard.term_policy') !!}</small></a>
                    </div>
                @endif
            </div>

            <div class="btn-section cursor-pointer">
                <div class="fixed-btn-section">
                    @if (empty($userSetting['hide_stickybar']))
                        <div class="bars-btn social-services-bars-btn">
                            <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M15.4134 0.540771H22.489C23.572 0.540771 24.4601 1.42891 24.4601 2.51188V9.5875C24.4601 10.6776 23.5731 11.5586 22.489 11.5586H15.4134C14.3222 11.5586 13.4423 10.6787 13.4423 9.5875V2.51188C13.4423 1.42783 14.3233 0.540771 15.4134 0.540771Z"
                                    stroke="white" />
                                <path
                                    d="M2.97143 0.5H8.74589C10.1129 0.5 11.2173 1.6122 11.2173 2.97143V8.74589C11.2173 10.1139 10.1139 11.2173 8.74589 11.2173H2.97143C1.6122 11.2173 0.5 10.1129 0.5 8.74589V2.97143C0.5 1.61328 1.61328 0.5 2.97143 0.5Z"
                                    stroke="white" />
                                <path
                                    d="M2.97143 13.783H8.74589C10.1139 13.783 11.2173 14.8863 11.2173 16.2544V22.0289C11.2173 23.3881 10.1129 24.5003 8.74589 24.5003H2.97143C1.61328 24.5003 0.5 23.387 0.5 22.0289V16.2544C0.5 14.8874 1.6122 13.783 2.97143 13.783Z"
                                    stroke="white" />
                                <path
                                    d="M16.2537 13.783H22.0282C23.3874 13.783 24.4996 14.8874 24.4996 16.2544V22.0289C24.4996 23.387 23.3863 24.5003 22.0282 24.5003H16.2537C14.8867 24.5003 13.7823 23.3881 13.7823 22.0289V16.2544C13.7823 14.8863 14.8856 13.783 16.2537 13.783Z"
                                    stroke="white" />
                            </svg>
                        </div>
                    @endif
                    <div class="sub-btn d-none">
                        <div class="sub-btn-div">
                            @if (isset($userSetting['whatsapp_share']) && $userSetting['whatsapp_share'] == 1)
                                <div class="icon-search-container mb-3" data-ic-class="search-trigger">
                                    <div class="wp-btn">
                                        <i class="fab text-light  fa-whatsapp fa-2x" id="wpIcon"></i>
                                    </div>
                                    <input type="number" class="search-input" id="wpNumber"
                                        data-ic-class="search-input"
                                        placeholder="{{ __('messages.setting.wp_number') }}" />
                                    <div class="share-wp-btn-div">
                                        <a href="javascript:void(0)"
                                            class="vcard25-sticky-btn vcard25-btn-group d-flex justify-content-center text-primary align-items-center rounded-0 text-decoration-none py-1 rounded-pill justify-content share-wp-btn">
                                            <i class="fa-solid fa-paper-plane"></i> </a>
                                    </div>
                                </div>
                            @endif
                            @if (empty($userSetting['hide_stickybar']))
                                <div
                                    class="{{ isset($userSetting['whatsapp_share']) && $userSetting['whatsapp_share'] == 1 ? 'vcard25-btn-group' : 'stickyIcon' }}">
                                    <button type="button"
                                        class="vcard25-btn-group vcard25-share vcard25-sticky-btn mb-3 px-2 py-1"><i
                                            class="fas fa-share-alt fs-4 pt-1"></i></button>
                                    @if (!empty($vcard->enable_download_qr_code))
                                        <a type="button"
                                            class="vcard25-btn-group vcard25-sticky-btn d-flex justify-content-center  align-items-center  px-2 mb-3 py-2"
                                            id="qr-code-btn" download="qr_code.png"><i
                                                class="fa-solid fa-qrcode fs-4 text-primary"></i></a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ((isset($managesection) && $managesection['news_latter_popup']) || empty($managesection))
    <div class="modal fade" id="newsLatterModal" tabindex="-1" aria-labelledby="newsLatterModalLabel" aria-hidden="true">
            <div class="modal-dialog news-modal">
                <div class="modal-content animate-bottom" id="newsLatter-content">
                    <div class="newsmodal-header">
                        <button type="button" class="btn-close text-light position-absolute top-0 end-0" data-bs-dismiss="modal"
                                    aria-label="Close" id="closeNewsLatterModal"></button>
                                <h1 class="newsmodal-title text-center mt-5" id="newsLatterModalLabel"><i class="fa-solid fa-envelope-open-text"></i></h1>
                    </div>
                    <div class="modal-body">
                        <h1 class="content text-center  p-2">{{ __('messages.vcard.subscribe_newslatter') }}</h1>
                        <h3 class="modal-desc text-center">{{ __('messages.vcard.update_directly') }}</h3>
                        <form action="" method="post" id="newsLatterForm">
                            @csrf
                            <input type="hidden" name="vcard_id" value="{{ $vcard->id }}">
                            <div class="input-group mb-3 mt-5">
                                <input type="email" class="form-control bg-dark border-0 text-light" placeholder="{{ __('messages.form.enter_your_email') }}" name="email" id="emailSubscription"
                                        aria-label="Email" aria-describedby="button-addon2">
                                    <button class="btn" type="submit" id="email-send"><i class="fa-regular fa-envelope"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- share modal code --}}
    <div id="vcard25-shareModel" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="">
                    <div class="row align-items-center mt-3">
                        <div class="col-10 text-center">
                            <h5 class="modal-title" style="padding-left: 50px;">
                                {{ __('messages.vcard.share_my_vcard') }}</h5>
                        </div>
                        <div class="col-2 p-0">
                            <button type="button" aria-label="Close"
                                class="btn btn-sm btn-icon btn-active-color-danger border-none"
                                data-bs-dismiss="modal">
                                <span class="svg-icon svg-icon-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)"
                                            fill="#000000">
                                            <rect fill="#000000" x="0" y="7" width="16" height="2"
                                                rx="1" />
                                            <rect fill="#000000" opacity="0.5"
                                                transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)"
                                                x="0" y="7" width="16" height="2" rx="1" />
                                        </g>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                @php
                    $shareUrl = route('vcard.show', ['alias' => $vcard->url_alias]);
                @endphp
                <div class="modal-body">
                    <a href="http://www.facebook.com/sharer.php?u={{ $shareUrl }}" target="_blank"
                        class="text-decoration-none share" title="Facebook">
                        <div class="row">
                            <div class="col-2">
                                <i class="fab fa-facebook fa-2x" style="color: #1B95E0"></i>

                            </div>
                            <div class="col-9 p-1">
                                <p class="align-items-center text-dark fw-bolder">
                                    {{ __('messages.social.Share_on_facebook') }}</p>
                            </div>
                            <div class="col-1 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" height="16px"
                                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                        fill="#000000" stroke="none">
                                        <path
                                            d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="http://twitter.com/share?url={{ $shareUrl }}&text={{ $vcard->name }}&hashtags=sharebuttons"
                        target="_blank" class="text-decoration-none share" title="Twitter">
                        <div class="row">
                            <div class="col-2">

                                <span class="fa-2x"><svg xmlns="http://www.w3.org/2000/svg" height="1em"
                                        viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path
                                            d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z" />
                                    </svg></span>

                            </div>
                            <div class="col-9 p-1">
                                <p class="align-items-center text-dark fw-bolder">
                                    {{ __('messages.social.Share_on_twitter') }}</p>
                            </div>
                            <div class="col-1 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" height="16px"
                                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                        fill="#000000" stroke="none">
                                        <path
                                            d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="http://www.linkedin.com/shareArticle?mini=true&url={{ $shareUrl }}" target="_blank"
                        class="text-decoration-none share" title="Linkedin">
                        <div class="row">
                            <div class="col-2">
                                <i class="fab fa-linkedin fa-2x" style="color: #1B95E0"></i>
                            </div>
                            <div class="col-9 p-1">
                                <p class="align-items-center text-dark fw-bolder">
                                    {{ __('messages.social.Share_on_linkedin') }}</p>
                            </div>
                            <div class="col-1 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" height="16px"
                                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                        fill="#000000" stroke="none">
                                        <path
                                            d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="mailto:?Subject=&Body={{ $shareUrl }}" target="_blank"
                        class="text-decoration-none share" title="Email">
                        <div class="row">
                            <div class="col-2">
                                <i class="fas fa-envelope fa-2x" style="color: #191a19  "></i>
                            </div>
                            <div class="col-9 p-1">
                                <p class="align-items-center text-dark fw-bolder">
                                    {{ __('messages.social.Share_on_email') }}</p>
                            </div>
                            <div class="col-1 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" height="16px"
                                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                        fill="#000000" stroke="none">
                                        <path
                                            d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="http://pinterest.com/pin/create/link/?url={{ $shareUrl }}" target="_blank"
                        class="text-decoration-none share" title="Pinterest">
                        <div class="row">
                            <div class="col-2">
                                <i class="fab fa-pinterest fa-2x" style="color: #bd081c"></i>
                            </div>
                            <div class="col-9 p-1">
                                <p class="align-items-center text-dark fw-bolder">
                                    {{ __('messages.social.Share_on_pinterest') }}</p>
                            </div>
                            <div class="col-1 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" height="16px"
                                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                        fill="#000000" stroke="none">
                                        <path
                                            d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="http://reddit.com/submit?url={{ $shareUrl }}&title={{ $vcard->name }}"
                        target="_blank" class="text-decoration-none share" title="Reddit">
                        <div class="row">
                            <div class="col-2">
                                <i class="fab fa-reddit fa-2x" style="color: #ff4500"></i>
                            </div>
                            <div class="col-9 p-1">
                                <p class="align-items-center text-dark fw-bolder">
                                    {{ __('messages.social.Share_on_reddit') }}</p>
                            </div>
                            <div class="col-1 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" height="16px"
                                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                        fill="#000000" stroke="none">
                                        <path
                                            d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="https://wa.me/?text={{ $shareUrl }}" target="_blank"
                        class="text-decoration-none share" title="Whatsapp">
                        <div class="row">
                            <div class="col-2">
                                <i class="fab fa-whatsapp fa-2x" style="color: limegreen"></i>
                            </div>
                            <div class="col-9 p-1">
                                <p class="align-items-center text-dark fw-bolder">
                                    {{ __('messages.social.Share_on_whatsapp') }}</p>
                            </div>
                            <div class="col-1 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.0" height="16px"
                                    viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                        fill="#000000" stroke="none">
                                        <path
                                            d="M1277 4943 l-177 -178 1102 -1102 1103 -1103 -1103 -1103 -1102 -1102 178 -178 177 -177 1280 1280 1280 1280 -1280 1280 -1280 1280 -178 -177z" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </a>
                    <div class="col-12 justify-content-between social-link-modal">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="{{ request()->fullUrl() }}"
                                disabled>
                            <span id="vcardUrlCopy{{ $vcard->id }}" class="d-none" target="_blank">
                                {{ route('vcard.show', ['alias' => $vcard->url_alias]) }} </span>
                            <button class="copy-vcard-clipboard btn btn-dark" title="Copy Link"
                                data-id="{{ $vcard->id }}">
                                <i class="fa-regular fa-copy fa-2x"></i>
                            </button>
                        </div>
                    </div>
                    <div class="text-center">

                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
@include('vcardTemplates.template.templates')
<script>
    @if (isset(checkFeature('advanced')->custom_js) && $vcard->custom_js)
        {!! $vcard->custom_js !!}
    @endif
</script>
@include('vcardTemplates.template.templates')
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript" src="{{ asset('assets/js/front-third-party.js') }}"></script>
<script type="text/javascript" src="{{ asset('front/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/slider/js/slick.min.js') }}" type="text/javascript"></script>
@php
    $setting = \App\Models\UserSetting::where('user_id', $vcard->tenant->user->id)
        ->where('key', 'stripe_key')
        ->first();
@endphp
<script>
    let stripe = ''
    @if (!empty($setting) && !empty($setting->value))
        stripe = Stripe('{{ $setting->value }}');
    @endif
    $().ready(function() {
        $(".gallery-slider").slick({
            arrows: false,
            infinite: true,
            dots: true,
            slidesToShow: 2,
            autoplay: true,
            responsive: [{
                breakpoint: 575,
                settings: {
                    slidesToShow: 1,
                },
            }, ],
        });
        $(".product-slider").slick({
            arrows: false,
            infinite: true,
            dots: false,
            slidesToShow: 2,
            slidesToScroll: 1,
            autoplay: true,
            responsive: [{
                breakpoint: 575,
                settings: {
                    slidesToShow: 1,
                    dots: true,
                },
            }, ],
        });
        $(".testimonial-slider").slick({
            arrows: true,
            infinite: true,
            dots: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            // prevArrow:
            //   '<button class="slide-arrow prev-arrow"><i class="fa-solid fa-arrow-left"></i></button>',
            // nextArrow:
            //   '<button class="slide-arrow next-arrow"><i class="fa-solid fa-arrow-right"></i></button>',
            responsive: [{
                breakpoint: 575,
                settings: {
                    arrows: false,
                    dots: true,
                },
            }, ],
        });
        $(".blog-slider").slick({
            arrows: false,
            infinite: true,
            dots: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            draggable: true,
            responsive: [{
                breakpoint: 575,
                settings: {
                    slidesToShow: 1,
                    dots: true,
                    vertical: false,
                },
            }, ],
        });
        $(".iframe-slider").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: true,
            speed: 300,
            infinite: true,
            autoplaySpeed: 5000,
            autoplay: false,
            responsive: [{
                    breakpoint: 575,
                    settings: {
                        centerPadding: "125px",
                        dots: true,
                    },
                },
                {
                    breakpoint: 480,
                    settings: {
                        centerPadding: "0",
                        dots: true,
                    },
                },
            ],
        });
    });
</script>
<script>
    let isEdit = false
    let password = "{{ isset(checkFeature('advanced')->password) && !empty($vcard->password) }}"
    let passwordUrl = "{{ route('vcard.password', $vcard->id) }}";
    let enquiryUrl = "{{ route('enquiry.store', ['vcard' => $vcard->id, 'alias' => $vcard->url_alias]) }}";
    let appointmentUrl = "{{ route('appointment.store', ['vcard' => $vcard->id, 'alias' => $vcard->url_alias]) }}";
    let slotUrl = "{{ route('appointment-session-time', $vcard->url_alias) }}";
    let appUrl = "{{ config('app.url') }}";
    let vcardId = {{ $vcard->id }};
    let vcardAlias = "{{ $vcard->url_alias }}";
    let languageChange = "{{ url('language') }}";
    let paypalUrl = "{{ route('paypal.init') }}"
    let lang = "{{ checkLanguageSession($vcard->url_alias) }}";
    let userDateFormate = "{{ getSuperAdminSettingValue('datetime_method') ??  1 }}";
</script>
<script>
    const qrCodeTwentyfive = document.getElementById("qr-code-twentyfive");
    const svg = qrCodeTwentyfive.querySelector("svg");
    const blob = new Blob([svg.outerHTML], {
        type: 'image/svg+xml'
    });
    const url = URL.createObjectURL(blob);
    const image = document.createElement('img');
    image.src = url;
    image.addEventListener('load', () => {
        const canvas = document.createElement('canvas');
        canvas.width = canvas.height = {{ $vcard->qr_code_download_size }};
        const context = canvas.getContext('2d');
        context.drawImage(image, 0, 0, canvas.width, canvas.height);
        const link = document.getElementById('qr-code-btn');
        link.href = canvas.toDataURL();
        URL.revokeObjectURL(url);
    });
</script>
@routes
<script src="{{ asset('messages.js') }}"></script>
<script src="{{ mix('assets/js/custom/helpers.js') }}"></script>
<script src="{{ mix('assets/js/custom/custom.js') }}"></script>
<script src="{{ mix('assets/js/vcards/vcard-view.js') }}"></script>
<script src="{{ mix('assets/js/lightbox.js') }}"></script>
<script src="{{ asset('/sw.js') }}"></script>
<script>
    if ("serviceWorker" in navigator) {
        // Register a service worker hosted at the root of the
        // site using the default scope.
        navigator.serviceWorker.register("/sw.js").then(
            (registration) => {
                console.log("Service worker registration succeeded:", registration);
            },
            (error) => {
                console.error(`Service worker registration failed: ${error}`);
            },
        );
    } else {
        console.error("Service workers are not supported.");
    }
</script>
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" defer></script>


</html>
