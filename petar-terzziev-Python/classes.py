class Adder:
	def __init__(self,data):
		self.data=data
	def __add__ (self,y):
		print("Not implemented")


class ListAdder(Adder):
	def __add__(self,y):
		if type(y)!=list:
			raise TypeError
		return ListAdder(self.data+y)

class DictAdder(Adder):
	def __add__(self,y):
		if type(y)!=dict:
			raise TypeError
		self.data.update(y)
		return DictAdder(self.data)




class MyList:
	def __init__(self,data=[]):
		if type(data)!=list:
			raise TypeError
		self.data=data
	def __add__(self,y):
		if type(y)!=list:
			raise TypeError
		return MyList(self.data+y)
	def __getitem__(self,y):
		return self.data[y]




l45=MyList()
l45+=[8,6,8]
