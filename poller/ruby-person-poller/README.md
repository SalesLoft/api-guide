# SalesLoft API Ruby Poller

This example code will poll the SalesLoft API every 6 seconds looking for changes to people.

## Setup

1. `bundle install`
2. Get an access token (either an API Key or Oauth Token)
3. Execute the program using `ACCESS_TOKEN=XXX ruby poller.rb`
4. Make changes to people / add new people in SalesLoft to see the results in the console

## Disclaimer

This code is not production ready. This example demonstrates the concept behind polling and gives an interactive environment to
test locally. A production system ideally has cursor persistence, access token management + refreshing,
and logic to avoid updating the same record continuously.
