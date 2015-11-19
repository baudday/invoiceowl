@foreach($invoice->lineItems as $item)
{% yield('line_items') %}
@endforeach
