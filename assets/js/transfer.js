// Insecure AJAX call for transfers
function sendMoney() {
    const data = {
        to_account: document.getElementById('to_account').value,
        amount: document.getElementById('amount').value,
        description: document.getElementById('description').value
    };
    // No CSRF token included
    fetch('/api/transfer.php', {
        method: 'POST',
        body: JSON.stringify(data)
    });
}