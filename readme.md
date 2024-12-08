Application Workflow  :

1. User Authentication
Step 1: A user registers or logs into the system using credentials via use laravel auth ui.
Step 2: If two-factor authentication (2FA) is enabled:
The system prompts the user to scan a QR code using their authenticator app.
The user inputs the generated 2FA code for verification.
On success, the user is redirected to the dashboard based on role .

Default admin is regisetered if any other user will register then role will be user .

Tools Used:
PragmaRX Google2FA Laravel for implementing 2FA.

2. Dashboard Overview
Step 1: After login, the user lands on the dashboard.
Step 2: The dashboard provides access to key features like:

For Users : Transfer history of his accounts ,Fund Transfer and Currency Transfer for changing the currency along with account details .
For Admin : In Dashboard functionlity to add multiple saving account with 10000$ default for users, User list with details , Accounts List along with history of transactaion  

Account Overview: Displays balance, recent transactions, and notifications.
Currency Exchange: Allows users to convert currency using real-time exchange rates fetched from external APIs.

3. Currency Exchange
Step 1: The user navigates to the "Currency Exchange" section.

Step 2: The system fetches real-time exchange rates using the custom CurrencyExchangeService.

Tools Used:
GuzzleHTTP for making API requests.
Laravel Service Class for separating business logic.
Step 3: The user selects the desired currency and initiates the exchange.

4. Front-End Interaction
Step 1: The front-end is powered by Bootstrap for a responsive design.
Step 2: Dynamic components are managed using JavaScript and npm-installed dependencies.
Commands Used: php artisan ui bootstrap --auth
bash
Copy code
npm install
npm run dev
Step 3: The application ensures smooth user interaction through AJAX and dynamic UI elements.

5. Error Handling and Logging
Step 1: All requests are validated before processing.
Step 2: Errors such as invalid 2FA codes or API failures are logged.
Tools Used:
Laravel Validation for request validation.
Laravel's built-in logging system for error tracking.

6. Admin Management (Optional)
Step 1: Admins can log in and access a dedicated panel.
Step 2: Admin capabilities include:
Managing user accounts.
Viewing and auditing transactions.
Configuring system settings.
