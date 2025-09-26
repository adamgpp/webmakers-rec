# Test Project by Adam Guła

## Requirements

To run this project, make sure you have the following tools installed on your system:
- **PHP** version 8.2 or higher
- **Composer**
- **MySQL** version 8

---

## Setting Up the Project

### 1. Clone the repository
Clone the project to your local system:  
```bash
git clone <repository-url>  
cd <project-directory>
```

### 2. Install dependencies
Navigate to the project's root directory and install dependencies:  
```bash
composer install
```

---

## Configuration

### 1. Database settings
Ensure that the database connection details are correctly configured in the `.env` and `.env.test` files. These files should include the following key:  
`DATABASE_URL=`
Update the values according to your local setup.

---

## Initializing the Database

### 1. Prepare database
Create the database schema:  
```bash
php bin/console doctrine:schema:create
php bin/console doctrine:schema:create --env=test
```
---

## Tests

To run the tests, make sure the test database is configured (as specified in `.env.test`), and then execute:
```bash
php ./vendor/bin/phpunit
```

## Notes

#### Application structure
The project has been implemented in a simplified form. Several intermediary layers between modules are missing (e.g. application/domain services or facades), which in a complete implementation would be responsible for isolating and orchestrating communication across contexts.

#### Database queries
The database queries operating on dates use simplified comparisons (<, =) and ignore the time component. As a result, results may be inaccurate in edge cases (e.g. invoices paid on the same day but at different hours). A complete version should handle time precision more carefully or leverage proper database functions.

#### Warning reporting
The project currently implements only a basic report of the number of newly generated warnings. Requirements regarding sustained or closed warnings are missing. Given the 3-hour timeframe for the task, there was not enough time to implement these features, so this area remains incomplete.

#### Tests
Instead of fixtures, a functional test was created to verify the key application scenarios: overdue invoices, contractors with high debt, and budgets with negative balances. However, the test is still not exhaustive and would need to be extended in a production-ready solution.
