# ERPGo SaaS — Project Guide and Verified Status

## 1. Project overview

ERPGo SaaS is a multi-company business management application built with Laravel. A platform-level Super Admin manages companies and subscription plans. Each company then operates its own accounting, CRM, HRM, payroll, recruitment, project management, support, and reporting workflows.

The application is currently configured locally at:

- Application URL: `http://localhost:8085`
- Application directory: `main_file`
- Runtime used during verification: PHP 8.0.30 with Microsoft SQL Server 2019
- Active application database: SQL Server database `erpgo_mssql`
- Retained rollback/source database: MariaDB database `test`

The installer has been completed and is locked using `storage/installed`.

## 2. Roles and responsibilities

### Super Admin

- Manages companies and SaaS users
- Creates subscription plans
- Reviews plan requests and orders
- Manages coupons
- Configures global system and email settings
- Controls the public landing page
- Configures supported payment gateways

### Company/Admin

- Runs an individual company's ERP workspace
- Manages employees, roles, and permissions
- Manages customers and vendors
- Handles accounts, invoices, bills, and expenses
- Operates CRM leads and deals
- Creates projects, tasks, timesheets, and bug reports
- Manages attendance, leave, payroll, and recruitment
- Views business and financial reports

### Employee/User

Access depends on assigned roles and permissions. Typical functions include:

- Assigned projects and tasks
- Timesheets and time tracking
- Attendance and leave
- Meetings and events
- HR documents
- Limited CRM or accounting access

### Client

- Views assigned projects
- Uses task boards and timesheets
- Reports bugs
- Creates and follows support tickets
- Views relevant deals and calendar entries

### Customer

The intended customer portal includes invoices, proposals, payments, transactions, and profile management. The current source copy has a broken customer login because `App\Http\Controllers\Auth\LoginController` is missing.

### Vendor

The intended vendor portal includes bills, payments, transactions, and profile management. Vendor login is currently broken for the same missing-controller reason.

## 3. SaaS operating model

```text
Super Admin creates a plan
        |
        v
Company registers/subscribes
        |
        v
Company configures users, branches, accounts, products, and taxes
        |
        +--> CRM converts leads into deals/customers
        |
        +--> Project teams complete work and record time
        |
        +--> Accounting issues invoices and records bills/payments
        |
        +--> HR manages attendance, payroll, and performance
        |
        v
Reports summarize company operations and finances
```

## 4. Accounting module

Features:

- Bank accounts and bank transfers
- Customers and vendors
- Products and services
- Product categories and units
- Taxes
- Revenue and expenses
- Proposals/quotations
- Invoices and customer payments
- Bills and vendor payments
- Credit notes and debit notes
- Chart of accounts
- Journal entries
- Assets
- Budget planning
- Financial reports
- Invoice, proposal, and bill templates
- QR codes and printable documents

Sales workflow:

```text
Customer -> Proposal -> Accepted proposal -> Invoice -> Payment -> Revenue/reporting
```

Purchase workflow:

```text
Vendor -> Bill -> Payment -> Expense/account transaction -> Reporting
```

## 5. CRM module

Features:

- Leads and lead stages
- Deals and sales pipelines
- Lead sources and labels
- Calls, emails, notes, files, and activities
- Deal products and tasks
- Client management
- Kanban-style pipeline management

Typical workflow:

```text
Lead source -> Lead -> Qualification -> Deal -> Won/Lost -> Customer/project/invoice
```

## 6. Project management

Features:

- Projects and project members
- Clients
- Milestones
- Tasks and task stages
- Kanban task board
- Priorities
- Checklists
- Comments and attachments
- Timesheets
- Project expenses
- Bug tracking
- Project activity history
- Calendar
- Per-user permissions

Project structure:

```text
Project
  |-- Team members
  |-- Milestones
  |-- Tasks
  |     |-- Checklists
  |     |-- Comments
  |     `-- Files
  |-- Timesheets/time tracker
  |-- Expenses
  `-- Bugs
```

The supplied desktop tracker is intended to let an employee select a project task, start a timer, and upload periodic screenshots.

## 7. HRM and payroll

Core HR features:

- Branches
- Departments
- Designations
- Employees
- Employee documents
- Company policies
- Attendance
- Leave types and leave requests
- Holidays
- Transfers
- Events, meetings, and announcements

Payroll features:

- Basic salary
- Allowances
- Commissions
- Loans
- Deductions
- Other payments
- Overtime
- Salary setup
- Monthly payslips
- Payroll reports

Conceptual calculation:

```text
Net salary = basic salary + allowances + commissions + overtime
             + other payments - loans - deductions
```

