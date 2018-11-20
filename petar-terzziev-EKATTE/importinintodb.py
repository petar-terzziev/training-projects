import xlrd
import psycopg2
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
connect_str = "dbname='ekatte' user='postgres' host='localhost' " + \
                  "password='1241323'"
    # use our connection values to establish a connection
conn = psycopg2.connect(connect_str)
# Get the cursor, which is used to traverse the database, line by line
cursor = conn.cursor()
# Create the INSERT INTO sql query
queries=[];
queries.append("""INSERT  INTO oblasti (kod_oblast,name) VALUES (%s,%s) ON conflict(kod_oblast) do nothing """)

queries.append("""INSERT  INTO obstini (kod_obstina,name,oblast) VALUES (%s,%s, %s)  ON conflict(kod_obstina) do nothing""")

queries.append("""INSERT  INTO selishta (ekatte,name,obstina) VALUES (%s,%s, %s) ON conflict(ekatte) do nothing""")


hq1="Select id from oblasti where kod_oblast=%s";
hq2="Select id from obstini where kod_obstina=%s";



# Create a For loop to iterate through each row in the XLS file, starting at row 2 to skip the headers
for i in range(len(sheets)):
	for r in range(1, sheets[i].nrows):
		koblast = sheets[i].cell(r,0).value
		ime	= sheets[i].cell(r,2).value
		values = [koblast,ime]
		if(i==1):
			cursor.execute(hq1,[sheets[i].cell(r,0).value[:-2]])
			res=cursor.fetchone()
			
			     
			values=[koblast,ime,res]
		
			
		if(i==2):
			cursor.execute(hq2,[sheets[i].cell(r,4).value])
			res=cursor.fetchone()
			
			values=[koblast,ime,res]
		
			
			

		
		
	
		# Execute sql Query
		cursor.execute(queries[i], values)

# Close the cursor
cursor.close()

# Commit the transaction
conn.commit()

# Close the database connection
conn.close()

# Print results
columns = str(sheets[0].ncols)
rows = str(sheets[0].nrows)
