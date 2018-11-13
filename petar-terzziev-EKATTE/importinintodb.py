import xlrd
import MySQLdb


# Open the workbook and define the worksheet
books=[];
sheets=[];
books.append(xlrd.open_workbook("Ek_obl.xls"))
sheets.append(books[0].sheet_by_name("Ek_obl"))

books.append(xlrd.open_workbook("Ek_obst.xls"))
sheets.append(books[1].sheet_by_name("Ek_obst"))

books.append(xlrd.open_workbook("Ek_atte.xls"))
sheets.append(books[2].sheet_by_name("Ek_atte"))


# Establish a MySQL connection
database = MySQLdb.connect (host="localhost", user = "ekatteuser", passwd = "1241323", db = "ekatte")
database.set_character_set('utf8')

# Get the cursor, which is used to traverse the database, line by line
cursor = database.cursor()
cursor.execute('SET NAMES utf8;')
cursor.execute('SET CHARACTER SET utf8;')
cursor.execute('SET character_set_connection=utf8;')
cursor.execute("ALTER DATABASE ekatte CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci'")

# Create the INSERT INTO sql query
queries=[];
queries.append("""INSERT IGNORE INTO oblasti (kod_oblast,ekatte,name) VALUES (%s, %s, %s)""")

queries.append("""INSERT IGNORE INTO obstini (kod_obst,ekatte,name,kod_oblast) VALUES (%s, %s, %s,%s)""")

queries.append("""INSERT IGNORE INTO selishta (ekatte,name,kod_obst) VALUES (%s, %s, %s)""")

# Create a For loop to iterate through each row in the XLS file, starting at row 2 to skip the headers
for i in range(len(sheets)):
	for r in range(1, sheets[i].nrows):
		kod = sheets[i].cell(r,0).value
		ekate	= sheets[i].cell(r,1).value
		ime		= sheets[i].cell(r,2).value
		values = (kod,ekate,ime)
		if(i==1):
			values=(kod,ekate,ime,kod[:-2])
		if(i==2):
			values=(kod,ime,sheets[i].cell(r,4).value)

		
	
		# Execute sql Query
		cursor.execute(queries[i], values)

# Close the cursor
cursor.close()

# Commit the transaction
database.commit()

# Close the database connection
database.close()

# Print results
columns = str(sheets[0].ncols)
rows = str(sheets[0].nrows)
