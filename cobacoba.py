import mysql.connector
import pymongo
from decimal import Decimal

def convert_decimal_to_float(data):
    """Recursively convert Decimal values to float."""
    if isinstance(data, Decimal):
        return float(data)
    elif isinstance(data, list):
        return [convert_decimal_to_float(item) for item in data]
    elif isinstance(data, dict):
        return {key: convert_decimal_to_float(value) for key, value in data.items()}
    else:
        return data

def fetch_and_insert_data(mysql_query, mongo_collection_name):
    mycursor = mysqldb.cursor(dictionary=True)
    mycursor.execute(mysql_query)
    result = mycursor.fetchall()
    
    mycol = mydb[mongo_collection_name]

    if result:
        # Convert Decimal values to float before inserting into MongoDB
        result_float = convert_decimal_to_float(result)
        x = mycol.insert_many(result_float)
        print(f"Inserted {len(x.inserted_ids)} documents into {mongo_collection_name}")

# MySQL database connection
mysql_params = {
    "host": "localhost",
    "database": "northwind",
    "user": "root",
    "password": ""
}

mysqldb = mysql.connector.connect(**mysql_params)

# MongoDB connection
mongodb_host = "mongodb://localhost:27017/"
mongodb_dbname = "northwind"
myclient = pymongo.MongoClient(mongodb_host)
mydb = myclient[mongodb_dbname]

# Fetch and insert data for different scenarios
fetch_and_insert_data("SELECT * FROM products JOIN categories ON products.categoryID = categories.categoryID JOIN suppliers ON products.supplierID = suppliers.supplierID", "product_lookup")
fetch_and_insert_data("SELECT * FROM employees", "employee_lookup")
fetch_and_insert_data("SELECT * FROM orders JOIN order_details ON orders.orderID = order_details.orderID JOIN shippers ON orders.shipVIA = shippers.shipperID", "fact_orders")
fetch_and_insert_data("SELECT * FROM customers", "customer_lookup")

# Close connections
mysqldb.close()
