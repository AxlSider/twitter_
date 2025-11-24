# D&K Twittrix

Welcome to **D&K Twittrix**, a social media micro-blogging application built with **Laravel 10**.

This project was developed to replicate the core experience of Twitter (X), focusing on a clean, "Lights Out" dark mode design and a seamless user experience. It allows users to register, share thoughts, interact with others via real-time likes, and manage their profiles.

## 🚀 Features Implemented

I focused on building a robust backend with a responsive, modern frontend. Here is what the app can do:

### 1. User Authentication
- **Secure Access:** Users can register and login securely using Laravel Breeze.
- **Security:** All passwords are hashed using Bcrypt.
- **Route Protection:** Unauthenticated users are redirected to login; only members can view the feed or interact.

### 2. Tweet Management (CRUD)
- **Posting:** Users can create tweets with a real-time character counter (max 280 characters).
- **Feed:** The homepage displays a global stream of tweets, ordered by newest first.
- **Editing:** Users can edit their own tweets (an "edited" tag appears to maintain transparency).
- **Deleting:** Users can delete their tweets, protected by a confirmation prompt to prevent accidents.

### 3. The Like System (AJAX)
- **Instant Feedback:** I implemented JavaScript (Fetch API) so that clicking the "Heart" icon updates the like count instantly without reloading the page.
- **Logic:** A user can toggle a like on or off, but cannot like the same tweet twice.

### 4. User Profiles
- **Personal Dashboard:** Clicking any username leads to their specific profile.
- **Stats:** Shows when they joined, how many tweets they have posted, and the total number of likes they have received.

### 5. UI/UX Design
- **"Lights Out" Theme:** A custom Dark Blue (`#0f172a`) theme designed for reduced eye strain.
- **Clean Layout:** Removed card borders in favor of a minimalist, line-separated feed similar to modern social platforms.
- **Responsive:** Built with Tailwind CSS to work perfectly on mobile and desktop.

---

## 🛠️ Installation Instructions

If you want to run this project on your local machine, follow these steps:

### Prerequisites
Ensure you have **PHP**, **Composer**, **Node.js**, and **MySQL** installed.

### Step 1: Clone & Install
bash
# Clone the repository
git clone [https://github.com/your-username/dk-twittrix.git](https://github.com/your-username/dk-twittrix.git)

# Enter the directory
cd dk-twittrix

# Install PHP dependencies
composer install

# Install Frontend dependencies
npm install
npm run build


### Step 2: Environment Setup
# Create the environment file
cp .env.example .env

# Generate the app key
php artisan key:generate

### Step 3: Database Setup
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=twitter
DB_USERNAME=root
DB_PASSWORD=Step 3: Database Setup

### Step 4: Run Migrations
php artisan migrate

### Step 5: Launch
php artisan serve


## 📸 Application Screenshots

**1. The Feed (Dark Mode)**
![Feed Screenshot](screenshots/feed.png)

**2. Profile Page & Stats**
![Profile Screenshot](screenshots/profile.png)

**3. Tweets**
![Tweets Screenshot](screenshots/tweets.png)

**4. login page**
![Login Screenshot](screenshots/login.png)

**5. register page**
![Register Screenshot](screenshots/register.png)


**6. Mobile Responsiveness**
![Mobile Screenshot](screenshots/mobilefeed.png)
![Mobile Screenshot](screenshots/mobilelogin.png)
![Mobile Screenshot](screenshots/register.png)
![Mobile Screenshot](screenshots/tweets.png)
![Mobile Screenshot](screenshots/mobileprofile.png)

