<?php

namespace Controller;

function getJson()
{
  $inputJSON = file_get_contents('php://input');

  return json_decode($inputJSON, true);
}

function parseMysqlDataToJson($result)
{
  $data = array();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $data[] = $row;
    }
  }

  return $data;
}
