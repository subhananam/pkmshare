<!doctype html>
<html lang="en">


<!-- Mirrored from demos.creative-tim.com/material-dashboard-pro/examples/components/panels.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2017 21:33:48 GMT -->

<head>
    <title>@yield('title') | PKM Apps</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" href="{{ asset('vendor/material-dashboard-pro-master/assets/css/font-awesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/material-dashboard-pro-master/assets/css/google-roboto-300-700.css') }}" />
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-active-color="rose" data-background-color="black" data-image="{{ asset('vendor/material-dashboard-pro-master/assets/img/sidebar-1.jpg') }}">
            <!--
        Tip 1: You can change the color of active element of the sidebar using: data-active-color="purple | blue | green | orange | red | rose"
        Tip 2: you can also add an image using data-image tag
        Tip 3: you can change the color of the sidebar with data-background-color="white | black"
    -->
            <div class="logo">
                <a href="#" class="simple-text">
                    PKM Apps
                </a>
            </div>
            <div class="logo logo-mini">
                <a href="#" class="simple-text">
                    PKM
                </a>
            </div>
            <div class="sidebar-wrapper">
                <div class="user">
                    <div class="photo">
                        @if(Auth::user()->role == "Mahasiswa")
                        @if($gender == "Laki-laki")
                        <img src="{{ asset('/assets/img/male_student.png') }}" />
                        @elseif($gender == "Perempuan")
                        <img src="{{ asset('/assets/img/female_student.png') }}" />
                        @endif
                        @else
                        @if($gender == "Laki-laki")
                        <img src="{{ asset('/assets/img/male_teacher.png') }}" />
                        @elseif($gender == "Perempuan")
                        <img src="{{ asset('/assets/img/female_teacher.png') }}" />
                        @endif
                        @endif
                    </div>
                    <div class="info">
                        <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                            {{ Auth::user()->name }}
                            <b class="caret"></b>
                        </a>
                        <div class="collapse" id="collapseExample">
                            <ul class="nav">
                                <li>
                                    @if(Auth::user()->role == "Admin")
                                    <a href="{{ route('admin.profile') }}">My Profile</a>
                                    @elseif(Auth::user()->role == "Mahasiswa")
                                    <a href="{{ route('mahasiswa.profile') }}">My Profile</a>
                                    @elseif(Auth::user()->role == "Pembimbing")
                                    <a href="{{ route('pembimbing.profile') }}">My Profile</a>
                                    @elseif(Auth::user()->role == "Wadir")
                                    <a href="{{ route('wadir.profile') }}">My Profile</a>
                                    @endif
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <ul class="nav">
                    <li class="">
                        <a href="/">
                            <i class="material-icons">dashboard</i>
                            <p>Home</p>
                        </a>
                    </li>
                    @if(Auth::user()->role == "Admin")
                    <li class="@if($title == 'Jenis PKM') {{'active'}} @endif">
                        <a href="{{ route('jenispkm') }}">
                            <i class="material-icons">assignment</i>
                            <p>Jenis PKM</p>
                        </a>
                    </li>
                    <li class="@if($title == 'Kriteria Penilaian') {{'active'}} @endif">
                        <a href="{{ route('kriteria') }}">
                            <i class="material-icons">view_list</i>
                            <p>Kriteria Penilaian</p>
                        </a>
                    </li>
                    <li class="@if($title == 'Tambah User') {{'active'}} @endif">
                        <a href="{{ route('admin.user') }}">
                            <i class="material-icons">person_add</i>
                            <p>Tambah User</p>
                        </a>
                    </li>
                    <li class="@if($title == 'Seleksi Tahap 1') {{'active'}} @endif">
                        <a href="{{ route('admin.seleksi1') }}">
                            <i class="material-icons">assignment</i>
                            <p>Seleksi Tahap 1</p>
                        </a>
                    </li>
                    <li class="@if($title == 'Seleksi Tahap 2') {{'active'}} @endif">
                        <a href="{{ route('admin.seleksi2') }}">
                            <i class="material-icons">assignment</i>
                            <p>Seleksi Tahap 2</p>
                        </a>
                    </li>
                    @elseif(Auth::user()->role == "Mahasiswa")
                    <li class="@if($title == 'Pendaftaran Anggota') {{'active'}} @endif">
                        <a href="{{ route('anggota') }}">
                            <i class="material-icons">person_add</i>
                            <p>Pendaftaran Anggota</p>
                        </a>
                    </li>
                    <li class="@if($title == 'Pendaftaran PKM') {{'active'}} @endif">
                        <a href="{{ route('pkm') }}">
                            <i class="material-icons">assignment</i>
                            <p>Pendaftaran PKM</p>
                        </a>
                    </li>
                    <li class="@if($title == 'Bimbingan') {{'active'}} @endif">
                        <a href="{{ route('mahasiswa.bimbingan') }}">
                            <i class="material-icons">description</i>
                            <p>Bimbingan</p>
                        </a>
                    </li>
                    @elseif(Auth::user()->role == "Pembimbing")
                    <li class="@if($title == 'Penilaian Tahap 1') {{'active'}} @endif">
                        <a href="{{ route('pembimbing.pkm') }}">
                            <i class="material-icons">assignment</i>
                            <p>Penilaian Tahap 1</p>
                        </a>
                    </li>
                    <li class="@if($title == 'Bimbingan') {{'active'}} @endif">
                        <a href="{{ route('pembimbing.bimbingan') }}">
                            <i class="material-icons">description</i>
                            <p>Bimbingan</p>
                        </a>
                    </li>
                    @elseif(Auth::user()->role == "Wadir")
                    <li class="@if($title == 'Daftar PKM') {{'active'}} @endif">
                        <a href="{{ route('wadir') }}">
                            <i class="material-icons">assignment</i>
                            <p>Daftar PKM</p>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-minimize">
                        <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
                            <i class="material-icons visible-on-sidebar-regular">more_vert</i>
                            <i class="material-icons visible-on-sidebar-mini">view_list</i>
                        </button>
                    </div>
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"> Panels </a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">person</i>
                                    <p class="hidden-lg hidden-md">
                                        Profile
                                        <b class="caret"></b>
                                    </p>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        @if(Auth::user()->role == "Admin")
                                        <a href="{{ route('admin.profile') }}">My Profile</a>
                                        @elseif(Auth::user()->role == "Mahasiswa")
                                        <a href="{{ route('mahasiswa.profile') }}">My Profile</a>
                                        @elseif(Auth::user()->role == "Pembimbing")
                                        <a href="{{ route('pembimbing.profile') }}">My Profile</a>
                                        @elseif(Auth::user()->role == "Wadir")
                                        <a href="{{ route('wadir.profile') }}">My Profile</a>
                                        @endif
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            <li class="separator hidden-lg hidden-md"></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">@yield('icon')</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">@yield('panel_name')</h4>
                                    <div class="material-datatables">
                                        @yield('panel')
                                        @yield('table')
                                        @yield('modal')
                                    </div>
                                </div>
                                <!-- end content-->
                            </div>
                            <!--  end card  -->
                        </div>
                        <!-- end col-md-12 -->
                    </div>
                    <!-- end row -->
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <nav class="pull-left">
                        <ul>
                            <li>
                                <a href="#">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Company
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Portfolio
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Blog
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <p class="copyright pull-right">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        <a href="http://www.creative-tim.com/">Creative Tim</a>, made with love for a better web
                    </p>
                </div>
            </footer>
        </div>
    </div>

