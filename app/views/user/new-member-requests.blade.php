<html>

<head>
    @include('includes.common-css')
    {{HTML::style(asset("/public/css/jquery.dataTables.css"))}}

    @include('includes.common-top-js')
    {{HTML::script(asset("/public/js/jquery.dataTables.min.js"))}}
    {{HTML::script(asset("/public/js/site/user/new-member-requests.js"))}}
</head>

<body>

@include('includes.user-menu')

<!--main content start-->
<section id="main-content">
    <section class="wrapper">

        <div class="row">

            <div id='requestlist'></div>

        </div>

    </section>
</section>

</body>

</html>