## 8. Performance and HR administration

Performance features:

- Goals and goal types
- Goal tracking
- Indicators
- Appraisals
- Competencies
- Performance types

Administration features:

- Awards
- Travel
- Promotions
- Complaints
- Warnings
- Resignations
- Terminations and termination types
- Training types, trainers, and training sessions

## 9. Recruitment

Features:

- Job categories
- Job stages
- Vacancies/jobs
- Public job pages
- Job applications
- Custom application questions
- CV/document upload
- Interview scheduling
- Candidate stage management

Workflow:

```text
Publish job -> Candidate applies -> Screening -> Interview -> Selection -> Employee
```

## 10. Other modules

### Form Builder

- Custom forms and fields
- Public shareable form links
- Form responses
- Field binding

### Support

- Support tickets
- Attachments and replies
- Ticket status tracking
- Company/client interaction

### Contracts

- Contract types
- Contracts
- Customer/project association
- Contract documents and status

### Communication and productivity

- Calendar
- Events and meetings
- Notifications
- Email templates
- To-do lists
- Internal chat
- Zoom meetings
- Telegram and Twilio integrations

## 11. Subscription and payment features

The SaaS layer supports:

- Free, trial, monthly, and yearly plans
- Company/user limits
- Customer/vendor limits
- Plan requests and manual approval
- Coupons
- Orders and payment history

Payment integrations found in the source include:

- Stripe
- PayPal
- Paytm
- Razorpay
- Paystack
- Mollie
- Skrill
- Mercado Pago
- Coingate
- Flutterwave
- PaymentWall

## 12. Features requiring external keys

The core application installation does **not** require an Envato or CodeCanyon purchase key. The installer's key-generation step generates Laravel's local `APP_KEY`; it is not a license key.

The following optional integrations require external credentials to work in production:

| Feature | Required configuration |
|---|---|
| Online payments | Merchant/API keys for the selected gateway |
| Zoom meetings | Zoom API credentials |
| Twilio | Twilio account credentials and number |
| Telegram | Telegram bot token/chat configuration |
| Realtime chat | Pusher-compatible credentials |
| reCAPTCHA | Site key and secret |
| Email | SMTP host, port, username, password, and sender |

Pages for these integrations may render without keys, but the external operation cannot complete until valid credentials are configured.

## 13. Local test accounts

Seeded application accounts:

| Role | Email | Password |
|---|---|---|
| Super Admin | `superadmin@example.com` | `1234` |
| Company | `company@example.com` | `1234` |
| Accountant | `accountant@example.com` | `1234` |
| Client | `client@example.com` | `1234` |

Smoke-test records created without deleting existing data:

- Customer: `smoke.customer@example.test`
- Vendor: `smoke.vendor@example.test`

## 14. Verified working status

The following checks were performed against the running local application:

- Database migrations and seeders completed successfully
- 565 first-party PHP files passed syntax linting
- Super Admin authentication and 8 main screens rendered
- Company authentication and 132 authorized screens rendered with HTTP 200
- Accountant authentication and 40 authorized screens rendered with HTTP 200
- Client authentication and 10 authorized screens rendered with HTTP 200
- Customer and vendor records were created when all billing/shipping fields were supplied
- API login successfully issued a Sanctum token
- Authenticated `GET /api/get-projects` returned successfully
- Production npm dependency audit reported no production vulnerabilities
- Installer is locked after setup

A screen returning HTTP 200 confirms that it loads; it does not prove every button, validation branch, external API, or complete business transaction on that screen.

## 15. Confirmed defects

### Missing controllers

- `HomeController` is referenced by `/` and `/home` but is absent
- `Auth\LoginController` is referenced by customer/vendor login and password-reset routes but is absent
- `php artisan route:list` fails because of the missing `HomeController`

### Dead route actions

Live HTTP 500 responses were confirmed for:

- `/report/invoice-report`
- `/users-view`
- `/checkuserexists`
- `/expense-list`
- `/timesheet-view`
- `/search`
- `/1/notification/seen`
- `/plan/coingate/1`
- `/api/stop-tracker`

These routes point to missing controller methods or missing controllers.

### Customer/vendor problems

- Customer and vendor login portals return HTTP 500
- Create forms do not provide a password field although controllers hash the submitted password
- Billing/address fields appear optional in the UI, but blank values cause a database `NOT NULL` error
- Supplying all billing and shipping fields allows record creation

### Logout problem

The header contains duplicate `frm-logout` element IDs and invalid/nested form markup. A live click test left the user on the dashboard instead of logging out.

### Time tracker/API problems

