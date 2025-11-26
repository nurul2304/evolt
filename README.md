<p align="center">
    </p>

<h1 align="center">FleetCharge (Evolt)</h1>

<p align="center">
    <strong>EV Charging Management System</strong>
    <br>
    <a href="https://github.com/nurul2304/evolt/actions"><img src="https://img.shields.io/badge/build-passing-brightgreen" alt="Build Status"></a>
    <a href="https://laravel.com"><img src="https://img.shields.io/badge/Framework-Laravel-red" alt="Laravel"></a>
    <a href="https://php.net"><img src="https://img.shields.io/badge/Language-PHP-blue" alt="PHP"></a>
</p>

<p align="center">
    <a href="#about-the-project">About</a> •
    <a href="#key-features">Features</a> •
    <a href="#getting-started">Getting Started</a> •
    <a href="#team">Our Team</a>
</p>

---

## ⚡ About The Project

**FleetCharge** (Repository: `evolt`) is a web-based application designed to manage Electric Vehicle (EV) charging stations efficiently.

This project was developed as part of the **Project Based Learning (PBL)** curriculum for the **5th Semester**. The system aims to simplify the monitoring, billing, and management of EV charging infrastructure.

### Why FleetCharge?
As the adoption of electric vehicles grows, the need for robust infrastructure management becomes critical. FleetCharge provides a centralized dashboard to oversee charging station operations, ensuring smooth service for EV owners and easy management for station operators.

## 🚀 Key Features

* **Dashboard Monitoring:** Real-time overview of charging station status (Available/Occupied/Offline).
* **Charging Management:** Start, stop, and monitor charging sessions.
* **User Management:** Manage customer data and vehicle information.
* **Billing System:** Automated calculation of charging costs based on duration or kWh.
* **Reporting:** Generate reports on usage history and revenue.
* **Authentication:** Secure login for Admins and Users.

## 🛠️ Tech Stack

* **Framework:** [Laravel](https://laravel.com) (PHP)
* **Database:** MySQL
* **Frontend:** Blade Templates / Bootstrap / Tailwind
* **Version Control:** Git & GitHub

## 💻 Getting Started

Follow these steps to set up the project locally on your machine.

### Prerequisites
* PHP >= 8.1
* Composer
* MySQL

### Installation

1.  **Clone the repository**
    ```bash
    git clone [https://github.com/nurul2304/evolt.git](https://github.com/nurul2304/evolt.git)
    cd evolt
    ```

2.  **Install dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Environment Setup**
    Copy the example env file and make the required configuration changes in the `.env` file.
    ```bash
    cp .env.example .env
    ```

4.  **Generate Key**
    ```bash
    php artisan key:generate
    ```

5.  **Database Migration**
    Make sure your MySQL database is running and connected.
    ```bash
    php artisan migrate --seed
    ```

6.  **Run the Application**
    ```bash
    php artisan serve
    ```
    Access the app at: `http://localhost:8000`

## 👥 The Team (Semester 5 PBL)

Proudly developed by our dedicated team:

| Name | Role | Responsibility |
| :--- | :--- | :--- |
| **Einstein** | **CEO** | Project Lead & Management |
| **Akbar** | **CTO** | Technical Lead & Backend Architecture |
| **Nurul** | **UI/UX Designer** | User Interface & Experience Design |

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
