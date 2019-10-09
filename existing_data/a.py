import os

f1 = open("pins.txt","r")
c1 = f1.read().split()
f2 = open("counts.txt","r")
c2 = f2.read().split()


f3 = open("sql.txt","w+")
for _ in range(10000):
	while len(c1[_]) < 4:
		c1[_] = "0" + c1[_]
	f3.write('INSERT INTO existing_pin_codes VALUES("' + c1[_] + '", ' + c2[_] + ");\n")