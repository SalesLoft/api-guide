# Setup
require "rubygems"
require "bundler/setup"
Bundler.require
require "active_support/all"

# Polls a given resource, keeping track of the last processed item to continue the processing
class SalesLoftPoller
  API_BASE = "https://api.salesloft.com/v2"

  def initialize(resource)
    @cursor = Time.now.utc
    @resource = resource
  end

  def process_page(&block)
    data = HTTParty.get(url, headers: headers)["data"]
    data.each(&block)
    @cursor = Time.parse(data.last["updated_at"]) unless data.last.nil?
  end

  private

  def url
    "#{API_BASE}/#{@resource}?per_page=100&sort=updated_at&sort_direction=ASC&updated_at[gt]=#{@cursor.iso8601(6)}"
  end

  def headers
    {
      "Authorization" => "Bearer #{ENV.fetch("ACCESS_TOKEN")}"
    }
  end
end

poller = SalesLoftPoller.new("people")

puts "Starting 6s poller for 120s, ctrl+c to kill..."

120.times do |i|
  poller.process_page do |record|
    updated_at = Time.parse(record["updated_at"])
    p "Got a record updated_at=#{updated_at.iso8601(6)} difference=#{Time.now - updated_at}s"
  end

  sleep 6
  puts "sleep #{i}..."
end