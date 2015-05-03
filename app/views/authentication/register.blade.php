<html>
<head>
    @include('includes.common-css')
    @include('includes.common-top-js')
    {{HTML::script(asset("/public/js/site/user/register.js"))}}
</head>

<body>

<section id="main-content">
    <section class="wrapper">

        <div class="row">

            <form id='frmregister'>

                <div class='row'>
                    <label>First name</label>
                    <input type='text' name='first_name'/>
                </div>

                <div class='row'>
                    <label>Last name</label>
                    <input type='text' name='last_name'/>
                </div>

                <div class='row'>
                    <label>Display name</label>
                    <input type='text' name='display_name'/>
                </div>

                <div class='row'>
                    <label>Email</label>
                    <input type='email' name='email'/>
                </div>

                <div class='row'>
                    <label>Password</label>
                    <input type='password' name='password'/>
                </div>

                <div class='row'>
                    <label>Confirm Password</label>
                    <input type='password' name='confirm_password'/>
                </div>

                <div class='row'>
                    <label>Gender</label>
                    <input type='radio' name='gender' value='male' checked='checked'/> Male &nbsp;&nbsp;
                    <input type='radio' name='gender' value='female'/> Female
                </div>

                <div class='row'>
                    <label>Country</label>
                    <select name='country'>
                        <option>India</option>
                    </select>
                </div>

                <div class='row'>
                    <label>&nbsp;</label>
                    <input type='button' name='btnregister' value='Register'/>
                </div>

                <div class='row message'></div>

            </form>

        </div>

    </section>
</section>

</body>
</html>