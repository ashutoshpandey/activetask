<html>
<head>
    @include('includes.common-css')
    {{HTML::style(asset("/public/css/jquery.dataTables.css"))}}

    @include('includes.common-top-js')

    {{HTML::script(asset("/public/js/jquery.dataTables.min.js"))}}
    {{HTML::script(asset("/public/js/site/group/all.js"))}}
</head>

<body>

@include('includes.user-menu')

<!--main content start-->
<section id="main-content">
    <section class="wrapper">

        <div class="row">

            <form id='frmcreate'>
                <div class='form-row'>
                    <label>Name</label>
                    <input type='text' name='name'/>
                </div>

                <div class='form-row'>
                    <label>&nbsp;</label>
                    <input type='button' name='btncreate' value='Create group'/>
                </div>

                <div class='form-row message'></div>

            </form>

        </div>

        <div class='row'>
            <div id='group-list'></div>
        </div>

    </section>
</section>

</body>
</html>