- `POST /api/stop-tracker` points to a missing `ApiController::stopTracker` method
- Tracker image view/removal and tracker deletion routes lack explicit authentication middleware
- Tracker deletion methods do not verify record ownership

### Other dead actions found by route cross-check

Routes reference absent methods in several controllers, including report, expense, project, form builder, timesheet, user, and Coingate payment controllers. These need to be reconciled before production deployment.

## 16. Security findings

Important findings requiring remediation before internet-facing deployment:

- User and client password-reset update routes are not protected by authentication middleware
- Password-reset update methods accept a numeric record ID directly
- Multiple CRM and project write/delete routes lack explicit route-level authentication
- Product, customer, and vendor import routes lack explicit authentication middleware
- Time-tracker image and deletion routes lack authentication and ownership checks
- Several record actions appear susceptible to insecure direct object reference (IDOR)
- Upload validation and file handling need hardening
- Frontend confirmation handlers use dynamic JavaScript `eval()`
- PaymentWall and Paytm callbacks are excluded from CSRF protection; callback signatures must therefore be verified carefully

No first-party Envato activation callback, purchase-code checker, obvious obfuscated PHP payload, or hardcoded production API credential was found during the scan.

## 17. Dependency status

- Production npm audit: clean at the time of verification
- Full development audit: 66 advisories
  - 9 critical
  - 39 high
  - 12 moderate
  - 6 low
- Direct development packages with reported advisories included Axios, Laravel Mix, Lodash, PostCSS, and PostCSS Import

Dependency upgrades should be tested carefully because this is an older Laravel application and major-version upgrades may introduce compatibility changes.

## 18. Production-readiness priority

Recommended order of work:

1. Restore or replace missing controllers and dead controller methods
2. Fix Customer and Vendor portal authentication
3. Protect all private mutation routes with authentication, authorization, and ownership checks
4. Secure password-reset flows using signed, expiring tokens
5. Fix logout form markup
6. Align customer/vendor form validation with database constraints
7. Harden uploads and remove dynamic `eval()` usage
8. Upgrade vulnerable development dependencies
9. Configure and sandbox-test only the external integrations that will be retained
10. Run end-to-end tests for accounting, payroll, CRM, project, and recruitment workflows

## 19. Replacement-feature decision

No source feature has been removed. Before replacing any key-dependent integration, record the decision in this format:

```text
Existing feature -> Replacement feature
Reason:
Required behavior:
Migration/data impact:
```

Example:

```text
Zoom -> Jitsi Meet
Reason: Avoid paid API credentials
Required behavior: Create meeting links and associate them with users/projects
Migration/data impact: Preserve existing meeting records where possible
```

## 20. Microsoft SQL Server migration status

The local application has been switched from MariaDB to Microsoft SQL Server. The original MariaDB database was not modified or deleted and remains available as the rollback/source copy.

### Active connection

- App URL: `http://localhost:8085`
- Laravel driver: `sqlsrv`
- SQL Server host/port: `localhost:1433`
- Database: `erpgo_mssql`
- Application login: `erpgo_app`
- Credentials are stored in `main_file/.env`; do not commit that file or publish its password.
- The former MariaDB connection is retained in the `MYSQL_SOURCE_*` variables in `.env`.

The PHP 8.0 runtime loads Microsoft's `sqlsrv` and `pdo_sqlsrv` extensions. Any Apache, IIS, scheduled-job, or queue-worker PHP runtime must load the same extensions before deployment.

### Migration and data-copy result

- All application migrations completed on SQL Server. Laravel records 185 migration rows (179 migration files plus migrations generated/provided by dependencies or batches).
- Seeders completed successfully.
- 167 source tables were copied with identity values preserved.
- Final comparison: 167 tables checked, 0 row-count mismatches.
- Financial aggregate comparison: 0 mismatches across revenue, payment, transaction, invoice-product, and bill-product amount/quantity fields.
- Current copied reference counts include 7 users, 475 permissions, and 1,059 role-permission records.

Reusable scripts:

- `main_file/scripts/migrate_mysql_to_mssql.php` recreates the target data copy. It deletes/replaces rows in the configured MSSQL target, so use it only for an intentional refresh.
- `main_file/scripts/compare_mysql_mssql.php` performs a read-only row-count and financial-total comparison.

Both scripts read the MariaDB source from `MYSQL_SOURCE_*`. The MSSQL target credentials must be supplied as `MSSQL_HOST`, `MSSQL_PORT`, `MSSQL_DATABASE`, `MSSQL_USERNAME`, and `MSSQL_PASSWORD` environment variables.

### Database-independent code changes

