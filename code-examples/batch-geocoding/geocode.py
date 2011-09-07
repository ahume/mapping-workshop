import csv
from geopy import geocoders

g = geocoders.Google(domain='maps.google.co.uk')


results = []

def add_coords(record):
	try:
		place, (lat, lon) = g.geocode(record["PostCode"])
		record["Lat"] = lat
		record["Lon"] = lon

		results.append(record)
	except:
		print "GEOCODE ERROR: %s\n" % record["PostCode"]

CSV_FILE = '../../data/raw/keystage5_brighton.csv'

r = csv.DictReader(open(CSV_FILE, mode='U'))
for l in r:
	add_coords(l)
	
	
# And then write it to a JSON file

print "------"
print "About to write to JSON"

import json
with open('geocoded.json', mode='w') as f:
	json.dump(results, f)
