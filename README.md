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
## 🧪 How to Test the Flow
1. Fill out and submit the form on the homepage (index.php).
2. Email gets saved in pending_subscriptions.txt.
3. Cron processes the task and sends a verification email.
4. Click the link to verify (verify.php) and get added to subscribers.txt.
5. Use unsubscribe.php to opt out.
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
## 🙋‍♂️ Contributing
Pull requests and issues are welcome! Please feel free to open a discussion if you'd like to suggest changes.
## 📄 License
This project is open-sourced under the MIT License.
