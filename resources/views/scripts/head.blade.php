<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>
    @if(isset($title))
        {{ $title }} -
    @endif
    {{ trans('gottashit.site_name') }}
</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ mix('/css/gottashit.css') }}" rel="stylesheet">


