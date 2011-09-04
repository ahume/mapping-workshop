import csv
import simplegeo

location_data = {
	"Abu Qurayn": {"lat": 31.451111, "lon": 15.248889 },
	"Ajdabiyah": {"lat": 30.755556, "lon": 20.225278 },
	"Al-Aziziyah": {"lat": 32.530833, "lon": 13.021111 },
	"Al-Khums": {"lat": 32.649722, "lon": 14.264444 },
	"Al Jawsh": {"lat": 31.9833, "lon": 11.6667 },
	"Az Zawiyah": {"lat": 32.752222, "lon": 12.727778 },
	"Badr": {"lat": 32.059444, "lon": 11.543056 },
	"Bani Walid": {"lat": 31.766667, "lon": 13.983333 },
	"Brega": {"lat": 30.3997, "lon": 19.6161 },
	"Bin Ghashir": {"lat": 32.6833, "lon": 13.1833 },
	"Bir Al Ghanam": {"lat": 32.3167, "lon": 12.5667 },
	"Dahra": {"lat": 29.5, "lon": 17.8333 },
	"Dur at Turkiyah": {"lat": 30.0833, "lon": 16.55 },
	"Gharyan": {"lat": 32.169722, "lon": 13.016667 },
	"Hun": {"lat": 29.1166667, "lon": 15.9333333 },
	"Jadu": {"lat": 31.95, "lon": 12.0166667 },
	"Misrata": {"lat": 32.377533, "lon": 15.092017 },
	"Mizdah": {"lat": 31.445, "lon": 12.983056 },
	"Nalut": {"lat": 31.8683, "lon": 10.9828 },
	"Okba": {"lat": 32.895, "lon": 13.280278 },
	"Qaryat": {"lat": 30.2925, "lon": 19.425556 },
	"Ras Lanuf": {"lat": 30.474722, "lon": 18.573611 },
	"Sabha": {"lat": 27.038889, "lon": 14.426389 },
	"Sirte": {"lat": 31.205314, "lon": 16.588936 },
	"Surman": {"lat": 32.7563889, "lon": 12.575 },
	"Tarhunah": {"lat": 32.433611, "lon": 13.634722 },
	"Tiji": {"lat": 32.0167, "lon": 11.3667 },
	"Tripoli": {"lat": 32.902222, "lon": 13.185833 },
	"Tunisian Border": {"lat": 31.8683, "lon": 10.9828 },
	"Tawurgha": {"lat": 32.0167, "lon": 15.1167 },
	"Waha": {"lat": 28.1, "lon": 20 },
	"Waddan": {"lat": 29.161111, "lon": 16.143611 },
	"Yafran": {"lat": 32.062778, "lon": 12.526667 },
	"Zintan": {"lat": 31.930556, "lon": 12.248333 },
	"Zlitan": {"lat": 32.466667, "lon": 14.566667 },
	"Zuwarah": {"lat": 32.933333, "lon": 12.083333 }
}

OAUTH_TOKEN = 'cW9uEvkZvpaXReQG2XEdHPD6KUZPpjwH'
OAUTH_SECRET = 'Up88NQYpb8ag4eqvReUUVRmFJg5BrMYz'
CSV_FILE = 'csv/libya_full_data.csv'
LAYER = 'libya'

client = simplegeo.Client(OAUTH_TOKEN, OAUTH_SECRET)


def insert(id, data):
	layer = LAYER
	#try:
	place = data.pop("place")
	print place
	try:
		lat = location_data[place].get("lat")
		lon = location_data[place].get("lon")
		location_exists = True
		print "Sending data for strike on: %s" % place
	except:
		location_exists = False
		print "We don't have location for id: %s" % id
		
	if location_exists:	
		try:
			record = simplegeo.Record(layer,id,lat,lon, **data)
			client.add_record(record)
			print "Success"
		except:
			print "Request failed"

r = csv.DictReader(open(CSV_FILE, mode='U'))
id = 1
for l in r:
	insert(id, l)
	id = id + 1
