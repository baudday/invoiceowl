<?php

function active_tab($route_name)
{
  return \Request::route()->getName() == $route_name ? 'active' : '';
}
