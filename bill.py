
from datetime import datetime, date,timedelta, timezone
import pytz
from reportlab.platypus import SimpleDocTemplate, Paragraph, Spacer,Table, TableStyle
from reportlab.lib.styles import getSampleStyleSheet
from reportlab.lib.units import inch
from reportlab.lib import colors
from reportlab.pdfgen import canvas
from reportlab.lib.pagesizes import letter
import mysql.connector
import os
import shutil
import sys




srilanka = pytz.timezone('Asia/Colombo')

# Check payment option is anabled or not
def checkPayment(user):
    # Connect Database
    database = "iPMS-clients"

    try:
        myDB = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database=database
        )
        myCursor = myDB.cursor()
    except mysql.connector.Error as e:
        print("Error:", e)
        return False

    # Get payment option deteils
    sqlGetPaymentInfo = "SELECT `mode` FROM `clients` WHERE `name`='" + user + "'"
    myCursor.execute(sqlGetPaymentInfo)
    result = myCursor.fetchone()
    # Closs Database
    myDB.close()

    if result:
        if result[0] == "t":
            return True
        else:
            return False
        
# fun to copy files from bills/slt to Allbackup
def copy_files(source_path, destination_path):
    # Get a list of all files in the source directory
    files = os.listdir(source_path)

    for file_name in files:
        source_file = os.path.join(source_path, file_name)
        destination_file = os.path.join(destination_path, file_name)

        # Check if the file already exists in the destination directory
        if os.path.exists(destination_file):
            print(f"File {file_name} already exists in the destination. Skipping.")
        else:
            # Copy the file to the destination directory
            shutil.copy2(source_file, destination_file)
            print(f"File {file_name} copied to the destination.")
            
def getData(vehicle_num, user):
    database = "pms-ml-" + user
    # resultCustomer = None  # Initialize the variable to None in case of an error
    
    try:
        myDB = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database=database
        )
        myCursor = myDB.cursor()

        # Get customer details
        sqlGetCustomerDetails = "SELECT `owner`,`phone` FROM `vehicle` WHERE `vehicle_num` = '" + vehicle_num + "'"
        myCursor.execute(sqlGetCustomerDetails)
        resultCustomer = myCursor.fetchall()
        print(resultCustomer)

    except mysql.connector.Error as e:
        print("Error:", e)
    finally:
        # Make sure to close the database connection in a finally block
        if myDB.is_connected():
            myCursor.close()
            myDB.close()
    
    if resultCustomer:
        return resultCustomer
    else:
        return 0  # You may want to return something more meaningful than 0   
    
    
def getCost(vehicle_num, user):
    database = "pms-ml-" + user
    # resultCustomer = None  # Initialize the variable to None in case of an error
    
    try:
        myDB = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database=database
        )
        myCursor = myDB.cursor()

        # Get Vehicle Parked Time
        sqlGetParkedTime = "SELECT `parked_time`,`class`,`type`,`spot_id` FROM `spot` WHERE `parked_vehicle` = '" + vehicle_num + "'"
        myCursor.execute(sqlGetParkedTime)
        result = myCursor.fetchall()
        print(result)

    except mysql.connector.Error as e:
        print("Error:", e)
    finally:
        # Make sure to close the database connection in a finally block
        if myDB.is_connected():
            myCursor.close()
            myDB.close()
    
    if result:
        return result
    else:
        return 0  # You may want to return something more meaningful than 0   
    
def getfee(feeID, user):
    database = "pms-ml-" + user
    # resultFee = None  # Initialize the variable to None in case of an error

    try:
        myDB = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database=database
        )
        myCursor = myDB.cursor()

        sqlGetFee = "SELECT `toll_per_hour` FROM `tolls` WHERE `feeid` = '" + feeID + "'"
        myCursor.execute(sqlGetFee)
        feeResult = myCursor.fetchone()
        print(feeResult)

    except mysql.connector.Error as e:
        print("Error:", e)
    finally:
        # Make sure to close the database connection in a finally block
        if myDB.is_connected():
            myCursor.close()
            myDB.close()

    if feeResult:
        return feeResult
    else:
        return 0  # You may want to return something more meaningful than 0  

            
    # Parking Cost Bill
