<html>

<head>
    @include('includes.common-css')
    {{HTML::style(asset("/public/css/jquery.dataTables.css"))}}

    @include('includes.common-top-js')
    {{HTML::script(asset("/public/js/jquery.dataTables.min.js"))}}
    {{HTML::script(asset("/public/js/site/task/task-items.js"))}}
</head>

<body>

@include('includes.user-menu')

<section id="main-content">
    <section class="wrapper">

        <div class="row">

            <form id='frmTaskItem'>

                <div class='form-row'>
                    <label>Assigned To</label>
                    <input type='radio' name='assigned_to' value='self' checked='checked'/> Self &nbsp;&nbsp;&nbsp;
                    <input type='radio' name='assigned_to' value='user'/> User &nbsp;&nbsp;&nbsp;
                    <input type='radio' name='assigned_to' value='name'/> Enter name
                </div>

                <div class='form-row assigned-to-user'>
                    <label>Choose</label>
                    <select name='user'>
                        <option>Hi</option>
                    </select>
                </div>

                <div class='form-row assigned-to-name'>
                    <label>Name</label>
                    <input type='text' name='name'/>
                </div>

                <div class='form-row'>
                    <label>Content</label>
                    <textarea name='content' form-rows='4'></textarea>
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
                    <input type='button' name='btnAddTaskItem' value='Add task item'/>
                </div>

                <div class='form-row message'></div>

            </form>

        </div>

        <div class='row'>
            <div id='task-items-list'></div>
        </div>

    </section>
</section>
</body>

</html>