</body>
<!--   JS Files   -->
<script src="{{ asset('js/main.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/blockUI/jquery.blockUI.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/ckeditor/ckeditor.js') }}" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.card .material-datatables label').addClass('form-group');
        demo.initFormExtendedDatetimepickers();
        var ckeditor_config = {
            toolbar: [{
                    name: 'document',
                    items: ['Print']
                },
                {
                    name: 'clipboard',
                    items: ['Undo', 'Redo']
                },
                {
                    name: 'styles',
                    items: ['Format', 'Font', 'FontSize']
                },
                {
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'CopyFormatting']
                },
                {
                    name: 'colors',
                    items: ['TextColor', 'BGColor']
                },
                {
                    name: 'align',
                    items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
                },
                {
                    name: 'links',
                    items: ['Link', 'Unlink']
                },
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
                },
                {
                    name: 'insert',
                    items: ['Image', 'Table']
                },
                {
                    name: 'tools',
                    items: ['Maximize']
                },
                {
                    name: 'editing',
                    items: ['Scayt']
                }
            ],

            // Since we define all configuration options here, let's instruct CKEditor to not load config.js which it does by default.
            // One HTTP request less will result in a faster startup time.
            // For more information check https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html#cfg-customConfig
            customConfig: '',

            // Sometimes applications that convert HTML to PDF prefer setting image width through attributes instead of CSS styles.
            // For more information check:
            //  - About Advanced Content Filter: https://ckeditor.com/docs/ckeditor4/latest/guide/dev_advanced_content_filter.html
            //  - About Disallowed Content: https://ckeditor.com/docs/ckeditor4/latest/guide/dev_disallowed_content.html
            //  - About Allowed Content: https://ckeditor.com/docs/ckeditor4/latest/guide/dev_allowed_content_rules.html
            disallowedContent: 'img{width,height,float}',
            extraAllowedContent: 'img[width,height,align]',

            // Enabling extra plugins, available in the full-all preset: https://ckeditor.com/cke4/presets-all
            //extraPlugins: 'tableresize,uploadimage,uploadfile',
            extraPlugins: 'uploadimage',

            /*********************** File management support ***********************/
            // In order to turn on support for file uploads, CKEditor has to be configured to use some server side
            // solution with file upload/management capabilities, like for example CKFinder.
            // For more information see https://ckeditor.com/docs/ckeditor4/latest/guide/dev_ckfinder_integration.html

            // Uncomment and correct these lines after you setup your local CKFinder instance.
            // filebrowserBrowseUrl: 'http://example.com/ckfinder/ckfinder.html',
            // filebrowserUploadUrl: 'http://example.com/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            /*********************** File management support ***********************/

            // Make the editing area bigger than default.
            height: 800,

            // An array of stylesheets to style the WYSIWYG area.
            // Note: it is recommended to keep your own styles in a separate file in order to make future updates painless.
            //contentsCss: ['{{ asset("/vendor/ckeditor/contents.css") }}', '{{ asset("/vendor/ckeditor/document-editor.css") }}'],

            // This is optional, but will let us define multiple different styles for multiple editors using the same CSS file.
            bodyClass: 'document-editor',

            // Reduce the list of block elements listed in the Format dropdown to the most commonly used.
            format_tags: 'p;h1;h2;h3;pre',

            // Simplify the Image and Link dialog windows. The "Advanced" tab is not needed in most cases.
            removeDialogTabs: 'image:advanced;link:advanced',

            // Define the list of styles which should be available in the Styles dropdown list.
            // If the "class" attribute is used to style an element, make sure to define the style for the class in "mystyles.css"
            // (and on your website so that it rendered in the same way).
            // Note: by default CKEditor looks for styles.js file. Defining stylesSet inline (as below) stops CKEditor from loading
            // that file, which means one HTTP request less (and a faster startup).
            // For more information see https://ckeditor.com/docs/ckeditor4/latest/features/styles.html
            stylesSet: [
                /* Inline Styles */
                {
                    name: 'Marker',
                    element: 'span',
                    attributes: {
                        'class': 'marker'
                    }
                },
                {
                    name: 'Cited Work',
                    element: 'cite'
                },
                {
                    name: 'Inline Quotation',
                    element: 'q'
                },

                /* Object Styles */
                {
                    name: 'Special Container',
                    element: 'div',
                    styles: {
                        padding: '5px 10px',
                        background: '#eee',
                        border: '1px solid #ccc'
                    }
                },
                {
                    name: 'Compact table',
                    element: 'table',
                    attributes: {
                        cellpadding: '5',
                        cellspacing: '0',
                        border: '1',
                        bordercolor: '#ccc'
                    },
                    styles: {
                        'border-collapse': 'collapse'
                    }
                },
                {
                    name: 'Borderless Table',
                    element: 'table',
                    styles: {
                        'border-style': 'hidden',
                        'background-color': '#E6E6FA'
                    }
                },
                {
                    name: 'Square Bulleted List',
                    element: 'ul',
                    styles: {
                        'list-style-type': 'square'
                    }
                }
            ]
        };
    });
</script>
@yield('script')
<!-- Mirrored from demos.creative-tim.com/material-dashboard-pro/examples/components/panels.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Mar 2017 21:33:48 GMT -->

</html>