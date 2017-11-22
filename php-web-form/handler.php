<?php

define("SALESLOFT_API_BASE", "https://api.salesloft.com/v2");
define("SALESLOFT_API_KEY", $_ENV["API_KEY"]);
define("SALESLOFT_CADENCE_ID", $_ENV["CADENCE_ID"]);

function postData($url, $data) {
  $postvars = http_build_query($data);
  $options = array(
    CURLOPT_URL => $url,
    CURLOPT_POST => count($data),
    CURLOPT_POSTFIELDS => $postvars,
    CURLOPT_HTTPHEADER => array("Authorization: Bearer " . SALESLOFT_API_KEY),
    CURLOPT_RETURNTRANSFER => true,
  );

  $ch = curl_init();
  curl_setopt_array($ch, $options);
  $result = curl_exec($ch);
  curl_close($ch);

  return json_decode($result, true);
}

$personData = array(
  "first_name" => $_POST["first_name"], // optional
  "last_name" => $_POST["last_name"], // optional
  "email_address" => $_POST["email_address"] //required
);

// https://developers.salesloft.com/#!/People/post_v2_people_json
$createdPerson = postData(SALESLOFT_API_BASE . "/people.json", $personData);

if (array_key_exists("data", $createdPerson)) {
  $personId = $createdPerson["data"]["id"];

  // https://developers.salesloft.com/#!/Cadence_Memberships/post_v2_cadence_memberships_json
  $addedToCadence = postData(SALESLOFT_API_BASE . "/cadence_memberships.json", array("person_id" => $personId, "cadence_id" => SALESLOFT_CADENCE_ID));

  header('Location: /?person_id=' . $personId . "&cadence_id=" . SALESLOFT_CADENCE_ID);
} else {
  header('Location: /?err=Creating Person');
}
