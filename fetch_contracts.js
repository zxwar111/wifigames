// This function fetches and displays contracts on the Browse Contracts page
function fetchContracts() {
    const contractList = document.querySelector('.contract-list');

    // Fetch contracts from the server (you need to implement this endpoint)
    fetch('fetch_contracts.php')
        .then(response => response.json())
        .then(contracts => {
            // Iterate through contracts and create contract entries
            contracts.forEach(contract => {
                const contractEntry = document.createElement('div');
                contractEntry.classList.add('contract-entry');

                // Fill in contract details (adjust this part as needed)
                contractEntry.innerHTML = `
                    <h3>${contract.target}</h3>
                    <p><strong>Location:</strong> ${contract.location}</p>
                    <p><strong>Objectives:</strong> ${contract.objectives}</p>
                    <p><strong>Reward:</strong> $${contract.reward}</p>
                `;

                contractList.appendChild(contractEntry);
            });
        })
        .catch(error => console.error('Error fetching contracts:', error));
}

// Call the function to fetch and display contracts when the page loads
window.onload = fetchContracts;
