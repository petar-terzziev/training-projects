
import xlrd
import _mysql


# Open the workbook and define the worksheet
book = xlrd.open_workbook("Ek_obl.xls")
sheet = book.sheet_by_name("Ek_obl")

# Establish a MySQL connection
database = _mysql.connect (host="localhost", user = "root", passwd = "", db = "ekatte")

# Get the cursor, which is used to traverse the database, line by line
cursor = database.cursor()

# Create the INSERT INTO sql query
query = """INSERT INTO oblasti (kod_oblast,ekatte,name) VALUES (%s, %s, %s)"""

# Create a For loop to iterate through each row in the XLS file, starting at row 2 to skip the headers
for r in range(1, sheet.nrows):
		koblast	= sheet.cell(r,).value
		ekate	= sheet.cell(r,1).value
		ime		= sheet.cell(r,2).value

		# Assign values from each row
		values = (koblast,ekate,ime)

		# Execute sql Query
		cursor.execute(query, values)

# Close the cursor
cursor.close()

# Commit the transaction
database.commit()

# Close the database connection
database.close()

# Print results
columns = str(sheet.ncols)
rows = str(sheet.nrows)
