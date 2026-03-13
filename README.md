# E-commerce Website

## Project Overview
This is an e-commerce platform designed for customers and admins to handle shopping and management functionalities. Below are concise, sectioned explanations for each part of the project.

-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

## 1. User Section
This section explains how users interact with the website.

### 1.1 How can users register on the platform?
- Users can create an account on the `register.php` page by providing their name, email, and password.  
- Registration allows access to personalized features like the shopping cart.

### 1.2 How can users login and logout?
- Users login on the `login.php` page using their email and password.  
- The `logout.php` page ends the session, keeping user data secure.

### 1.3 How can users view products?
- All products are displayed on the homepage (`index.php`).  
- Users can see product names, prices, and descriptions.

### 1.4 How can users add products to their cart?
- On the `index.php` page, users click **“Add to Cart”** to save items.

### 1.5 How can users manage their cart?
- The `cart.php` page lets users view, update, or remove items from their cart.

--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

## 2. Admin Section
This section explains how admins manage the website and products.

### 2.1 How can admins login?
- Admins use the `adminlogin.php` page with email and password credentials.  
- Only authorized admins can access the admin dashboard.

### 2.2 How can admins manage products?
- Admins can **add new products** via the `add_product.php` page.  
- Admins can **edit product details**, including name, price, description, and image, via `edit_product.php`.  
- Admins can **delete products** using the delete option in the dashboard.

### 2.3 How can admins track daily activity?
- The dashboard shows daily printed cards (demo) and other summary statistics.  
- Admins can also read messages sent by users via the messaging system.

---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

## 3. Database Section
This section explains the database structure.

### 3.1 Database Configuration
- The database connection is handled in `db.php`.  
- Credentials should be updated as per your local server setup:

```php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database_name";
