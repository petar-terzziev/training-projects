def countlines(name):
	fo=open(name)
	print(len(fo.readlines()))

def countChars(name):
	fo=open(name)
	print(len(fo.read()))



class Adder:
	def add(self,x,y):
		print("Not implemented")


countChars("exercises_3_and_4.py")