<html>

<head>
    @include('includes.common-css')
    {{HTML::script(asset("/public/js/task/all.js"))}}
</head>

<body>

@include('includes.user-menu')

<!--main content start-->
<section id="main-content">
    <section class="wrapper">

        <div class="row">

            <div id='tasklist'></div>

        </div>

    </section>
</section>

</body>

</html>