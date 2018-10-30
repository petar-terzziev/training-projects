def square(n):
	s=''
	for i in range(n):
		s+=str(i**2)

	return s[n]


no=square(10)
print(no)