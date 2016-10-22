This is an email send after registration.

{{ route('account.verify', ['token' => $user->registration_token]) }}