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
		if type(y)==list :
			return MyList(self.data+y)
		if type(y)==MyList:
			return MyList(self.data+y.data)
		else:
			raise TypeError

	def __getitem__(self,y):
		return self.data[y]

class MyListSub(MyList):
	cnt=0
	def __add__(self,y):
		print("+ operator has been called ",MyListSub.cnt," times.")
		MyListSub.cnt+=1
		if type(y)==list :
			return MyListSub(self.data+y)
		if type(y)==MyList:
			return MyListSub(self.data+y.data)
		if type(y)==MyListSub:
			return MyListSub(self.data+y.data)
		else:
			raise TypeError


class Attrs:
	def __getattribute__(self, name):
	    print ("getting ",name)


class Set:
	def __init__(self, value = []): # Constructor
		self.data = [] # Manages a list
		self.concat(value)
	def intersect(self, other): # other is any sequence
		res = [] # self is the subject
		for x in self.data:
			if x in other: # Pick common items
				res.append(x)
		return Set(res) # Return a new Set
	def union(self, other): # other is any sequence
		res = self.data[:] # Copy of my list
		for x in other: # Add items in other
			if not x in res:
				res.append(x)
		return Set(res)
	def concat(self, value): # value: list, Set...
		for x in value: # Removes duplicates
			if not x in self.data:
				self.data.append(x)
	def __getitem__(self, key): 
		return self.data[key] # self[i], self[i:j]
	def __and__(self, other): 
		return self.intersect(other) # self & other
	def __or__(self, other): 
		return self.union(other) # self | other

attrs=Set([9,7,0])
l1=attrs|[6,4]
l2=attrs&[0]


class Lunch:
	def __init__(self):
		self.cust=Customer()
		self.empl=Employee()


	def order(self,foodName):
		self.cust.placeOrder(foodName,self.empl)

	def result(self):
		self.cust.printFood()

class Customer:
	def __init__(self):
		self.food=None

	def placeOrder(self,foodName,employee):
		self.food=employee.takeOrder(foodName)

	def printFood(self):
		print(self.food.name)


class Employee:

	def takeOrder(self,foodName):
		return Food(foodName)

class Food:
	def __init__(self,name):
		self.name=name


stringset=Set("opopbrt")
inter=stringset&"popb"
print(stringset.data)
goingouttolunch=Lunch()
goingouttolunch.order("Pizza")
goingouttolunch.result()

class Animal:
	def speak(self):
		print("Hello word")
	def reply(self):
		self.speak()

class Mammal(Animal): pass	

class Cat(Mammal):
	def speak(self):
		print("meow")

class Dog(Mammal):
	def speak(self):
		print("bark")

class Primat(Mammal): pass 

class Hacker(Primat): pass



class Customer:
	def line(self):
		print("that's one ex-bird!")

class Clerk:
	def line(self):
		print("no it isn't...")

class Parrot:
	def line(self):
		print(None)


class Scene:
	def __init__(self):
		self.parrot=Parrot()
		self.clerk=Clerk()
		self.customer=Customer()

	def action(self):
		self.parrot.line()
		self.clerk.line()
		self.customer.line()


class Myerror(Exception): pass 


def oops():
	raise Myerror

def catchingindex():
	try:
		oops()
	except (IndexError,KeyError,Myerror) as e :
		print("caught it")
import sys, traceback

def safe(func,*pargs,**kargs):
	try:
		func(*pargs,**kargs)
	except:
		traceback.print_exc()
		print('Got %s %s' % (sys.exec_info()[0],sys.exec_info()[1]))

