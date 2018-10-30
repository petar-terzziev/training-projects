def square(n):
	s=''
	if n==0:
		return 0
	

	for i in range(n+1):
		s+=str(i**2)
	

	return s[n]


no=square(0)
print(no)