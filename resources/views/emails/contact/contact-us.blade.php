@component('mail::message')
# Contact us.

<strong>Subject:</strong> 
{{ $data['subject'] }}

<strong>Message:</strong> 
{{ $data['mailMessege'] }}

From,<br>
{{ $data['email'] }}
@endcomponent