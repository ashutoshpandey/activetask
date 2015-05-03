<html>
<head>
    @include('includes.common-css')
    {{HTML::script(asset("/public/js/site/task/create.js"))}}
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
                    <label>Task type</label>
                    <input type='radio' name='task_type' value='fixed' checked='checked'/> Within time
                    <input type='radio' name='task_type' value='no-time'/> No time
                </div>

                <div class='form-row'>
                    <label>Others can add items</label>
                    <input type='radio' name='others_can_add' value='n' checked='checked'/> No
                    <input type='radio' name='others_can_add' value='y'/> Yes
                </div>

                <div class='form-row'>
                    <label>Description</label>
                    <textarea name='description' form-rows='4'></textarea>
                </div>

                <div class='form-row date'>
                    <label>Start date</label>
                    <input type='text' name='start_date'/>
                </div>

                <div class='form-row date'>
                    <label>End date</label>
                    <input type='text' name='end_date'/>
                </div>

                <div class='form-row'>
                    <label>&nbsp;</label>
                    <input type='button' name='btncreate' value='Create task'/>
                </div>

                <div class='form-row message'></div>

            </form>

        </div>

    </section>
</section>

</body>
</html>