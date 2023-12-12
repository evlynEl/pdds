import mysql.connector
import pymongo

mysqldb = mysql.connector.connect(
    host="localhost",
    database="pdds",
    user="root",
    password=""
)
 
mycursor = mysqldb.cursor(dictionary=True)
# mycursor.execute("SELECT * from product, categories, suppliers")
# mycursor.execute("SELECT * from employees, employee_territories, territories, regions")
mycursor.execute("SELECT * from orders, order_details, shippers")
# mycursor.execute("SELECT * from customers")
myresult = mycursor.fetchall()



mongodb_host = "mongodb://localhost:27017/"
 
mongodb_dbname = "Northwind"
 
myclient = pymongo.MongoClient(mongodb_host)
 
mydb = myclient[mongodb_dbname]
 
# mycol = mydb["product_lookup"]
# mycol = mydb["employee_lookup"]
mycol = mydb["fact_orders"]
# mycol = mydb["customer_lookup"]
 
if len(myresult) > 0:
 
       x = mycol.insert_many(myresult) 
 
       print(len(x.inserted_ids))

