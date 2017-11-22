# PHP Web Form Handling

Marketing sites have long been using PHP to serve up content and process web forms. An important
part of a marketing site is taking these inbound leads and placing them in CRMs or tools to be
acted on quickly. The SalesLoft API allows your team to place your web leads in
SalesLoft as people, and even add them to a cadence to be handled quickly.

## PHP Handler

index.php provides a very barebones web handler. The web form (index.php) will submit the first name,
last name, and email address of the lead. The lead is then processed through the handler, creating a
person in SalesLoft and then adding that person to a cadence.

The key areas of this code are the cURL requests to post data to the API:

```
// https://developers.salesloft.com/#!/People/post_v2_people_json
$createdPerson = postData(SALESLOFT_API_BASE . "/people.json", $personData);
```

and

```
// https://developers.salesloft.com/#!/Cadence_Memberships/post_v2_cadence_memberships_json
$addedToCadence = postData(SALESLOFT_API_BASE . "/cadence_memberships.json", array("person_id" => $personId, "cadence_id" => SALESLOFT_CADENCE_ID));
```

These requests have a few things going on for them that you'll need to make sure you include:

* API_KEY - This API key would be generated specifically for your team, and should generally be from a higher permission account,
            depending on your use case. For instance, if you would like to add to a cadence on behalf of different users on the team,
            the authenticated account must be an admin.
* CADENCE_ID - There is a lot that you could do with what cadence to add to. The simplest way is to have a single cadence that you are
               adding to from a form. However, you could have multiple cadences per multiple forms, or even multiple cadences for a single
               form and run A/B tests on them.

## Additional Ideas

You really could do a lot with your web forms + SalesLoft integrated together. Projects like
round-robin inbound leads, web form -> SFDC lead / contact, or even just a simple submission
are all possible. If you have a use case but don't know how you would achieve it, please feel free
to reach out to our support team who can help with your request.
