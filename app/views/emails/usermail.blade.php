<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
        <div>
            <p>Dear {{$user->first_name}} {{$user->last_name}}</p>
            <p>
                Welcome to Active Task. Please click on the link below to activate your account
                <br/><br/>

                Your email is : {{$user->email}} <br/><br/>
                Your password is : {{$user->password}} <br/><br/>

                {{$root}}/activate-account/{{$user->activation_link}}
            </p>
            <p>
                Best wishes,<br>
                The Active Task Team
            </p>
		</div>
	</body>
</html>