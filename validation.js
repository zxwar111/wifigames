function validateForm() {
    const target = document.getElementById("target").value;
    const location = document.getElementById("location").value;
    const objectives = document.getElementById("objectives").value;
    const reward = parseFloat(document.getElementById("reward").value); // Updated for decimal rewards
    const level = document.getElementById("level").value;
    const deadline = document.getElementById("deadline").value;
    const contractStatus = document.querySelector('input[name="contract-status"]:checked');

    if (target.trim() === "" || location.trim() === "" || isNaN(reward) || level.trim() === "" || deadline.trim() === "" || !contractStatus) {
        alert("Please fill in all required fields and ensure data format is correct.");
        return false;
    }

    if (reward < 0) {
        alert("Reward must be a non-negative number.");
        return false;
    }

    return true;
}
