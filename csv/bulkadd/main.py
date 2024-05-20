import pandas as pd
import csv
import mysql.connector
from mysql.connector import Error
import sys


def dataAdd(user):
    # check file is exist
    try:
        # Read the CSV file
        with open('csv/bulkadd/data.csv', 'r') as file:
            reader = csv.DictReader(file)
            data = [row for row in reader]

        # Establish a connection to the MySQL database
        try:
            connection = mysql.connector.connect(
                host='localhost',
                database='pms-ml-' + user,
                user='root',
                password=''
            )
            if connection.is_connected():
                db_info = connection.get_server_info()
                print("Connected to MySQL Server version:", db_info)
        except Error as e:
            print("Error while connecting to MySQL:", e)

        # Create a cursor object
        cursor = connection.cursor()

        # Iterate over the data and insert rows into the database
        for row in data:
            # Assuming your table has columns named 'column1', 'column2', etc.
            query = "INSERT INTO `vehicle`(`vehicle_num`, `vehicle_type`, `vehicle_class`, `owner`, `phone`, `nic`, " \
                    "`image`) " \
                    "VALUES (%s, %s, %s, %s, %s, %s, %s)"
            image = row['VehicleNum'] + ".jpg"
            values = (
                row['VehicleNum'], row['vehicle_type'], row['vehicle_class'],
                row['UserName'], row['phone'], row['nic'], image
            )
            cursor.execute(query, values)
            connection.commit()

        # Close the cursor and connection
        cursor.close()
        connection.close()

    except FileNotFoundError:
        print("File not found")


# Get the user argument from the command line
user = sys.argv[1]

# Call the dataAdd function with the user argument
dataAdd(user)
