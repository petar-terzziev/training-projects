#!/usr/bin/python
from queue import *
from collections import namedtuple
matrix = [
[' ', ' ', ' ', '*', ' ', ' ', ' '],
['*', '*', ' ', '*', ' ', '*', ' '],
[' ', ' ', ' ', ' ', ' ', ' ', ' '],
[' ', '*', '*', '*', '*', '*', ' '],
[' ', ' ', ' ', ' ', ' ', ' ', 'e']
]


Point = namedtuple('Point', 'x y')
qnode=namedtuple('qnode','point distance ')

def search(x,y):
	if matrix[x][y]=='e':
		print("We are out!")
		return True
	elif matrix[x][y]=='*':
	
		return False
	elif matrix[x][y]=='.':
		
		return False
	print("visiting %d %d"%(x,y))

	matrix[x][y]='.'

	if((x<len(matrix)-1 and search(x+1,y)) 
		or (y>0 and search(x,y-1))
		or (x>0 and search(x-1,y))
		or (y<len(matrix[0])-1 and search(x,y+1))):

		return True
	return False

rowit = [-1, 0, 0, 1]; 
colit = [0, -1, 1, 0]; 
valid=lambda x,y: (x<=len(matrix)-1 and y<=len(matrix[0])-1 and x>=0 and y>=0)
start=Point(0,0)
sn=qnode(start,0)
matrix[0][0]='.'
q=[]
q.append(sn)
def bfs():
	visited=[[False*len(matrix)]*len(matrix[0])]
	while len(q)>0:

		curr=q[0]
		print(curr)
		if(curr[0][0]==4 and curr[0][1]==6):
			return curr[1]

		q.pop(0)
	
		for i in range(4):
			row=curr[0][0]+rowit[i]
			col=curr[0][1]+colit[i]
			if(valid(row,col) and matrix[row][col]==' ' and (not visited[row][col])):
				visited[row][col]=True
				adjc=qnode(Point(row,col),curr[1]+1)
				
				q.append(adjc)




okok=bfs()
print(okok)
	



#search(0,0)
#for i in range(5):
#	for j in range(7):
#		print(matrix[i][j]+" ",end='',flush=True)
#	print (' ')