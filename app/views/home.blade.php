<html>
<head>
    @include('includes.common-css')

    @include('includes.common-top-js')
    {{HTML::script(asset("/public/js/site/task/create.js"))}}
</head>

<body>

@include('includes.user-menu')

<!--main content start-->
<section id="main-content">
    <section class="wrapper">

        <a href='login'>Login</a>

    </section>
</section>

</body>
</html>