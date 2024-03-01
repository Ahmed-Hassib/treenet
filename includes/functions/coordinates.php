<?php

function validateLatLong($latitude, $longitude)
{
  $latitudeRegex = "/^[-]?(([0-8]?[0-9])(\.(\d{1,}))?)|(90(\.0{1,}))?$/";
  $longitudeRegex = "/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))(\.(\d{1,}))?)|(180(\.0{1,})))?$/";

  if (preg_match($latitudeRegex, $latitude) && preg_match($longitudeRegex, $longitude)) {
    return true;
  }
  return false;
}