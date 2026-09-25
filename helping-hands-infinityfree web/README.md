# Helping Hands Community Assist — Setup Guide

Every page on this site is PHP, sharing one database — there is no separate
"static" version and no `php-version` subfolder anymore. Whatever you type
into any form on this site is saved for real, in MySQL.

## Step-by-step setup (XAMPP)

1. **Install XAMPP** if you haven't already, and open the **XAMPP Control Panel**.
2. **Start Apache and MySQL** — click Start next to both; they should turn green.
3. **Copy this whole folder** into XAMPP's `htdocs` folder, e.g.:
   - Windows: `C:\xampp\htdocs\helping-hands\`
   - Mac: `/Applications/XAMPP/htdocs/helping-hands/`
4. **Visit `http://localhost/helping-hands/setup_local.php`** in your browser.
   This one page creates the `helpinghands_db` database and every table
   automatically — you only need to do this once.
5. **Visit `http://localhost/helping-hands/database_check.php`** to confirm
   the connection and see a live row-count for every table.
6. **Visit `http://localhost/helping-hands/view-data.php`** any time to see
   every account, request, volunteer application, contact message and
   newsletter sign-up actually stored in the database — a full read-only
   view, no phpMyAdmin required. It's also linked from your account page
   once you're logged in.
7. **Open `http://localhost/helping-hands/index.php`** — you're in.

## Seeing your data in phpMyAdmin too

`view-data.php` and phpMyAdmin are two different windows onto the exact
same database — they will always show identical data, since they're both
just reading from `helpinghands_db`.

Both `view-data.php` and `database_check.php` now have an **"Open in
phpMyAdmin"** button that takes you straight to `http://localhost/phpmyadmin/`.
From there:
1. Click **`helpinghands_db`** in the left-hand sidebar.
2. Click any table (e.g. `users`, `requests`, `volunteers`).
3. Click the **Browse** tab along the top — not **Structure**, which only
   ever shows column names and never your actual saved rows.

If you submit a form on the site and then immediately check phpMyAdmin's
Browse tab for the matching table, your new row will be there — that's
the direct proof the site is really saving to the database, not just
showing a success message.

Do not open any `.php` file by double-clicking it — PHP only runs through
Apache, so it must always be loaded via `http://localhost/...`.

## The full workflow, and where everything is saved

| Step | Page | Saved to |
|---|---|---|
| Create an account | `signup.php` | `users` table (password hashed) |
| Log in | `login.php` | starts your session |
| Submit a help request | `request.php` | `requests` table, status `Pending` |
| Apply to volunteer | `volunteer.php` | `volunteers` table |
| Accept an open request | `tasks.php` → Accept | `requests.status` → `Accepted` |
| Mark a task done | `tasks.php` → Mark Completed | `requests.status` → `Completed` |
| Send a message | `contact.php` | `contact_messages` table |
| Subscribe to updates | `resources.php` (bottom) | `newsletter_subscribers` table |
| Log out | `logout.php` | session cleared, confirmation shown |

Your homepage (`account.php`) always reflects the live database — refresh
it any time to see your current requests and volunteer status.

## Becoming a volunteer and accepting tasks

1. Sign up or log in.
2. Go to **Volunteer** in the nav, and complete the application form
   (areas, availability, emergency contact). This is a real form — it
   wasn't there in earlier versions of this design; the page used to only
   have a "Sign Up" button with no actual application behind it.
3. Once submitted, a **Task Centre** link appears in the navigation.
4. Open **Task Centre** to see open requests from other users, accept one,
   and mark it complete once you've helped.

## Security notes

- Passwords are hashed with `password_hash()` — never stored in plain text.
- Every form includes a CSRF token, checked on submit.
- `accept_task.php` uses an atomic database update, so two volunteers can
  never accidentally accept the same request at the same time.
- `setup_local.php`, `database_check.php` and `view-data.php` are
  diagnostic/setup tools —
  fine to keep for local development, but delete or rename them before any
  real public deployment.

## If something goes wrong

Every page shows a clear, styled error message (not a blank white page) if
the database connection fails — it will tell you exactly what to check
(is MySQL running? has `setup_local.php` been run? do the credentials in
`config.php` match your MySQL login?).

## One thing to check if you rename the folder

`.htaccess` points the custom 404 page at `/helping-hands/404.php`. If you
copy this project into a differently-named folder (not `helping-hands`),
open `.htaccess` and update that path to match, e.g. `/my-folder-name/404.php`.


DATABASE IMPORT ERROR FIX
If phpMyAdmin reports Error #1005 / errno 150 for the volunteers table, use the included schema.sql for a fresh installation. It resets only the Helping Hands tables and recreates the foreign keys with matching INT UNSIGNED columns and InnoDB. Do not use it on a live database containing data you need to keep.
