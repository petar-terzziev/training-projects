def square(n):
	if n>32000 or n<0:
		return 'invalid number'
	s=''
	if n==0:
		return '0'



	

	for i in range(n+1) :
		s+=str(i**2)
	

	return s[n]


no=square()
print(no)