<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Responsive Admin Dashboard Template">
        <meta name="keywords" content="admin,dashboard">
        <meta name="author" content="stacks">
        <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        
        <!-- Title -->
        <title>PMPC - File System</title>

        <!-- Styles -->
        {{-- <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900&display=swap" rel="stylesheet"> --}}

        
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="{{ asset('lime/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('lime/assets/plugins/font-awesome/css/all.min.css') }}" rel="stylesheet">
      
        <!-- Theme Styles -->
        <link href="{{ asset('lime/assets/css/lime.min.css') }}" rel="stylesheet">
        <link href="{{ asset('lime/assets/css/custom.css') }}" rel="stylesheet">

        <style>
            /* devanagari */
            @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: url({{ asset("lime/assets/fonts/pxiByp8kv8JHgFVrLDz8Z11lFc-K.woff2") }}) format('woff2');
            /* unicode-range: U+0900-097F, U+1CD0-1CF6, U+1CF8-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FB; */
            }
            /* latin-ext */
            @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: url({{ asset('lime/assets/fonts/pxiByp8kv8JHgFVrLDz8Z1JlFc-K.woff2') }}) format('woff2');
            /* unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF; */
            }
            /* latin */
            @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: url({{ asset('lime/assets/fonts/pxiByp8kv8JHgFVrLDz8Z1xlFQ.woff2') }}) format('woff2');
            /* unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD; */
            }
            /* devanagari */
            @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url({{ asset('lime/assets/fonts/pxiEyp8kv8JHgFVrJJbecmNE.woff2') }}) format('woff2');
            /* unicode-range: U+0900-097F, U+1CD0-1CF6, U+1CF8-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FB; */
            }
            /* latin-ext */
            @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url({{ asset('lime/assets/fonts/pxiEyp8kv8JHgFVrJJnecmNE.woff2') }}) format('woff2');
            /* unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF; */
            }
            /* latin */
            @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url({{ asset('lime/assets/fonts/pxiEyp8kv8JHgFVrJJfecg.woff2') }}) format('woff2');
            /* unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD; */
            }
            /* devanagari */
            @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url({{ asset('lime/assets/fonts/pxiByp8kv8JHgFVrLGT9Z11lFc-K.woff2') }}) format('woff2');
            /* unicode-range: U+0900-097F, U+1CD0-1CF6, U+1CF8-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FB; */
            }
            /* latin-ext */
            @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url({{ asset('lime/assets/fonts/pxiByp8kv8JHgFVrLGT9Z1JlFc-K.woff2') }}) format('woff2');
            /* unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF; */
            }
            /* latin */
            @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url({{ asset('lime/assets/fonts/pxiByp8kv8JHgFVrLGT9Z1xlFQ.woff2') }}) format('woff2');
            /* unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD; */
            }
            /* devanagari */
            @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url({{ asset('lime/assets/fonts/pxiByp8kv8JHgFVrLEj6Z11lFc-K.woff2') }}) format('woff2');
            /* unicode-range: U+0900-097F, U+1CD0-1CF6, U+1CF8-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FB; */
            }
            /* latin-ext */
            @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url({{ asset('lime/assets/fonts/pxiByp8kv8JHgFVrLEj6Z1JlFc-K.woff2') }}) format('woff2');
            /* unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF; */
            }
            /* latin */
            @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url({{ asset('lime/assets/fonts/pxiByp8kv8JHgFVrLEj6Z1xlFQ.woff2') }}) format('woff2');
            /* unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD; */
            }
            /* devanagari */
            @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url({{ asset('lime/assets/fonts/pxiByp8kv8JHgFVrLCz7Z11lFc-K.woff2') }}) format('woff2');
            /* unicode-range: U+0900-097F, U+1CD0-1CF6, U+1CF8-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FB; */
            }
            /* latin-ext */
            @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url({{ asset('lime/assets/fonts/pxiByp8kv8JHgFVrLCz7Z1JlFc-K.woff2') }}) format('woff2');
            /* unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF; */
            }
            /* latin */
            @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url({{ asset('lime/assets/fonts/pxiByp8kv8JHgFVrLCz7Z1xlFQ.woff2') }}) format('woff2');
            /* unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD; */
            }
            /* devanagari */
            @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 800;
            font-display: swap;
            src: url({{ asset('lime/assets/fonts/pxiByp8kv8JHgFVrLDD4Z11lFc-K.woff2') }}) format('woff2');
            /* unicode-range: U+0900-097F, U+1CD0-1CF6, U+1CF8-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FB; */
            }
            /* latin-ext */
            @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 800;
            font-display: swap;
            src: url({{ asset('lime/assets/fonts/pxiByp8kv8JHgFVrLDD4Z1JlFc-K.woff2') }}) format('woff2');
            /* unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF; */
            }
            /* latin */
            @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 800;
            font-display: swap;
            src: url({{ asset('lime/assets/fonts/pxiByp8kv8JHgFVrLDD4Z1xlFQ.woff2') }}) format('woff2');
            /* unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD; */
            }
            /* devanagari */
            @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 900;
            font-display: swap;
            src: url({{ asset('lime/assets/fonts/pxiByp8kv8JHgFVrLBT5Z11lFc-K.woff2') }}) format('woff2');
            /* unicode-range: U+0900-097F, U+1CD0-1CF6, U+1CF8-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FB; */
            }
            /* latin-ext */
            @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 900;
            font-display: swap;
            src: url({{ asset('lime/assets/fonts/pxiByp8kv8JHgFVrLBT5Z1JlFc-K.woff2') }}) format('woff2');
            /* unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF; */
            }
            /* latin */
            @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 900;
            font-display: swap;
            src: url({{ asset('lime/assets/fonts/pxiByp8kv8JHgFVrLBT5Z1xlFQ.woff2') }}) format('woff2');
            /* unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD; */
            }

        </style>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class='loader'>
            <div class='spinner-grow text-primary' role='status'>
                <span class='sr-only'>Loading...</span>
            </div>
        </div>

        
        <div class="lime-header">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="#">PMPC | File System</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="material-icons">keyboard_arrow_down</i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <form class="form-inline my-2 my-lg-0 search" id="search">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search for projects, apps, pages..." aria-label="Search">
                    </form>
                    <ul class="navbar-nav ml-auto">
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }} <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a class="dropdown-item" href="#">Dashboard</a></li>
                                <li><a class="dropdown-item" href="#">Account</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li class="divider"></li>
                                <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <li><a class="dropdown-item text-danger" href="#" onclick="event.preventDefault();
                                    this.closest('form').submit();">Log Out</a></li>
                                </form>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="search-results">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="search-results-header">
                            <h4>Search Results</h4>
                            <a href="#" id="closeSearch"><i class="material-icons">close</i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <ul class="search-result-list article-search">
                            <li>
                                <p>Lorem ipsum dolor sit amet, consectetur <span class="search-input-value"></span> adipiscing elit, sunt in culpa quifdaasd quis.</p>
                                <span class="search-article-date">06 Dec, 2018</span>
                            </li>
                            <li>
                                <p>Duis non semper sapien. Morbi imperdiet velit in <span class="search-input-value"></span> bibendum lobortis. Integer arcu urna, elementum in pellentesque nec, finibus at nisi.</p>
                                <span class="search-article-date">19 Nov, 2017</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="lime-container">
            <div class="lime-body">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            <div class="lime-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <span class="footer-text">2022 © PMPC Filesystem</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <!-- Javascripts -->
        <script src="{{ asset('lime/assets/plugins/jquery/jquery-3.1.0.min.js') }}"></script>
        <script src="{{ asset('lime/assets/plugins/bootstrap/popper.min.js') }}"></script>
        <script src="{{ asset('lime/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('lime/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ asset('lime/assets/js/lime.min.js') }}"></script>
    </body>
</html>