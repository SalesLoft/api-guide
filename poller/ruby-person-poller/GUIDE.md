# Efficient Polling

Getting changes to your SalesLoft data, as the changes occur, is crucial for codifying business processes. The SalesLoft API is designed to provide changes through an efficient polling mechanism. Let's look at why we at SalesLoft have exposed our change data through polling rather than a webhook based system:

* Changes can be received quickly after they happen, within seconds or minutes depending on your needs.
* Changes are not delayed by events on the SalesLoft servers
* Changes are processed predictably, a spike in traffic is not going to overload your HTTP servers as there is no webhook traffic
* Relatively simple to code, and the code can be used for any of our supported API endpoints
* Can be implemented behind a firewall, without exposing any public HTTP services

## Using Cursor Based Polling

Cursor based polling allows a system to request the changes since the last point that was checked. The system revolves around two crucial bits of information:

* An `updated_at` `ASC` sort
* A `cursor` consisting of the updated_at timestamp of the last received item

By making a request with the params `?sort=updated_at&sort_direction=ASC&updated_at[gt]=2017-10-29T18:48:16.942022Z&per_page=100`, up to 100 items that have been updated since the provided time will be returned. These items are then processed, and the cursor is updated to the first items updated_at value. The cursor format should be iso8601 with microseconds for the highest available accuracy.

## Let's Look at a Ruby Poller

https://github.com/SalesLoft/api-guide/blob/master/ruby-person-poller provides a fully implemented poller, in Ruby, against the SalesLoft "list people" API.

A key part of this code is the processing of a page from the API. When a page is processed and iterated on, the last item in the page is used as the new cursor. If there is no item, then the cursor does not need updated as there will not be overlap with old and new data sets.

```ruby
  def process_page(&block)
    data = HTTParty.get(url, headers: headers)["data"]
    data.each(&block)
    @cursor = Time.parse(data.last["updated_at"]) unless data.last.nil?
  end
```

## Next Steps

If you're looking to implement a poller in production, there are a few things you'll want to do. At a minimum:

* Persist the cursor in a data store
* Use a page size of 100 for fewer API calls
* Keep track of the last processed state for records so that records are not double processed. This can be done by creating an MD5 hash signature of the fields that you care about
* Utilize refresh tokens in order to never have your poller break
* Handle rate limiting and bursting of the API reasonably
