# Setup
import requests
import json
import time
import os
from datetime import datetime

# Polls a given resource, keeping track of the last processed item to continue the processing
class SalesLoftPoller:
    API_BASE = "https://api.salesloft.com/v2"
    PAGE_SIZE = 2 # Demonstrate how to process pages in the chance of more than 100 in a response

    def __init__(self, resource):
        self.cursor = datetime.now().isoformat()
        self.resource = resource

    def process_page(self):
        while True:
            import pdb; pdb.set_trace()
            response = requests.get(self.url(), headers=self.headers())
            data = response.json()["data"]

            for datum in data:
                yield datum

            if data:
                self.cursor = data[-1]["updated_at"]
            else:
                break

    def url(self):
        return f"{self.API_BASE}/{self.resource}?per_page={self.PAGE_SIZE}&sort=updated_at&sort_direction=ASC&updated_at[gt]={self.cursor}"

    def headers(self):
        return { "Authorization": f'Bearer {os.environ["ACCESS_TOKEN"]}' }


poller = SalesLoftPoller("people")

print("Starting 6s poller for 120 times, ctrl+c to kill...")

for i in range(120):
    for record in poller.process_page():
        updated_at = record["updated_at"]
        print(json.dumps(record, indent=4, sort_keys=True))
        print(f"Got a record updated_at={updated_at}")

    time.sleep(6)
    print(f"sleep {i + 1}")
