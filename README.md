# PHP Task Scheduler

A lightweight PHP-based task scheduler with email subscription, verification, and automatic processing powered by cron jobs. Perfect for small-scale projects or as a learning tool for task automation in PHP.

---

## 📌 Features

- ✅ Email subscription with pending state
- 📬 Email verification and unsubscribe support
- ⏱️ Automatic task execution using cron
- 💾 JSON-based file storage (no database required)
- 🧩 Modular and clean PHP codebase

---

## ⚙️ Tech Stack

- PHP (Core logic and APIs)
- Shell Script (Cron automation)
- JSON (Data storage)
- Cron (Linux scheduler)

---

## 🚀 Getting Started Locally

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/php-task-scheduler.git
cd php-task-scheduler/src
```
### 2. Start Local PHP Server
```bash
php -S localhost:8000
```
Open your browser and navigate to http://localhost:8000
### 3. Set Up Cron Job
```bash
chmod +x setup_cron.sh
./setup_cron.sh
```

---

## 🧪 How to Test the Flow
### Task Management
- Add a task using the form input (#task-name) and button (#add-task)
- View tasks under .tasks-list > .task-item
- Mark complete using .task-status checkbox
- Delete using .delete-task button
### Email Subscription
- Submit your email using the input (name="email") and button (#submit-email)
- A verification email will be sent with a 6-digit code and link
- Clicking the link will verify your subscription
### Task Reminder
- The CRON job (cron.php) sends hourly emails to verified subscribers
- Email includes pending tasks and an unsubscribe link
### Unsubscribe
- Click the unsubscribe link in any reminder email
- The email will be removed from the subscribers list

---

## 🗂️ File Structure
```bash
php-task-scheduler/
├── src/
│   ├── index.php               # Subscription form UI
│   ├── functions.php           # Core logic
│   ├── cron.php                # Executes scheduled tasks
│   ├── unsubscribe.php         # Handles unsubscription
│   ├── verify.php              # Email verification
│   ├── setup_cron.sh           # Cron job setup
│   ├── pending_subscriptions.txt
│   ├── subscribers.txt
│   ├── tasks.txt
└── README.md
```

---

## 🧪 Test Emails Locally
Use Mailpit to test email functionality:
```bash
# Start Mailpit
mailpit
```
- Mailpit runs on http://localhost:8025
- Check emails like verification or task reminders there

---

## 📜 Data Format
All storage files use JSON format.
### 📁 tasks.txt
```bash
[
  { "id": "uuid1", "name": "Buy groceries", "completed": false },
  { "id": "uuid2", "name": "Read book", "completed": true }
]
```
### 📁 subscribers.txt
```bash
["user1@example.com", "user2@example.com"]
```
### 📁 pending_subscriptions.txt
```bash
{
  "user1@example.com": {
    "code": "123456",
    "timestamp": 1717694230
  }
}
```
## 📧 Email Content Format
### ✅ Verification Email
- Subject: Verify subscription to Task Planner
- Body:
```bash
<p>Click the link below to verify your subscription to Task Planner:</p>
<p><a id="verification-link" href="{verification_link}">Verify Subscription</a></p>
```
### ✅ Reminder Email
- Subject: Task Planner - Pending Tasks Reminder
- Body:
```bash
<h2>Pending Tasks Reminder</h2>
<p>Here are the current pending tasks:</p>
<ul>
  <li>Task 1</li>
  <li>Task 2</li>
</ul>
<p><a id="unsubscribe-link" href="{unsubscribe_link}">Unsubscribe from notifications</a></p>
```

---

## 🙋‍♂️ Contributing
Pull requests and issues are welcome! Please feel free to open a discussion if you'd like to suggest changes.

---

## 📄 License
This project is open-sourced under the MIT License.
