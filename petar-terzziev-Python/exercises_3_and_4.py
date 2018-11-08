def logic_alternatives_a():
	L=[1,2,4,8,16,32,64]
	X=5
	i=0;
	while i<len(L) :
		i+=1
		if(2**X==L[i]):
			print('at index',i)
			break;
		
	else:
		print(X,'not found')

def logic_alternatives_b():
	L=[1,2,4,8,16,32,64]
	X=5
	for i in L:
		if(2**X==i):
			print('at index',L.index(i))
			break

	else:
		print(X,'not found')

def logic_alternatives_c():
	L=[1,2,4,8,16,32,64]
	X=5
	print(2**X in L)

def logic_alternatives_d():
	L=[]
	X=5
	for i in range(X):
		L.append(2**i)
	print(*L)


def copyDict(dict1):
	newdict={}
	for i in dict1.keys():
  		newdict[i]=dict1[i]
	return newdict


dict1={'key1':'value1','key2':'value2'}
dict2=copyDict(dict1)
print(dict2)