- MySQL `ON DUPLICATE KEY UPDATE` statements were replaced with Laravel `updateOrInsert()` calls.
- MySQL-only `FIND_IN_SET()` usage now uses a driver-aware helper (`STRING_SPLIT` on SQL Server).
- Backtick-based date expressions were replaced with Laravel `whereYear()`, `whereMonth()`, and `whereDate()`.
- Report queries now group by their actual expressions/selected columns, as required by SQL Server.
- Migrations that altered defaulted columns now handle SQL Server default constraints.
- Unsupported timestamp precision and oversized indexed message columns were made SQL Server compatible.

### Functional verification on SQL Server

- Authenticated navigation sweep: Super Admin 12/12, Company 118/118, Accountant 40/40, Client 11/11 pages returned without server errors.
- Company settings write/update test completed successfully and the temporary test rows were removed afterward.
- Production URL login, Project Dashboard, Profit & Loss, Trial Balance, and Company Settings were rechecked after the final `.env` switch and returned HTTP 200.
- Missing `HomeController` routes were redirected to the existing dashboard controller; `/home` now works instead of returning HTTP 500.
- Customer/vendor portal routes now use the existing `AuthenticatedSessionController`; their login and password-reset pages return HTTP 200.
- Invalid customer/vendor credentials now return validation errors instead of calling a missing method and producing HTTP 500.
- Inactive customer/vendor authentication is stopped safely before attempting to update a logged-out user.
- Duplicate/nested logout forms were corrected, and an authenticated logout POST was verified successfully.

External payment gateways, email/SMS delivery, Zoom, Slack, Telegram, and similar integrations still require valid third-party credentials and were not charged/called during local testing.

## 21. Source integrity and copyright audit

The first-party PHP/application folders were scanned for common nulled or malicious-code indicators: encoded loaders, `eval`, `gzinflate`, `gzuncompress`, `str_rot13`, shell/process execution, Envato purchase-code bypasses, remote activation callbacks, and ionCube payloads. No obvious PHP backdoor, encoded loader, purchase-code bypass, or first-party activation callback was found. The legitimate Base64 decode in `ApiController` handles a time-tracker screenshot supplied by the client; it is not an encoded PHP loader. A JavaScript `eval()` in the time-tracker image confirmation dialog was removed and replaced with strict numeric action parsing.

This technical scan cannot prove legal ownership or prove that an archive was never modified. `composer.json` declaring MIT applies to the Composer project metadata/dependency context and must not be treated as proof that the purchased ERPGo product itself can be freely redistributed. Third-party libraries and fonts retain their own notices; examples found include Laravel/Composer packages, Font Awesome, Bootstrap, jQuery, Owl Carousel, Poppins, and Montserrat.

## 22. Plan and upgrade system

The plan system is the SaaS subscription/feature-limit layer:

1. The Super Admin manages plans at `/plans` through `PlanController`. A plan stores price, duration, limits for users/clients/customers/vendors, and Account/CRM/HRM/Project module flags.
2. A company sees available plans on the same plans page. A paid plan opens the checkout page and can use an enabled gateway; a company can alternatively submit a manual plan request.
3. Manual requests are stored in `plan_requests`. The Super Admin reviews them at `/plan_request`, then accepts or rejects them.
4. Successful gateway callbacks or a Super Admin approval call `User::assignPlan()` and create an `orders` audit record.
5. `assignPlan()` updates `users.plan`, calculates `plan_expire_date` for monthly/yearly plans, and enforces the selected plan's account limits by activating/deactivating only that company's records.
6. Employee, client, customer, and vendor creation controllers compare current counts with plan limits and show “Please upgrade plan” when the limit is reached.

Current local data contains one zero-price `Free Plan`; all three company accounts use it. There are currently no plan requests and no orders. No paid gateway is configured/tested, so a real paid upgrade cannot complete until a gateway and its verified callback credentials are configured.

Plan bugs fixed during this audit:

- Plan assignment is now tenant-scoped; upgrading one company cannot activate/deactivate another company's users or clients.
- Unlimited plans now clear an older expiry date.
- Manual company upgrades require Super Admin authorization and a real company/plan record.
- Upgrade/request/approve/reject/cancel mutations now use CSRF-protected POST requests instead of GET links.
- A company can cancel only its own plan request.
- Invalid approval responses are rejected.
- Plan-request list fields now use the real `max_users` and `max_clients` columns and skip orphan records safely.

Verified after these changes: Super Admin Plans, Plan Requests, Users, and Company Plans pages return HTTP 200; manual upgrade GET returns 405, and a company attempting the Super Admin upgrade POST receives 403.
