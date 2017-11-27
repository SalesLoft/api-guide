# SalesLoft API - PHP Web Form Handler

This guide will look at how a PHP web form might be handled to add a person to the SalesLoft
platform, and then add the newly created person to a specific inbound cadence. PHP is chosen
as it is a very common language for marketing sites to be implemented in.

## Setup

1. Generate an API key at https://accounts.salesloft.com/api_keys/new, or use an existing key. Treat this
   key like you would a password.
2. Create a cadence at https://app.salesloft.com/app/cadences_v2/new with a step on it, or use an existing cadence.
   Use the cadence id in the URL in order to know which cadence to add to.
3. `CADENCE_ID=FROM_APP API_KEY=FROM_ACCOUNTS_SALESLOFT_COM php -d variables_order=EGPCS -S localhost:5001`
4. Visit localhost:5001 and hit "submit"
5. View the created person in the application using the provided link. The person will be on the specified cadence.

## Disclaimer

The PHP code here is not production ready. Ideally, you will want more robust error handling and you may want
to implement functionality such as assigning to different users on the team.
