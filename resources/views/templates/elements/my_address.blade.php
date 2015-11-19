@if (\Auth::user()->address)
{!! address(\Auth::user()->address) !!}
@endif
