Hello { {$user->first_name} }! 

You have been registred on FEIBOX portal. </br>


Please verify your e-mail by clicking on this <a href="{{ route('account.verify', ['token' => $user->registration_token]) }}"> link </a>.</br>
Or copy this link to your browser.</br>
{{ route('account.verify', ['token' => $user->registration_token]) }}

