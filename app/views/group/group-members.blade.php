<html>
<head>
    @include('includes.common-css')
    {{HTML::style(asset("/public/css/jquery.dataTables.css"))}}

    @include('includes.common-top-js')

    {{HTML::script(asset("/public/js/jquery.dataTables.min.js"))}}
    {{HTML::script(asset("/public/js/site/group/group-members.js"))}}
</head>

<body>

@include('includes.user-menu')

<!--main content start-->
<section id="main-content">
    <section class="wrapper">

        <div class='row'>

            <div class='form-row'>
                <label>Enter email id</label>
                <input type='text' name='email'/>
                <input type='button' name='btnFind' value='Find'/>
            </div>

        </div>

        <div class='row findResult'></div>

        <div class='row'>
            <div id='group-member-list'></div>
        </div>

    </section>
</section>

</body>
</html>