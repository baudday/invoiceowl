<?php

function active_tab($route_name)
{
  return \Request::route()->getName() == $route_name ? 'active' : '';
}

function address(App\Address $address)
{
  $items = array_filter(array_only($address->toArray(), [
    'line_one', 'line_two', 'city', 'state', 'zip', 'country'
  ]));
  $ret = implode("<br />", array_only($items, [
    'line_one', 'line_two', 'city'
  ]));

  if ($address->state) $ret .=  ", " . $address->state;
  if ($address->zip) $ret .= " " . $address->zip;
  if ($address->country) $ret .=  "<br />" . $address->country;

  return $ret . "<br />";
}