def newUpdate_parking_cost_bill(vehicle_num,user):
    
    now_time = datetime.now()
    time = now_time.strftime('%H:%M:%S')
    dt = date.today().strftime('%Y-%m-%d')
    
    bill_name = user + "_" + str(dt) + "_" + str(time) + "_" + str(vehicle_num) + "_"
    print(bill_name)
    # path = "/var/www/html/pms-new/bills/" + user + "/" + bill_name + "bill-new.pdf"
    
    # path = "/var/www/html/pms-new/bills/"  + bill_name + "bill-new.pdf"
    # c = canvas.Canvas(path,pagesize=letter)  
  
  
    # define paths for copy_files func
    # path01 = "/var/www/html/pms-new/bills/AllBackup/"
    # path02 = "/var/www/html/pms-new/bills/" + user + "/" 

    customer_name = ''
    mobile_num = ''
    total_hours=''
    totalCost=''
    fee=''
        
    
    get_customer_data = getData(vehicle_num, user)

    if get_customer_data:
        customer_name = get_customer_data[0][0]
        mobile_num = get_customer_data[0][1]
        print(customer_name)

    
    get_cost_data = getCost(vehicle_num, user)
    print('error getting cost data')

    if get_cost_data:
        # Parking spot class
        spotClass = get_cost_data[0][1]
        vType = get_cost_data[0][2]
        feeID = spotClass + "_" + vType
        spotID = get_cost_data[0][3]
        # Calculate total parking hours
        parkedTime = datetime.strptime(get_cost_data[0][0], "%Y-%m-%d %H:%M:%S").replace( microsecond=0)

       
        
        print(parkedTime)
        nowTime1 = datetime.now(srilanka).replace( microsecond=0)
        # Format the datetime without timezone information
        nowTime_str = nowTime1.strftime("%Y-%m-%d %H:%M:%S")

        # Convert the formatted string back to datetime without timezone
        nowTime = datetime.strptime(nowTime_str, "%Y-%m-%d %H:%M:%S")
        print(nowTime)

        total_time = nowTime - parkedTime
        print('Total time is: ' , total_time)
        
        # if (total_time <0):
        #     total_time=time_difference_minutes / 60
            

        total_hours = round(total_time.total_seconds() / 3600, 2)
        
        if (total_hours <0):
            # Calculate the time difference in minutes
              
              total_hours = round((nowTime - parkedTime).total_seconds() / 3600,2)
              print('total_hoursin firstif condition  :',total_hours)
            #   total_hours=time_difference_minutes / 60
            #   
              if (total_hours <0):
                  total_hours=0
        print('total hours are:',total_hours)

        # Get fee for hour
       
    get_fee = getfee(feeID, user)
    print('error getting fee data')
    
    if get_fee:
        fee = get_fee[0]
        print(fee,'this is fee')

        totalCost = round(fee * total_hours, 2)
        if totalCost < 500:
            totalCost = 500
        if totalCost > 10000000:
            totalCost = 10000
        stringhour = str(total_hours)
        print('this is the final total cost',totalCost)

        print("This is payment part Debug success..!!..")
    
    print('after data retrieving')
    
    # PDF generating
    
    # check the payment option enabled or disabled
    if checkPayment(user):
        
        path = "/var/www/html/pms-new/bills/"  + bill_name + "parking_cost_bill.pdf"
        c = canvas.Canvas(path,pagesize=letter) 
    
        c.translate(inch, inch)
        c.setFont("Helvetica", 14)
        c.setStrokeColorRGB(0 / 255, 45 / 255, 117 / 255)
        c.setFillColorRGB(0, 0, 1)
        c.drawImage('images/logos/logo-new.PNG', 0 * inch, 9.1 * inch)
        c.setFillColorRGB(0, 0, 0)
        c.line(0, 8.6 * inch, 6.8 * inch, 8.6 * inch)

        # now = datetime.now()
        # time = now.strftime('%H:%M:%S')
        # dt = date.today().strftime('%d-%b-%Y')
        c.setFont("Helvetica", 16)
        c.setFillColorRGB(0, 0, 0)
        c.drawString(4.8 * inch, 9 * inch, "Time:        " + time)
        c.drawString(4.8 * inch, 9.4 * inch, "Date:    " + dt)

        c.setFont("Helvetica", 8)
        c.line(0, 0.15 * inch, 6.8 * inch, 0.15* inch)
        
        c.drawImage('images/logos/SLTMobitel.png', x=1 * inch, y=-0.575* inch, width=1.4 * inch, height=0.5 * inch)
        c.drawImage('images/logos/embryo-new.png', x=4.1 * inch, y=-0.59 * inch, width=1.5 * inch, height=0.42 * inch)
        
        c.setFillColorRGB(121 / 255, 121 / 255, 246 / 255)
        c.drawString(2.1 * inch, -0.9 * inch, u"\u00A9" + " Copyright © 2023 iPMS. All rights reserved")

        c.drawImage('images/logos/logo-7.png', x=1 * inch, y=1.5 * inch, width=4.8 * inch, height=4.8 * inch)
        c.drawImage('images/logos/logo-5.png', x=1.15 * inch, y=1.5 * inch, width=4.4 * inch, height=1.1 * inch)

        c.setFillColorRGB(0 / 255, 45 / 255, 117 / 255)
        c.setFont("Helvetica-Bold", 25)
        c.drawString(1.6 * inch, 7.8 * inch, 'PARKING COST BILL')

        c.setFont("Helvetica-Bold", 14)
        c.setFillColorRGB(0, 0, 0)
        c.drawString(2.3 * inch, 7.1 * inch, 'CUSTOMER DETAILS')
        c.setStrokeColorRGB(0, 0, 0)
        c.line(2.3 * inch, 7.05 * inch, 4.32 * inch, 7.05 * inch)
    
        # create table customer details
        table_data = [
            ('Customer Name', str(customer_name)),
            ('Mobile Number', str(mobile_num)),
            ('Vehicle Number', str(vehicle_num))
        ]

        col_widths = [160, 160]
        table = Table(table_data, colWidths=col_widths)

        table_style = TableStyle([
            ('ALIGN', (0, 0), (-1, -1), 'LEFT'),
            ('FONTNAME', (0, 0), (-1, -1), 'Helvetica'),
            ('FONTSIZE', (0, 0), (-1, -1), 14),
            ('BOTTOMPADDING', (0, 0), (-1, -1), 18),
            ('GRID', (0, 0), (-1, -1), 1, colors.grey),

        ])

        table.setStyle(table_style)

        table.wrapOn(c, 8 * inch, 0)
        table.drawOn(c, 1.14 * inch, 5.35 * inch)

        c.setFont("Helvetica-Bold", 14)
        c.setFillColorRGB(0, 0, 0)
        c.drawString(2.15 * inch, 4.6 * inch, 'PARKING COST DETAILS')
        c.line(2.15 * inch, 4.55 * inch, 4.55 * inch, 4.55 * inch)

        c.setFont("Helvetica", 14)
        c.setFillColorRGB(0, 0, 0)
        
        # create table parking cost details
        table_data = [
            ('Parking Duration', str(total_hours) + ' Hours'),
            ('Cost per Hour', 'Rs.' + str(fee)),
            ('Total Cost', 'Rs.' + str(totalCost))
        ]

        col_widths = [160, 160]
        table = Table(table_data, colWidths=col_widths)

        table_style = TableStyle([
            ('ALIGN', (0, 0), (-1, -1), 'LEFT'),
            ('FONTNAME', (0, 0), (-1, -1), 'Helvetica'),
            ('FONTSIZE', (0, 0), (-1, -1), 14),
            ('BOTTOMPADDING', (0, 0), (-1, -1), 18),
            ('GRID', (0, 0), (-1, -1), 1, colors.grey),
        ])

        table.setStyle(table_style)

        table.wrapOn(c, 8 * inch, 0)
        table.drawOn(c, 1.14 * inch, 2.85 * inch)

        c.setFont("Helvetica", 20)
        c.setFillColorRGB(0 / 255, 45 / 255, 117 / 255)
        center_x = 6 * inch / 2
        x = (center_x - c.stringWidth('Thank you for using our parking service!', 'Helvetica', 16) / 2)-0.1*inch
        c.drawString(x, 1 * inch, 'Thank you for using our parking service!')
        print('before the save function')
        # save the file to bills/user dir
        c.save()
        print('save function executed')
        
    
            
        # print(pdf_content)
        # exit(0) 
        # call copy_files func
        # copy_files(path02, path01)
        print('copy function executed')
    
    
    else:
        
        path = "/var/www/html/pms-new/bills/"  + bill_name + "non_payment_bill.pdf"
        c = canvas.Canvas(path,pagesize=letter) 
    
        c.translate(inch, inch)
        c.setFont("Helvetica", 14)
        c.setStrokeColorRGB(0 / 255, 45 / 255, 117 / 255)
        c.setFillColorRGB(0, 0, 1)
        c.drawImage('images/logos/logo-new.PNG', 0 * inch, 9.1 * inch)
        c.setFillColorRGB(0, 0, 0)
        c.line(0, 8.6 * inch, 6.8 * inch, 8.6 * inch)

        # now = datetime.now()
        # time = now.strftime('%H:%M:%S')
        # dt = date.today().strftime('%d-%b-%Y')
        c.setFont("Helvetica", 16)
        c.setFillColorRGB(0, 0, 0)
        c.drawString(4.8 * inch, 9 * inch, "Time:        " + time)
        c.drawString(4.8 * inch, 9.4 * inch, "Date:    " + dt)

        c.setFont("Helvetica", 8)
        c.line(0, 0.15 * inch, 6.8 * inch, 0.15* inch)
        
        c.drawImage('images/logos/SLTMobitel.png', x=1 * inch, y=-0.575* inch, width=1.4 * inch, height=0.5 * inch)
        c.drawImage('images/logos/embryo-new.png', x=4.1 * inch, y=-0.59 * inch, width=1.5 * inch, height=0.42 * inch)
        
        c.setFillColorRGB(121 / 255, 121 / 255, 246 / 255)
        c.drawString(2.1 * inch, -0.9 * inch, u"\u00A9" + " Copyright © 2023 iPMS. All rights reserved")

        c.drawImage('images/logos/logo-7.png', x=1 * inch, y=2.1 * inch, width=4.8 * inch, height=4.8 * inch)
        c.drawImage('images/logos/logo-5.png', x=1.15 * inch, y=2.1 * inch, width=4.4 * inch, height=1.1 * inch)

        c.setFillColorRGB(0 / 255, 45 / 255, 117 / 255)
        c.setFont("Helvetica-Bold", 25)
        c.drawString(1.65 * inch, 7.8 * inch, 'NON PAYMENT BILL')

        c.setFont("Helvetica-Bold", 14)
        c.setFillColorRGB(0, 0, 0)
        c.drawString(2.3 * inch, 7.1 * inch, 'CUSTOMER DETAILS')
        c.setStrokeColorRGB(0, 0, 0)
        c.line(2.3 * inch, 7.05 * inch, 4.32 * inch, 7.05 * inch)
    
        # create table customer details
        table_data = [
            ('Customer Name', str(customer_name)),
            ('Mobile Number', str(mobile_num)),
            ('Vehicle Number', str(vehicle_num))
        ]

        col_widths = [160, 160]
        table = Table(table_data, colWidths=col_widths)

        table_style = TableStyle([
            ('ALIGN', (0, 0), (-1, -1), 'LEFT'),
            ('FONTNAME', (0, 0), (-1, -1), 'Helvetica'),
            ('FONTSIZE', (0, 0), (-1, -1), 14),
            ('BOTTOMPADDING', (0, 0), (-1, -1), 18),
            ('GRID', (0, 0), (-1, -1), 1, colors.grey),

        ])

        table.setStyle(table_style)

        table.wrapOn(c, 8 * inch, 0)
        table.drawOn(c, 1.14 * inch, 5.35 * inch)

        c.setFont("Helvetica-Bold", 14)
        c.setFillColorRGB(0, 0, 0)
        c.drawString(2.45 * inch, 4.6 * inch, 'PARKING DETAILS')
        c.line(2.45 * inch, 4.55 * inch, 4.23 * inch, 4.55 * inch)

        c.setFont("Helvetica", 14)
        c.setFillColorRGB(0, 0, 0)
        
        # create table parking cost details
        table_data = [
            ('Parking Duration', str(total_hours) + ' Hours'),
            ('Spot ID', str(spotID))
            # ('Total Cost', 'Rs.' + str(totalCost))
        ]

        col_widths = [160, 160]
        table = Table(table_data, colWidths=col_widths)

        table_style = TableStyle([
            ('ALIGN', (0, 0), (-1, -1), 'LEFT'),
            ('FONTNAME', (0, 0), (-1, -1), 'Helvetica'),
            ('FONTSIZE', (0, 0), (-1, -1), 14),
            ('BOTTOMPADDING', (0, 0), (-1, -1), 18),
            ('GRID', (0, 0), (-1, -1), 1, colors.grey),
        ])

        table.setStyle(table_style)

        table.wrapOn(c, 8 * inch, 0)
        table.drawOn(c, 1.14 * inch, 3.3 * inch)

        c.setFont("Helvetica", 20)
        c.setFillColorRGB(0 / 255, 45 / 255, 117 / 255)
        center_x = 6 * inch / 2
        x = (center_x - c.stringWidth('Thank you for using our parking service!', 'Helvetica', 16) / 2)-0.1*inch
        c.drawString(x, 1.2 * inch, 'Thank you for using our parking service!')
        print('before the save function')
        # save the file to bills/user dir
        c.save()
        print('save function executed')
        
    
            
        # print(pdf_content)
        # exit(0) 
        # call copy_files func
        # copy_files(path02, path01)
        print('copy function executed')
        
    
    
# if __name__ == '__main__':
#      newUpdate_parking_cost_bill("SD345","slt")

# # Get the user argument from the command line
vehicle_num = sys.argv[1]
user = sys.argv[2]

# # Call the dataAdd function with the user argument
newUpdate_parking_cost_bill(vehicle_num,user)