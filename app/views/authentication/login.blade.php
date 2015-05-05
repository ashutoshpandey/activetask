<html>
<head>
    @include('includes.common-css')

    @include('includes.common-top-js')
    {{HTML::script(asset("/public/js/site/user/login.js"))}}
</head>

<body>

<!--main content start-->
<section id="main-content">
    <section class="wrapper">

        <div class="row">

            <form id='frmlogin'>
                <div class='form-row'>
                    <label>Email</label>
                    <input type='text' name='email'/>
                </div>

                <div class='form-row date'>
                    <label>Password</label>
                    <input type='password' name='password'/>
                </div>

                <div class='form-row'>
                    <label>&nbsp;</label>
                    <input type='button' name='btnlogin' value='Login'/>
                </div>

                <div class='form-row message'></div>

            </form>

        </div>

    </section>
</section>

</body>
</html>