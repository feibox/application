Hello {{ $user->first_name }}!

You have been registered on Feibox portal. <br>

Please verify your e-mail by clicking on this <a href="{{ route('account.verify', ['token' => $user->registration_token]) }}"> link</a>.<br>
Or copy && paste following link to your browser: <br>
{{ route('account.verify', ['token' => $user->registration_token]) }}

Meanwhile, Feibox is setting up your profile (grabbing data from stuba.sk)...