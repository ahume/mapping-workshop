import json
import simplegeo

OAUTH_TOKEN = 'cW9uEvkZvpaXReQG2XEdHPD6KUZPpjwH'
OAUTH_SECRET = 'Up88NQYpb8ag4eqvReUUVRmFJg5BrMYz'
JSON_FILE = '../../data/brighton_schools_keystage5.json'
LAYER = 'schools.keystage5'

client = simplegeo.Client(OAUTH_TOKEN, OAUTH_SECRET)

def insert(id, row):
	
	lat = row["Lat"]
	lon = row["Lon"]
	del row["Lat"]
	del row["Lon"]
		
	# try:
	record = simplegeo.Record(LAYER, str(id), lat, lon, **row)
	client.add_record(record)
	# 	print "Success"
	# except:
	# 	print "Request failed: %s" % row["SchoolName"]


def _decode_list(lst):
    newlist = []
    for i in lst:
        if isinstance(i, unicode):
            i = i.encode('utf-8')
        elif isinstance(i, list):
            i = _decode_list(i)
        newlist.append(i)
    return newlist

def _decode_dict(dct):
    newdict = {}
    for k, v in dct.iteritems():
        if isinstance(k, unicode):
            k = k.encode('utf-8')
        if isinstance(v, unicode):
             v = v.encode('utf-8')
        elif isinstance(v, list):
            v = _decode_list(v)
        newdict[k] = v
    return newdict

json_data=open(JSON_FILE)
data = json.load(json_data, object_hook=_decode_dict)

print "Records found: %s" % len(data)
id = 1
for record in data:
	insert(id, record)
	id = id + 1

json_data.close()
