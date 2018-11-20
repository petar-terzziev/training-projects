#!/usr/bin/python

matrix = [
[' ', ' ', ' ', '*', ' ', ' ', ' '],
['*', '*', ' ', '*', ' ', '*', ' '],
[' ', ' ', ' ', ' ', ' ', ' ', ' '],
[' ', '*', '*', '*', '*', '*', ' '],
[' ', ' ', ' ', ' ', ' ', ' ', 'e']
]



def search(x,y):
	if matrix[x][y]=='e':
		print("We are out!")
		return True
	elif matrix[x][y]=='*':
		print("Wall at %d %d"%(x,y))
		return False
	elif matrix[x][y]=='.':
		print("Visited at %d %d" %(x,y))
		return False
	print("visiting %d %d"%(x,y))

	matrix[x][y]='.'

	if((x<len(matrix)-1 and search(x+1,y)) 
		or (y>0 and search(x,y-1))
		or (x>0 and search(x-1,y))
		or (y<len(matrix[0])-1 and search(x,y+1))):

		return True
	return False

search(0,0)