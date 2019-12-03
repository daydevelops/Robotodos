@component('mail::message')
<strong>{{$article->subtitle}}</strong>

Check out our latest article: {{$article->title}}

@component('mail::button', ['url' => $url])
Continue Reading
@endcomponent

Cheers,<br>
{{ config('app.name') }}
@endcomponent
